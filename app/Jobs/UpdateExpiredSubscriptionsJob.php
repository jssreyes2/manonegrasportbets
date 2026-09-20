<?php

namespace App\Jobs;

use App\Models\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use App\Models\Subscription;

class UpdateExpiredSubscriptionsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $timeout = 600;  // 10 minutos (job masivo)
    public $tries   = 1;    // NO reintentar para evitar duplicados
    
    public function __construct()
    {
        $this->queue = 'expired-subscriptions';
    }
    
    public function handle(): void
    {
        try {
            Log::info("Iniciando actualización de suscripciones vencidas");
            
            $updatedCount = 0;
            $failedCount  = 0;
            $expiredCount = 0;
            
            $subject   = __t('text.email.template.notification');
            $bodyText  = __t('text.email.notification_expired_suscription.body_text');
            $bodyText1 = __t('text.email.notification_expired_suscription.body_text_1');
            
            Subscription::getSubscription()
                ->filter([
                    'expired'             => true,
                    'subscription_status' => Subscription::STATUS_ACTIVE,
                    'send_email'          => true,
                ])
                ->chunkById(50, function ($subscriptions) use (
                    &$updatedCount, &$failedCount, &$expiredCount,
                    $subject, $bodyText, $bodyText1
                ) {
                    $idsToExpire = [];
                    
                    foreach ($subscriptions as $subscription) {
                        try {
                            
                            $notification = null;
                            
                            if ($subscription->sure_bettor) {
                                continue;
                            }
                            
                            $expiredCount++;
                            
                            $notification = Notification::notificationCreate([
                                'user_id'   => $subscription->user_id,
                                'channel'   => Notification::CHANNEL_EMAIL,
                                'type'      => Notification::TYPE_EXPIRED_SUBSCRIPTION,
                                'addressee' => $subscription->email,
                                'subject'   => $subject,
                                'content'   => $bodyText . ' ' . $subscription->subscription_plan . ' ' . $bodyText1,
                            ]);
                            
                            $data = [
                                'name'      => capitalize_first($subscription->first_name) . ' ' . capitalize_first($subscription->last_name),
                                'email'     => $subscription->email,
                                'subject'   => $subject,
                                'message'   => $bodyText . ' ' . $subscription->subscription_plan . ' ' . $bodyText1,
                                'plan_name' => $subscription->subscription_plan,
                                'bcc'       => config('app.mail_copy_ocult'),
                                'tracking_token' => $notification?->tracking_token,
                            ];
                            
                            SendEmailJob::dispatch($data)->onQueue('email-notifications');
                            
                            $idsToExpire[] = $subscription->id;
                            $updatedCount++;
                            
                        } catch (\Exception $e) {
                            
                            if (isset($notification) && $notification) {
                                $notification->update([
                                    'state'     => Notification::STATE_FAILED,
                                    'error_log' => substr($e->getMessage(), 0, 2000),
                                ]);
                            }
                            
                            $failedCount++;
                            Log::error("Error en suscripción {$subscription->id}: " . $e->getMessage());
                        }
                    }
                    
                    if (!empty($idsToExpire)) {
                        Subscription::whereIn('id', $idsToExpire)
                            ->update([
                                'subscription_status' => Subscription::STATUS_EXPIRED,
                                'send_email'          => null,
                                'winner'              => null,
                                'sure_bettor'         => null,
                                'quantity_pick'       => null
                            ]);
                    }
                }, 'subscriptions.id', 'id');
            
            Log::info("Actualización completada", [
                'procesadas'   => $expiredCount,
                'actualizadas' => $updatedCount,
                'fallidas'     => $failedCount,
            ]);
        } catch (\Exception $e) {
            Log::error("Error crítico: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function failed(\Throwable $exception)
    {
        Log::error("UpdateExpiredSubscriptionsJob falló después de {$this->tries} intentos", [
            'error' => $exception->getMessage(),
            'trace' => $exception->getTraceAsString()
        ]);
    }
}