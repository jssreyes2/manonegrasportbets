<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Notification;
use App\Models\Pick;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

/**
 * Correos de retención de suscripciones (corre todos los días a las 7 AM):
 *  - Aviso previo: 3 días antes y el último día de servicio (solo avisa; el plan no se renueva mientras esté vigente).
 *  - Recuperación: secuencia de 4 correos a los días 1, 3, 7 y 14 después del vencimiento; luego se detiene.
 * Un cliente recibe como máximo un correo por día, aunque tenga varios planes.
 */
class SendRenewalInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** Días antes del último día de servicio en que se avisa del vencimiento */
    public const EXPIRING_DAYS = [3, 0];

    /** Días después del vencimiento en que se envía cada correo de recuperación */
    public const RECOVERY_DAYS = [1, 3, 7, 14];

    public $timeout = 600;
    public $tries   = 1; // no reintentar para evitar correos duplicados

    public function __construct()
    {
        $this->queue = 'expired-subscriptions';
    }

    public function handle(): void
    {
        $today  = now()->startOfDay();
        $sent   = 0;
        $failed = 0;

        // Clientes que ya recibieron un correo de retención hoy (evita duplicar si el job corre dos veces)
        $alreadySent = Notification::whereIn('type', [Notification::TYPE_RENEWAL_INVITATION, Notification::TYPE_EXPIRING_SUBSCRIPTION])
            ->whereDate('created_at', $today)
            ->pluck('user_id')
            ->flip();

        $stats = null;

        foreach ($this->usersToNotify($today) as $userId => $item) {
            if ($alreadySent->has($userId)) {
                continue;
            }

            $first = $item['subscriptions']->first();

            try {
                $locale = in_array($first->language, ['es', 'en'], true) ? $first->language : config('app.locale');
                $plans  = $item['subscriptions']->pluck('subscription_plan')->unique()->values();

                // Con un solo plan vencido el botón lleva directo a su checkout; en los demás casos, al panel de suscripción
                $link = $item['expired'] && $plans->count() === 1
                    ? route('renew', $plans->first())
                    : url('/planes');

                $stats ??= Pick::resultsSummary(30);

                [$subject, $message] = $this->buildMessage($item['stage'], $locale, $plans, $link, $item['days'], $stats);

                $type = $item['expired'] ? Notification::TYPE_RENEWAL_INVITATION : Notification::TYPE_EXPIRING_SUBSCRIPTION;

                $notification = Notification::notificationCreate([
                    'user_id'   => $userId,
                    'channel'   => Notification::CHANNEL_EMAIL,
                    'type'      => $type,
                    'addressee' => $first->email,
                    'subject'   => $subject,
                    'content'   => strip_tags($message),
                ]);

                SendEmailJob::dispatch([
                    'name'           => capitalize_first($first->first_name) . ' ' . capitalize_first($first->last_name),
                    'email'          => $first->email,
                    'subject'        => $subject,
                    'message'        => $message,
                    'plan_name'      => $plans->implode(', '),
                    'bcc'            => config('app.mail_copy_ocult'),
                    'tracking_token' => $notification->tracking_token,
                    'locale'         => $locale,
                ])->onQueue('email-notifications');

                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("Error enviando correo de retención al usuario {$userId}: " . $e->getMessage());
            }
        }

        Log::info('Correos de retención encolados', ['enviados' => $sent, 'fallidos' => $failed]);
    }

    public function failed(\Throwable $exception): void
    {
        Log::error('SendRenewalInvitationJob falló', ['error' => $exception->getMessage()]);
    }

    /**
     * Un registro por cliente con las suscripciones a las que le toca aviso hoy.
     * Si coinciden varias, se usa el aviso más urgente y se listan los planes de esa misma etapa.
     *
     * @return Collection<int, array{subscriptions: Collection, stage: string, days: int, expired: bool}>
     */
    private function usersToNotify(Carbon $today): Collection
    {
        $rows = Subscription::getSubscription()
            ->addSelect('users.language')
            ->whereIn('subscriptions.subscription_status', [Subscription::STATUS_ACTIVE, Subscription::STATUS_EXPIRED])
            ->whereNotNull('subscriptions.subscription_expires_at')
            ->reorder()
            ->orderBy('subscriptions.user_id')
            ->get();

        $result = collect();

        foreach ($rows->groupBy('user_id') as $userId => $subscriptions) {
            $candidates = [];

            foreach ($subscriptions as $subscription) {
                $isElite = $subscription->subscription_plan === Subscription::PLAN_ELITE;
                $expires = $subscription->subscription_expires_at->copy()->startOfDay();

                // Último día de servicio: Elite incluye su fecha de vencimiento; los demás vencen al iniciarla
                $lastDay = $isElite ? $expires : $expires->copy()->subDay();

                if ($subscription->subscription_status === Subscription::STATUS_ACTIVE) {
                    $days = (int)$today->diffInDays($lastDay, false);

                    if (in_array($days, self::EXPIRING_DAYS, true)) {
                        $candidates[] = ['sub' => $subscription, 'stage' => "expiring_{$days}", 'days' => $days, 'expired' => false];
                    }

                    continue;
                }

                $days = (int)$lastDay->diffInDays($today, false);

                if (in_array($days, self::RECOVERY_DAYS, true)) {
                    $candidates[] = ['sub' => $subscription, 'stage' => "expired_{$days}", 'days' => $days, 'expired' => true];
                }
            }

            if (!$candidates) {
                continue;
            }

            // Primero el aviso previo (plan vigente); luego el vencimiento más reciente
            usort($candidates, fn($a, $b) => [$a['expired'], $a['days']] <=> [$b['expired'], $b['days']]);
            $best = $candidates[0];

            $result[$userId] = [
                'subscriptions' => collect($candidates)->where('stage', $best['stage'])->pluck('sub'),
                'stage'         => $best['stage'],
                'days'          => $best['days'],
                'expired'       => $best['expired'],
            ];
        }

        return $result;
    }

    /**
     * @return array{0: string, 1: string} [asunto, cuerpo HTML]
     */
    private function buildMessage(string $stage, string $locale, Collection $plans, string $link, int $days, array $stats): array
    {
        $key      = "text.email.renewal_invitation.{$stage}";
        $planList = e($plans->map(fn($p) => mb_strtoupper($p))->implode(', '));

        $replace = [
            'plans' => $planList,
            'days'  => $days,
            'won'   => $stats['won'],
            'total' => $stats['total'],
            'rate'  => $stats['rate'],
        ];

        $subject = __t("{$key}.subject", null, $replace, $locale);
        $body    = __t("{$key}.body", null, $replace, $locale);

        // Día 3: resultados reales de los últimos 30 días (solo si ya hay picks calificados)
        if ($stage === 'expired_3' && $stats['total'] > 0) {
            $body .= '<br><br>' . __t("{$key}.stats", null, $replace, $locale);
        }

        // Día 7: testimonios publicados por el admin (si no hay, el correo sale sin ellos)
        if ($stage === 'expired_7') {
            $quotes = Comment::testimonials(2)->map(
                fn($c) => '<em>"' . e($c->testimonialText($locale)) . '"</em> — ' . e(capitalize_first($c->full_name))
            );

            if ($quotes->isNotEmpty()) {
                $body .= '<br><br>' . $quotes->implode('<br><br>');
            }
        }

        $button = __t('text.email.renewal_invitation.' . ($stage === 'expiring_0' || $stage === 'expiring_3' ? 'button_panel' : 'button'), null, [], $locale);

        return [$subject, $body . '<br><br><a href="' . e($link) . '">' . $button . '</a>'];
    }
}
