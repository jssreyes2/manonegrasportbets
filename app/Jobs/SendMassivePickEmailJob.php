<?php

namespace App\Jobs;

use App\Models\Notification;
use App\Models\Pick;
use App\Models\Subscription;
use App\Models\WebSuscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SendMassivePickEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $pick;
    public    $timeout = 600;  // 10 minutos (job masivo)
    public    $tries   = 1;    // NO reintentar para evitar duplicados
    
    public function __construct($pick)
    {
        $this->pick = $pick;
        $this->onQueue('emails-picks');
    }
    
    public function handle(): void
    {
        try {
            $queuedCount = 0;
            $failedCount = 0;
            
            if (empty($this->pick->plan) || empty($this->pick->plan->source)) {
                Log::warning("Job detenido: Pick sin plan o sin slug", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            $suscriptionsUsers = match ($this->pick->source) {
                Pick::SOURCE_SUSCRIPTION     => Subscription::getSubscription()->filter([
                    'subscription_expires_at' => true,
                    'subscription_status'     => Subscription::STATUS_ACTIVE,
                    'subscription_plan'       => $this->pick->plan->source,
                    'winner'                  => true,
                ]),
                Pick::SOURCE_WEB_SUSCRIPTION => WebSuscription::query(),
                //Pick::SOURCE_WEB_SUSCRIPTION => WebSuscription::whereNull('send_email'),
                default                      => null,
            };
            
            if (!$suscriptionsUsers) {
                Log::warning("Job detenido: Pick sin fuente", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            if (!$suscriptionsUsers->clone()->exists()) {
                Log::warning("Job detenido: sin suscripciones", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            [$chunkColumn, $chunkAlias] = match ($this->pick->source) {
                Pick::SOURCE_SUSCRIPTION     => ['subscriptions.id', 'id'],
                Pick::SOURCE_WEB_SUSCRIPTION => ['web_suscriptions.id', 'id'],
                default                      => ['id', 'id'],
            };
            
            $suscriptionsUsers->chunkById(
                50,
                function ($subscriptions) use (&$queuedCount, &$failedCount) {
                   
                    $processedIds = [];
                    
                    foreach ($subscriptions as $subscription) {
                        try {
                           
                            $data = [];
                            $notification = null;
                            
                            if ($this->pick->source === Pick::SOURCE_SUSCRIPTION) {
                                if (!$subscription->user) {
                                    Log::warning("Suscripción {$subscription->id} sin usuario asociado");
                                    $failedCount++;
                                    continue;
                                }
                                
                                $subject = __t('text.email.template.bet_details');
                                $body    = $this->pick->body;
                                
                                $notification = Notification::notificationCreate([
                                    'user_id'   => $subscription->user_id,
                                    'channel'   => Notification::CHANNEL_EMAIL,
                                    'type'      => Notification::TYPE_PICK,
                                    'addressee' => $subscription->email,
                                    'subject'   => $subject,
                                    'content'   => $body,
                                ]);
                                
                                $data = [
                                    'name'           => capitalize_first($subscription->first_name) . ' ' . capitalize_first($subscription->last_name),
                                    'email'          => $subscription->email,
                                    'message'        => $body,
                                    'plan_name'      => $subscription->subscription_plan,
                                    'subject'        => $subject,
                                    'bcc'            => config('app.mail_copy_ocult'),
                                    'tracking_token' => $notification?->tracking_token,
                                ];
                            }
                            
                            if ($this->pick->source === Pick::SOURCE_WEB_SUSCRIPTION) {
                                $data = [
                                    'name'      => capitalize_first($subscription->full_name),
                                    'email'     => $subscription->email,
                                    'message'   => $this->pick->body,
                                    'plan_name' => $this->pick->plan->source,
                                    'subject'   => __t('text.email.template.bet_details'),
                                    'bcc'       => config('app.mail_copy_ocult'),
                                ];
                            }
                            
                            if (empty($data)) {
                                $failedCount++;
                                continue;
                            }
                            
                            SendEmailJob::dispatch($data)->onQueue('emails-picks');
                            
                            $processedIds[] = $subscription->id;
                            
                            $queuedCount++;
                            
                        } catch (\Throwable $e) {
                            
                            if (isset($notification) && $notification) {
                                $notification->update([
                                    'state'     => Notification::STATE_FAILED,
                                    'error_log' => substr($e->getMessage(), 0, 2000),
                                ]);
                            }
                            
                            $failedCount++;
                            Log::error("Error encolando email a suscripción {$subscription->id}: " . $e->getMessage());
                        }
                    }
                    
                    if (!empty($processedIds)) {
                        if ($this->pick->source === Pick::SOURCE_SUSCRIPTION) {
                            Subscription::whereIn('id', $processedIds)->update([
                                'send_email'    => true,
                                'quantity_pick' => DB::raw('COALESCE(quantity_pick, 0) + 1'),
                            ]);
                        }
                        
                        if ($this->pick->source === Pick::SOURCE_WEB_SUSCRIPTION) {
                            WebSuscription::whereIn('id', $processedIds)->update([
                                'send_email' => true,
                            ]);
                        }
                    }
                },
                $chunkColumn,
                $chunkAlias
            );
            
            
            Log::info("Email masivo completado. Encolados: {$queuedCount}, Fallidos: {$failedCount}");
        } catch (\Throwable $e) {
            Log::error("Error en SendMassivePickEmailJob: " . $e->getMessage());
            throw $e;
        }
    }
}