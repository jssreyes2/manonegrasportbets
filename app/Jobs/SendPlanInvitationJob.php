<?php

namespace App\Jobs;

use App\Models\Pick;
use App\Models\Subscription;
use App\Models\WebSuscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

/**
 * Invita a los suscriptores gratis (pick gratis desde la web) a comprar un plan de pago.
 * Corre todos los días, pero cada persona recibe como máximo 2 correos en total:
 *  1) a los 3 días de registrarse (los ya registrados reciben este primero al activarse el job)
 *  2) recordatorio 7 días después del primero
 * Se omite a quien se dio de baja de las promociones o ya tiene un plan de pago vigente.
 */
class SendPlanInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public const FIRST_AFTER_DAYS    = 3;
    public const REMINDER_AFTER_DAYS = 7;
    public const MAX_PER_RUN         = 200; // evita ráfagas que dañen la reputación del remitente
    
    public $timeout = 600;
    public $tries   = 1;
    
    public function __construct()
    {
        $this->queue = 'expired-subscriptions';
    }
    
    public function handle(): void
    {
        $sent  = 0;
        $stats = Pick::resultsSummary(30);
        
        // Clientes con plan de pago vigente: ya compraron, no se les invita
        $customers = Subscription::getSubscription()
            ->where('subscriptions.subscription_status', Subscription::STATUS_ACTIVE)
            ->pluck('users.email')
            ->map(fn($e) => mb_strtolower($e))
            ->flip();
        
        WebSuscription::whereNull('unsubscribed_at')
            ->where(function ($q) {
                $q->where(fn($q) => $q->where('invitations_sent', 0)
                    ->where('created_at', '<=', now()->subDays(self::FIRST_AFTER_DAYS)))
                    ->orWhere(fn($q) => $q->where('invitations_sent', 1)
                        ->where('last_invitation_at', '<=', now()->subDays(self::REMINDER_AFTER_DAYS)));
            })
            ->orderBy('id')
            ->limit(self::MAX_PER_RUN)
            ->get()
            ->each(function (WebSuscription $lead) use ($customers, $stats, &$sent) {
                if ($customers->has(mb_strtolower($lead->email))) {
                    return;
                }
                
                try {
                    $stage  = $lead->invitations_sent === 0 ? 'invitation_1' : 'invitation_2';
                    $locale = in_array($lead->language, ['es', 'en'], true) ? $lead->language : 'es';
                    
                    [$subject, $message] = self::buildMessage($stage, $locale, $lead, $stats);
                    
                    SendEmailJob::dispatch([
                        'name'    => capitalize_first($lead->full_name),
                        'email'   => $lead->email,
                        'subject' => $subject,
                        'message' => $message,
                        'bcc'     => config('app.mail_copy_ocult'),
                        'locale'  => $locale,
                    ])->onQueue('email-notifications');
                    
                    // Se marca al encolar: si el envío falla no se reintenta solo, para no duplicar correos
                    $lead->update([
                        'invitations_sent'   => $lead->invitations_sent + 1,
                        'last_invitation_at' => now(),
                    ]);
                    
                    $sent++;
                } catch (\Throwable $e) {
                    Log::error("Error enviando invitación de plan a web_suscription {$lead->id}: " . $e->getMessage());
                }
            });
        
        Log::info('Invitaciones a plan de pago encoladas', ['enviadas' => $sent]);
    }
    
    public function failed(\Throwable $exception): void
    {
        Log::error('SendPlanInvitationJob falló', ['error' => $exception->getMessage()]);
    }
    
    /**
     * @return array{0: string, 1: string} [asunto, cuerpo HTML]
     */
    public static function buildMessage(string $stage, string $locale, WebSuscription $lead, array $stats): array
    {
        $key     = "text.email.plan_invitation.{$stage}";
        $replace = ['won' => $stats['won'], 'total' => $stats['total'], 'rate' => $stats['rate']];
        
        $subject = __t("{$key}.subject", null, $replace, $locale);
        $body    = __t("{$key}.body", null, $replace, $locale);
        
        // Resultados reales de los últimos 30 días (solo si ya hay picks calificados)
        if ($stage === 'invitation_1' && $stats['total'] > 0) {
            $body .= '<br><br>' . __t("{$key}.stats", null, $replace, $locale);
        }
        
        $unsubscribe = URL::signedRoute('web-suscription.unsubscribe', ['webSuscription' => $lead->id]);
        
        $message = $body
            . '<br><br><a href="' . e(route('show.plans')) . '">' . __t('text.email.plan_invitation.button', null, [], $locale) . '</a>'
            . '<br><br><small><a href="' . e($unsubscribe) . '">' . __t('text.email.plan_invitation.unsubscribe', null, [], $locale) . '</a></small>';
        
        return [$subject, $message];
    }
}
