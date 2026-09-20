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

class MassiveUpdatePickJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    protected $pick;
    public $timeout = 600;  // 10 minutos (job masivo)
    public $tries   = 1;    // NO reintentar para evitar duplicados
    public function __construct($pick)
    {
        $this->pick = $pick;
        $this->onQueue('massive-update-picks');
    }
    
    public function handle(): void
    {
        try {
            $successCount = 0;
            $failedCount  = 0;
            
            if (empty($this->pick->plan) || empty($this->pick->plan->source)) {
                Log::warning("Job detenido: Pick sin plan o sin slug", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            $suscriptionsUsers = Subscription::getSubscription()->filter([
                'subscription_expires_at' => true,
                'subscription_status'     => Subscription::STATUS_ACTIVE,
                'subscription_plan'       => $this->pick->plan->source,
                'winner'                  => true,
            ]);
            
            
            if (!$suscriptionsUsers) {
                Log::warning("Job detenido: Pick sin suscripción", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            
            $suscriptionsUsers->chunk(50, function ($subscriptions) use (&$successCount, &$failedCount) {
                foreach ($subscriptions as $subscription) {
                    try {
                        
                        if ($this->pick->source === Pick::SOURCE_SUSCRIPTION && !$subscription->user) {
                            Log::warning("Suscripción {$subscription->id} sin usuario asociado");
                            $failedCount++;
                            continue;
                        }
                        
                        $subscription->winner = $this->pick->right;
                        if ($subscription->subscription_plan == Subscription::PLAN_ELITE) {
                            $subscription->sure_bettor = $subscription->quantity_pick == 2 && !$this->pick->right;
                            
                            if ($subscription->sure_bettor) {
                                $newDate                               = \Carbon\Carbon::parse($subscription->subscription_expires_at)
                                    ->addDay()
                                    ->startOfDay()
                                    ->toDateTimeString();
                                $subscription->subscription_expires_at = $newDate;
                            }
                            
                            if (($subscription->quantity_pick > 2 && !$this->pick->right) || $this->pick->right) {
                                $subscription->sure_bettor = false;
                            }
                        }
                        
                        $subscription->save();
                        
                        $successCount++;
                        
                    } catch (\Exception $e) {
                        $failedCount++;
                        Log::error("Error editar suscripción {$subscription->id}: " . $e->getMessage());
                    }
                }
            });
            
            Log::info("edición masiva completada: {$successCount}, Fallidos: {$failedCount}");
            
        } catch (\Exception $e) {
            Log::error("Error en MassiveUpdatePickJob: " . $e->getMessage());
            throw $e;
        }
    }
}