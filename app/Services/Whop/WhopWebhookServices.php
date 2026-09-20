<?php

namespace App\Services\Whop;

use App\Models\Notification;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use App\Services\Register\PlanServices;
use App\Services\SendMailServices;
use App\Services\User\SubscriptionServices;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class WhopWebhookServices
{
    
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
            
            // Ejemplo: Crear una configuración de pago / checkout session
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
            
            $checkoutUrl = $checkout->purchaseUrl ?? null;
            
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
        
        if (!$eventType || !$eventId) {
            return response('Invalid event', 400);
        }
        
        // Evita procesar el mismo webhook dos veces
        if (DB::table('whop_webhook_events')->where('event_id', $eventId)->exists()) {
            return response('Already processed', 200);
        }
        
        try {
            $total = (float)($data['total'] ?? 0);
            if ($total <= 0) {
                Log::info('Pago no exitoso o no encontrado', [
                    'event_id'  => $eventId,
                    'substatus' => $payment->substatus ?? 'null'
                ]);
                return response('OK (Payment not succeeded.The amount is invalid )', 200);
            }
            
            $payment = $this->createPayment($data);
            if (!$payment || $payment->substatus != 'succeeded') {
                Log::info('Pago no exitoso o no encontrado', [
                    'event_id'  => $eventId,
                    'substatus' => $payment->substatus ?? 'null'
                ]);
                return response('OK (Payment not succeeded)', 200);
            }
            
            DB::transaction(function () use ($eventId, $eventType, $data, $payment): void {
                
                // Registramos el evento
                DB::table('whop_webhook_events')->insert([
                    'event_id'   => $eventId,
                    'event_type' => $eventType,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                $userId = $payment->website_user_id;
                $plan   = $payment->website_plan;
                
                // Actualizamos el user_id en el evento registrado
                if ($userId) {
                    DB::table('whop_webhook_events')
                        ->where('event_id', $eventId)
                        ->update(['user_id' => $userId]);
                }
                
                switch ($eventType) {
                    case 'payment.succeeded':
                        $this->activateUser($data, $userId, $plan);
                        break;
                    
                    case 'membership.deactivated':
                        $this->deactivateUser($data);
                        break;
                    
                    default:
                        Log::info('Evento de Whop no manejado', [
                            'event_type' => $eventType,
                        ]);
                        break;
                }
            });
            
            return response('OK', 200);
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
    
    private function createPayment(array $data): Payment
    {
        return Payment::updateOrCreate(
            ['payment_id' => $data['id']],
            [
                'status'    => $data['status'] ?? null,
                'substatus' => $data['substatus'] ?? null,
                'total'     => $data['total'] ?? null,
                'currency'  => $data['currency'] ?? null,
                'paid_at'   => isset($data['paid_at']) ? Carbon::parse($data['paid_at']) : null,
                
                'whop_user_id' => $data['user']['id'],
                'username'     => $data['user']['username'] ?? null,
                'plan_id'      => $data['plan']['id'],
                'company_id'   => $data['company']['id'],
                
                'card_brand' => $data['payment_method']['card']['brand'] ?? null,
                'card_last4' => $data['payment_method']['card']['last4'] ?? null,
                
                'website_plan'    => $data['metadata']['website_plan'] ?? null,
                'website_user_id' => $data['metadata']['website_user_id'] ?? null,
            ]
        );
    }
    
    private function activateUser(array $payment, ?int $userId, ?string $planSlug): void
    {
        if (!$userId || !$planSlug) {
            Log::warning('Pago Whop sin datos suficientes para activar usuario', [
                'payment_id'        => $payment['id'] ?? null,
                'metadata'          => $payment['metadata'] ?? null,
                'user_id_found'     => $userId,
                'plan_slug_found'   => $planSlug,
                'payment_data_keys' => array_keys($payment),
            ]);
            
            return;
        }
        
        $plan = Plan::filter(['source' => $planSlug])->first();
        
        if (!$plan) {
            Log::warning('Plan de Whop desconocido', [
                'plan_slug'       => $planSlug,
                'available_plans' => array_keys(config('plans') ?? []),
            ]);
            
            return;
        }
        
        $user = User::find($userId);
        
        if (!$user) {
            Log::warning('Usuario de pago Whop no encontrado', [
                'user_id' => $userId,
            ]);
            
            return;
        }
        
        $baseDate = now();
        
        $membershipId = data_get($payment, 'membership.id') ?? data_get($payment, 'member.id') ?? data_get($payment, 'subscription.id');
        
        DB::transaction(function () use ($user, $planSlug, $membershipId, $plan, $baseDate) {
            $subscription = Subscription::filter([
                'user_id'            => $user->id,
                'subscription_plan'  => $planSlug,
                'whop_membership_id' => $membershipId
            ])->first();
            
            $expirationDate = Carbon::parse($baseDate)->addDays($plan['duration_days'])->startOfDay();
            
            if (!$subscription) {
                Subscription::create([
                    'user_id'                 => $user->id,
                    'payment_date'            => now(),
                    'subscription_status'     => Subscription::STATUS_ACTIVE,
                    'subscription_plan'       => $planSlug,
                    'whop_membership_id'      => $membershipId,
                    'subscription_expires_at' => $expirationDate,
                ]);
            }
            
            if ($subscription) {
                $subscription->update([
                    'payment_date'            => now(),
                    'subscription_status'     => Subscription::STATUS_ACTIVE,
                    'subscription_plan'       => $planSlug,
                    'whop_membership_id'      => $membershipId,
                    'subscription_expires_at' => $expirationDate,
                ]);
            }
            
            $data['name']      = capitalize_first($user->profile->first_name) . ' ' . capitalize_first($user->profile->last_name);
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
                [$data['name'], $plan->name, $expirationDate],
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
            
            Log::info('Usuario activado correctamente', [
                'user_id'       => $user->id,
                'plan'          => $planSlug,
                'expires_at'    => $subscription?->subscription_expires_at,
                'membership_id' => $membershipId,
            ]);
        });
    }
    
    private function deactivateUser(array $data): void
    {
        $membershipId = data_get($data, 'membership.id')
                        ?? data_get($data, 'id');
        
        if (!$membershipId) {
            Log::warning('Desactivación sin membership_id', [
                'data' => $data,
            ]);
            return;
        }
        
        $user = User::where('whop_membership_id', $membershipId)->first();
        
        if (!$user) {
            Log::warning('Usuario no encontrado para desactivar', [
                'membership_id' => $membershipId,
            ]);
            return;
        }
        
        $user->update([
            'subscription_status' => 'inactive',
            'whop_membership_id'  => null,
        ]);
        
        Log::info('Usuario desactivado correctamente', [
            'user_id'       => $user->id,
            'membership_id' => $membershipId,
        ]);
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
        
        $signedContent = "{$webhookId}.{$timestamp}.{$payload}";
        
        $expectedSignature = base64_encode(
            hash_hmac('sha256', $signedContent, $secret, true)
        );
        
        $parts             = explode(',', $signatureHeader, 2);
        $receivedSignature = count($parts) === 2 ? $parts[1] : $signatureHeader;
        
        if (hash_equals($expectedSignature, $receivedSignature)) {
            return true;
        }
        
        Log::warning('Firma de Whop no coincide', [
            'expected' => $expectedSignature,
            'received' => $receivedSignature,
        ]);
        
        return false;
    }
    
    private function verifyPlanActive($plan)
    {
        return app(SubscriptionServices::class)->getSubscriptionApproved($plan);
    }
}