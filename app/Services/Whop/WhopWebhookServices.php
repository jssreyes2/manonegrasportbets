<?php

namespace App\Services\Whop;

use App\Jobs\SendEmailJob;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Pick;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Register\PlanServices;
use App\Services\SendMailServices;
use App\Services\User\SubscriptionServices;
use Carbon\Carbon;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Matchable\Whop\WhopApiClient;
use Throwable;


class WhopWebhookServices
{
    // Margen permitido entre el timestamp del webhook y la hora del servidor
    private const SIGNATURE_TOLERANCE_SECONDS = 300;

    // Tiempo que se reutiliza el enlace de pago generado para un usuario y plan
    private const CHECKOUT_TTL_MINUTES = 30;
    
    public function createCheckout(array $data, $whop)
    {
        $planActive = $this->verifyPlanActive($data['plan_slug']);
        
        if (isset($planActive['plans'][0]) && count($planActive['plans'][0]) > 0) {
            $mensaje = __t('text.backend.messages.has_a_plan', 'Usted ya posee el plan') . ' ' . strtoupper($data['plan_slug']) . ' ' . __t('text.backend.messages.has_a_plan_1', 'y se encuentra activo, no es necesario realizar el pago de nuevo.');
            return view('dashboard.views.checkout-error', [
                'mensaje'      => $mensaje,
                'cerrar_popup' => true
            ]);
        }
        
        try {
            $plan = app(PlanServices::class)->getPlans(['source' => $data['plan_slug'], 'is_active' => true])->first();
            
            if (!$plan) {
                return view('dashboard.views.checkout-error', [
                    'mensaje'      => __t('text.backend.messages.plan_not_available', 'El plan no está disponible'),
                    'cerrar_popup' => true
                ]);
            }
            
            // Un solo checkout pendiente por usuario y plan: doble clic u otra pestaña reutilizan el mismo enlace
            $cacheKey    = 'whop_checkout:' . auth()->id() . ':' . $plan->source;
            $checkoutUrl = Cache::lock($cacheKey . ':lock', 15)->block(10, function () use ($cacheKey, $whop, $plan) {
                return Cache::remember($cacheKey, now()->addMinutes(self::CHECKOUT_TTL_MINUTES), function () use ($whop, $plan) {
                    $checkout = $whop->checkouts->create([
                        'currency' => 'usd',
                        'plan'     => [
                            'initial_price' => $plan->price,
                            'plan_type'     => 'one_time',
                            'company_id'    => config('whop.whop_company_id'),
                            'currency'      => 'usd',
                        ],

                        'metadata' => [
                            'website_user_id' => auth()->id(),
                            'website_plan'    => $plan->source,
                        ]
                    ]);

                    return $checkout->purchaseUrl ?? null;
                });
            });
            
            if (!$checkoutUrl) {
                return view('dashboard.views.checkout-error', [
                    'mensaje'      => __t('text.backend.messages.invalid_payment', 'No se pudo generar el enlace de pago'),
                    'cerrar_popup' => true
                ]);
            }
            
            return redirect()->away($checkoutUrl);
            
        } catch (\Throwable $e) {
            
            Log::error('Error en checkout: ' . $e->getMessage(), [
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ]);
            
            return view('dashboard.views.checkout-error', [
                'mensaje'      => __t('text.backend.messages.error_invalid_payment', 'Error al procesar el pago, intente de nuevo'),
                'cerrar_popup' => true
            ]);
        }
    }
    
    
    public function handle(Request $request): Response
    {
        $payload = $request->getContent();

        if (!$this->verifySignature(
            $payload,
            $request->header('webhook-id'),
            $request->header('webhook-timestamp'),
            $request->header('webhook-signature')
        )) {
            Log::warning('Webhook de Whop con firma inválida');

            return response('Invalid signature', 401);
        }

        $event = json_decode($payload, true);

        if (!is_array($event)) {
            return response('Invalid JSON', 400);
        }

        $eventType = $event['type'] ?? null;
        $data      = $event['data'] ?? [];
        $eventId   = $event['id'] ?? null;

        if (!$eventType || !$eventId || !is_array($data)) {
            return response('Invalid event', 400);
        }

        // Evita procesar el mismo webhook dos veces (chequeo rápido, el índice unique cubre la concurrencia)
        if (DB::table('whop_webhook_events')->where('event_id', $eventId)->exists()) {
            return response('Already processed', 200);
        }

        try {
            $afterCommit = DB::transaction(function () use ($eventId, $eventType, $data): ?\Closure {

                // Registramos el evento primero: si llega un duplicado concurrente, el unique lo rechaza
                DB::table('whop_webhook_events')->insert([
                    'event_id'   => $eventId,
                    'event_type' => $eventType,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                return match ($eventType) {
                    'payment.succeeded'      => $this->handlePaymentSucceeded($eventId, $data),
                    'membership.deactivated' => $this->deactivateUser($eventId, $data),
                    default                  => $this->logUnhandledEvent($eventType),
                };
            });

            // El correo se envía solo cuando la activación ya quedó confirmada en BD
            if ($afterCommit) {
                $afterCommit();
            }

            return response('OK', 200);
        } catch (UniqueConstraintViolationException) {
            return response('Already processed', 200);
        } catch (Throwable $exception) {
            Log::error('Error procesando webhook de Whop', [
                'message'    => $exception->getMessage(),
                'event_id'   => $eventId,
                'event_type' => $eventType,
                'trace'      => $exception->getTraceAsString(),
            ]);

            return response('Webhook error', 500);
        }
    }

    private function handlePaymentSucceeded(string $eventId, array $data): ?\Closure
    {
        $total = (float)($data['total'] ?? 0);

        if ($total <= 0) {
            Log::info('Pago de Whop con monto inválido', [
                'event_id' => $eventId,
                'total'    => $data['total'] ?? null,
            ]);

            return null;
        }

        $payment = $this->createPayment($data);

        if ($payment->substatus !== Payment::PAYMENT_SUCCESS) {
            Log::info('Pago no exitoso', [
                'event_id'  => $eventId,
                'substatus' => $payment->substatus ?? 'null',
            ]);

            return null;
        }

        $userId = $payment->website_user_id;

        if ($userId) {
            DB::table('whop_webhook_events')
                ->where('event_id', $eventId)
                ->update(['user_id' => $userId]);
        }

        return $this->activateUser($data, $userId, $payment->website_plan);
    }

    private function createPayment(array $data): Payment
    {
        return Payment::updateOrCreate(
            ['payment_id' => $data['id']],
            [
                'status'    => $data['status'] ?? '',
                'substatus' => $data['substatus'] ?? null,
                'total'     => $data['total'] ?? 0,
                'currency'  => $data['currency'] ?? '',
                'paid_at'   => isset($data['paid_at']) ? Carbon::parse($data['paid_at']) : null,

                'whop_user_id' => data_get($data, 'user.id', ''),
                'username'     => data_get($data, 'user.username'),
                'plan_id'      => data_get($data, 'plan.id', ''),
                'company_id'   => data_get($data, 'company.id', ''),

                'card_brand' => data_get($data, 'payment_method.card.brand'),
                'card_last4' => data_get($data, 'payment_method.card.last4'),

                'website_plan'    => data_get($data, 'metadata.website_plan'),
                'website_user_id' => data_get($data, 'metadata.website_user_id'),
            ]
        );
    }

    private function activateUser(array $payment, ?int $userId, ?string $planSlug): ?\Closure
    {
        if (!$userId || !$planSlug) {
            Log::warning('Pago Whop sin datos suficientes para activar usuario', [
                'payment_id'        => $payment['id'] ?? null,
                'metadata'          => $payment['metadata'] ?? null,
                'user_id_found'     => $userId,
                'plan_slug_found'   => $planSlug,
                'payment_data_keys' => array_keys($payment),
            ]);

            return null;
        }

        $plan = Plan::filter(['source' => $planSlug])->first();

        if (!$plan) {
            Log::warning('Plan de Whop desconocido', [
                'plan_slug' => $planSlug,
            ]);

            return null;
        }

        if (!$this->paymentMatchesPlan($payment, $plan)) {
            return null;
        }

        $user = User::find($userId);

        if (!$user) {
            Log::warning('Usuario de pago Whop no encontrado', [
                'user_id' => $userId,
            ]);

            return null;
        }

        $membershipId = data_get($payment, 'membership.id') ?? data_get($payment, 'member.id') ?? data_get($payment, 'subscription.id');

        // Serializa los pagos del mismo usuario: dos webhooks simultáneos no deben leer la suscripción a la vez
        User::whereKey($user->id)->lockForUpdate()->first();

        // Una sola suscripción por usuario y plan: cada compra one_time trae un membership_id distinto
        $subscription = Subscription::where('user_id', $user->id)
            ->where('subscription_plan', $planSlug)
            ->latest('id')
            ->first();

        $now     = now();
        $isElite = (int)$plan->id === Plan::ID_PLAN_ELITE;

        // Elite vence en su día de servicio (sigue vigente todo ese día); los demás planes vencen al iniciar su fecha
        $isCurrent = $subscription
            && $subscription->subscription_status === Subscription::STATUS_ACTIVE
            && $subscription->subscription_expires_at
            && ($isElite
                ? $subscription->subscription_expires_at->greaterThanOrEqualTo($now->copy()->startOfDay())
                : $subscription->subscription_expires_at->greaterThan($now));

        // No se permite comprar un plan vigente: el checkout ya lo bloquea, esto cubre pagos de checkouts abiertos a la vez
        if ($isCurrent) {
            Log::warning('Pago duplicado de un plan vigente, se reembolsa', [
                'payment_id' => $payment['id'] ?? null,
                'user_id'    => $user->id,
                'plan'       => $planSlug,
                'expires_at' => $subscription->subscription_expires_at,
            ]);

            $expiresAt = $subscription->subscription_expires_at;

            return fn() => $this->refundDuplicatePayment($payment, $user, $plan, $expiresAt);
        }

        Cache::forget('whop_checkout:' . $user->id . ':' . $planSlug);

        // Si el pick Elite de hoy ya fue publicado, el plan Elite empieza a contar desde mañana
        $startDate      = $isElite ? Subscription::nextEliteDay() : $now;
        $expirationDate = $startDate->copy()->addDays((int)$plan->duration_days)->startOfDay();

        $attributes = [
            'payment_date'            => now(),
            'subscription_status'     => Subscription::STATUS_ACTIVE,
            'subscription_plan'       => $planSlug,
            'whop_membership_id'      => $membershipId,
            'subscription_expires_at' => $expirationDate,
        ];

        // Renovación de un plan ya vencido: arranca un ciclo nuevo sin el estado de picks del anterior
        if ($subscription) {
            $subscription->winner          = null;
            $subscription->sure_bettor     = null;
            $subscription->sure_bettor_day = null;
            $subscription->quantity_pick   = null;
            $subscription->send_email      = null;
        }

        if ($subscription) {
            $subscription->update($attributes);
        } else {
            $subscription = Subscription::create(['user_id' => $user->id] + $attributes);
        }

        Log::info('Usuario activado correctamente', [
            'user_id'       => $user->id,
            'plan'          => $planSlug,
            'expires_at'    => $subscription->subscription_expires_at,
            'membership_id' => $membershipId,
        ]);

        return fn() => $this->sendActivationMail($user, $plan, $expirationDate);
    }

    private function refundDuplicatePayment(array $payment, User $user, Plan $plan, Carbon $expiresAt): void
    {
        $error = null;

        try {
            app(WhopApiClient::class)->payments->refund($payment['id']);

            // Así no se cuenta como pago exitoso en los reportes
            Payment::where('payment_id', $payment['id'])->update(['substatus' => Payment::PAYMENT_REFUNDED]);

            Log::info('Pago duplicado reembolsado', ['payment_id' => $payment['id']]);
        } catch (Throwable $e) {
            // El pago ya quedó registrado; si falla el reembolso se debe hacer manualmente desde Whop
            $error = $e->getMessage();

            Log::error('No se pudo reembolsar el pago duplicado', [
                'payment_id' => $payment['id'] ?? null,
                'message'    => $error,
            ]);
        }

        $this->sendRefundNotice($payment, $user, $plan, $expiresAt, $error);
    }

    private function sendRefundNotice(array $payment, User $user, Plan $plan, Carbon $expiresAt, ?string $error): void
    {
        $email = config('app.mail_refund_notify');

        if (!$email) {
            return;
        }

        $subject = ($error ? 'Reembolso FALLIDO de pago duplicado - ' : 'Reembolso de pago duplicado - ') . $plan->name;

        $lines = [
            $error
                ? 'No se pudo reembolsar automáticamente un pago duplicado. Debe reembolsarse manualmente desde Whop.'
                : 'Se reembolsó automáticamente un pago duplicado de un plan que el cliente ya tenía vigente.',
            'Cliente: ' . e(capitalize_first($user->profile?->first_name) . ' ' . capitalize_first($user->profile?->last_name)) . ' (' . e($user->email) . ')',
            'Plan: ' . e($plan->name) . ', vigente hasta el ' . $expiresAt->format('d/m/Y'),
            'Pago Whop: ' . e($payment['id'] ?? '-') . ' por ' . e($payment['total'] ?? '-') . ' ' . e(strtoupper((string)($payment['currency'] ?? ''))),
        ];

        if ($error) {
            $lines[] = 'Error: ' . e($error);
        }

        // El reembolso ya se hizo o se intentó: un fallo del correo no debe afectar al webhook
        try {
            SendEmailJob::dispatch([
                'name'      => 'Administrador',
                'email'     => $email,
                'subject'   => $subject,
                'message'   => implode('<br>', $lines),
                'plan_name' => $plan->name,
            ])->onQueue('email-notifications');
        } catch (Throwable $e) {
            Log::error('No se pudo enviar el aviso de reembolso', [
                'payment_id' => $payment['id'] ?? null,
                'message'    => $e->getMessage(),
            ]);
        }
    }

    private function paymentMatchesPlan(array $payment, Plan $plan): bool
    {
        $companyId = data_get($payment, 'company.id');
        $currency  = strtolower((string)($payment['currency'] ?? ''));
        $total     = (float)($payment['total'] ?? 0);

        $errors = [];

        if ($companyId !== config('whop.whop_company_id')) {
            $errors[] = 'company';
        }

        if ($currency !== Plan::CURRENCY_USD) {
            $errors[] = 'currency';
        }

        // Tolerancia de un centavo por redondeos
        if ($total + 0.01 < (float)$plan->price) {
            $errors[] = 'total';
        }

        if ($errors) {
            Log::warning('Pago de Whop no coincide con el plan', [
                'payment_id' => $payment['id'] ?? null,
                'errors'     => $errors,
                'company_id' => $companyId,
                'currency'   => $currency,
                'total'      => $total,
                'plan_price' => $plan->price,
                'plan'       => $plan->source,
            ]);

            return false;
        }

        return true;
    }

    private function sendActivationMail(User $user, Plan $plan, Carbon $expirationDate): void
    {
        try {
            $data['name']      = capitalize_first($user->profile?->first_name) . ' ' . capitalize_first($user->profile?->last_name);
            $data['email']     = $user->email;
            $data['plan_name'] = $plan->name;

            $subject = __t('text.email.pay_subcription.subject');
            $subject = str_replace(
                ['[NAME_PLAN]'],
                [$plan->name],
                $subject
            );

            $data['subject'] = $subject;

            $messageText = __t('text.email.pay_subcription.body_text');
            $messageText = str_replace(
                ['[USER_NAME]', '[NAME_PLAN]', '[EXPIRATION_DATE]'],
                [$data['name'], $plan->name, $expirationDate->format('d/m/Y')],
                $messageText
            );

            $data['message'] = $messageText;
            $data['bcc']     = config('app.mail_copy_ocult');

            $notification = Notification::notificationCreate([
                'user_id'   => $user->id,
                'channel'   => Notification::CHANNEL_EMAIL,
                'type'      => Notification::TYPE_SUBSCRIPTION,
                'addressee' => $user->email,
                'subject'   => $subject,
                'content'   => $messageText,
            ]);

            $data['tracking_token'] = $notification?->tracking_token;

            (new SendMailServices())->sendMailNotification($data);
        } catch (Throwable $exception) {
            // La suscripción ya está activa: un fallo de correo no debe provocar reintentos del webhook
            Log::error('Error enviando correo de activación Whop', [
                'user_id' => $user->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    private function deactivateUser(string $eventId, array $data): ?\Closure
    {
        $membershipId = data_get($data, 'membership.id')
                        ?? data_get($data, 'id');

        if (!$membershipId) {
            Log::warning('Desactivación sin membership_id', [
                'data' => $data,
            ]);
            return null;
        }

        $subscription = Subscription::where('whop_membership_id', $membershipId)->first();

        if (!$subscription) {
            Log::warning('Suscripción no encontrada para desactivar', [
                'membership_id' => $membershipId,
            ]);
            return null;
        }

        $subscription->update([
            'subscription_status' => Subscription::STATUS_EXPIRED,
        ]);

        DB::table('whop_webhook_events')
            ->where('event_id', $eventId)
            ->update(['user_id' => $subscription->user_id]);

        Log::info('Suscripción desactivada correctamente', [
            'user_id'         => $subscription->user_id,
            'subscription_id' => $subscription->id,
            'membership_id'   => $membershipId,
        ]);

        return null;
    }

    private function logUnhandledEvent(string $eventType): ?\Closure
    {
        Log::info('Evento de Whop no manejado', [
            'event_type' => $eventType,
        ]);

        return null;
    }

    private function verifySignature(string $payload, ?string $webhookId, ?string $timestamp, ?string $signatureHeader): bool
    {
        $secret = config('services.whop.webhook_secret');

        if (!$secret || !$webhookId || !$timestamp || !$signatureHeader) {
            Log::warning('Faltan datos para verificar la firma de Whop', [
                'has_secret'    => !empty($secret),
                'has_id'        => !empty($webhookId),
                'has_timestamp' => !empty($timestamp),
                'has_signature' => !empty($signatureHeader),
            ]);
            return false;
        }

        // Rechaza webhooks antiguos o del futuro (protección contra replay)
        if (!ctype_digit($timestamp) || abs(time() - (int)$timestamp) > self::SIGNATURE_TOLERANCE_SECONDS) {
            Log::warning('Timestamp de webhook Whop fuera de tolerancia', [
                'timestamp' => $timestamp,
            ]);
            return false;
        }

        $signedContent = "{$webhookId}.{$timestamp}.{$payload}";

        $expectedSignature = base64_encode(
            hash_hmac('sha256', $signedContent, $secret, true)
        );

        // El header puede traer varias firmas separadas por espacio: "v1,xxx v1,yyy"
        foreach (explode(' ', trim($signatureHeader)) as $signature) {
            $parts             = explode(',', $signature, 2);
            $receivedSignature = count($parts) === 2 ? $parts[1] : $signature;

            if (hash_equals($expectedSignature, $receivedSignature)) {
                return true;
            }
        }

        Log::warning('Firma de Whop no coincide', [
            'webhook_id' => $webhookId,
        ]);

        return false;
    }

    private function verifyPlanActive($plan)
    {
        return app(SubscriptionServices::class)->getSubscriptionApproved($plan);
    }
}
