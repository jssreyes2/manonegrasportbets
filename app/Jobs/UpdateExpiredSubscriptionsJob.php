<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Pick;
use App\Models\Plan;
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
    
    private array $pendingEliteDays = [];
    private array $eliteDays        = [];
    
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
                    'subscription_status' => Subscription::STATUS_ACTIVE
                ])
                // chunkById necesita ordenar solo por id, el filtro ordena por user_id
                ->reorder()
                ->chunkById(50, function ($subscriptions) use (
                    &$updatedCount, &$failedCount, &$expiredCount,
                    $subject, $bodyText, $bodyText1
                ) {
                    $idsToExpire = [];
                    
                    foreach ($subscriptions as $subscription) {
                        try {
                            
                            $notification = null;
                            
                            if ($subscription->subscription_plan === Subscription::PLAN_ELITE) {
                                $eliteDay = $subscription->subscription_expires_at->format('Y-m-d');
                                
                                // Picks de su día sin calificar: se espera el resultado para decidir el seguro del apostador
                                if ($this->hasPendingElitePicks($eliteDay)) {
                                    continue;
                                }
                                
                                // Su día (comprado o del seguro) no tuvo picks Elite: se pasa al siguiente día con picks
                                if (!$this->hasElitePicks($eliteDay)) {
                                    Subscription::whereKey($subscription->id)
                                        ->update(['subscription_expires_at' => Subscription::nextEliteDay()]);
                                    continue;
                                }
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
                                'name'           => capitalize_first($subscription->first_name) . ' ' . capitalize_first($subscription->last_name),
                                'email'          => $subscription->email,
                                'subject'        => $subject,
                                'message'        => $bodyText . ' ' . $subscription->subscription_plan . ' ' . $bodyText1,
                                'plan_name'      => $subscription->subscription_plan,
                                'bcc'            => config('app.mail_copy_ocult'),
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
                                'sure_bettor_day'     => null,
                                'quantity_pick'       => null
                            ]);
                    }
                }, 'subscriptions.id', 'id');
            
            $this->activatePlans();
            
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
    
    private function hasPendingElitePicks(string $day): bool
    {
        return $this->pendingEliteDays[$day] ??= Pick::where('plan_id', Plan::ID_PLAN_ELITE)
            ->where('source', Pick::SOURCE_SUSCRIPTION)
            ->whereDate('created_at', $day)
            ->whereNull('right')
            ->exists();
    }
    
    private function hasElitePicks(string $day): bool
    {
        return $this->eliteDays[$day] ??= Pick::where('plan_id', Plan::ID_PLAN_ELITE)
            ->where('source', Pick::SOURCE_SUSCRIPTION)
            ->whereDate('created_at', $day)
            ->exists();
    }
    
    private function activatePlans()
    {
        Plan::where('is_active', false)->update(['is_active' => true, 'updated_at' => now()]);
    }
}