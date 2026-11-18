<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * Invita a renovar a los clientes con suscripciones vencidas.
 * Envía un solo correo por cliente (listando todos sus planes vencidos) y no
 * repite la invitación antes de REMINDER_EVERY_DAYS días para no saturar al cliente.
 */
class SendRenewalInvitationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /** Días mínimos entre una invitación y la siguiente al mismo cliente */
    public const REMINDER_EVERY_DAYS = 7;
    
    public $timeout = 600;
    public $tries   = 1; // no reintentar para evitar correos duplicados
    
    public function __construct()
    {
        $this->queue = 'expired-subscriptions';
    }
    
    public function handle(): void
    {
        $sent   = 0;
        $failed = 0;
        
        // Clientes invitados recientemente: se omiten
        $recentlyInvited = Notification::where('type', Notification::TYPE_RENEWAL_INVITATION)
            ->where('created_at', '>=', now()->subDays(self::REMINDER_EVERY_DAYS))
            ->pluck('user_id')
            ->flip();
        
        $expired = Subscription::getSubscription()
            ->addSelect('users.language')
            ->filter(['subscription_status' => Subscription::STATUS_EXPIRED])
            ->reorder()
            ->orderBy('subscriptions.user_id')
            ->get()
            ->groupBy('user_id');
        
        foreach ($expired as $userId => $subscriptions) {
            if ($recentlyInvited->has($userId)) {
                continue;
            }
            
            $first = $subscriptions->first();
            
            try {
                $locale  = in_array($first->language, ['es', 'en'], true) ? $first->language : config('app.locale');
                $plans   = $subscriptions->pluck('subscription_plan')->unique()->implode(', ');
                $subject = __t('text.email.renewal_invitation.subject', null, [], $locale);
                $message = __t('text.email.renewal_invitation.body_text', null, [], $locale)
                    . ' ' . e($plans) . ' ' . __t('text.email.renewal_invitation.body_text_1', null, [], $locale)
                    . '<br><br><a href="' . e(url('/planes')) . '">'
                    . __t('text.email.renewal_invitation.button', null, [], $locale) . '</a>';
                
                $notification = Notification::notificationCreate([
                    'user_id'   => $userId,
                    'channel'   => Notification::CHANNEL_EMAIL,
                    'type'      => Notification::TYPE_RENEWAL_INVITATION,
                    'addressee' => $first->email,
                    'subject'   => $subject,
                    'content'   => strip_tags($message),
                ]);
                
                SendEmailJob::dispatch([
                    'name'           => capitalize_first($first->first_name) . ' ' . capitalize_first($first->last_name),
                    'email'          => $first->email,
                    'subject'        => $subject,
                    'message'        => $message,
                    'plan_name'      => $plans,
                    'bcc'            => config('app.mail_copy_ocult'),
                    'tracking_token' => $notification->tracking_token,
                    'locale'         => $locale,
                ])->onQueue('email-notifications');
                
                $sent++;
            } catch (\Throwable $e) {
                $failed++;
                Log::error("Error enviando invitación de renovación al usuario {$userId}: " . $e->getMessage());
            }
        }
        
        Log::info('Invitaciones de renovación encoladas', ['enviadas' => $sent, 'fallidas' => $failed]);
    }
    
    public function failed(\Throwable $exception): void
    {
        Log::error('SendRenewalInvitationJob falló', ['error' => $exception->getMessage()]);
    }
}
