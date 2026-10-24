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
                // Se compara contra el día del pick, no contra hoy: si se califica tarde no debe tocar a quien compró después
                'subscription_expires_at' => $this->pick->created_at->format('Y-m-d'),
                'subscription_status'     => Subscription::STATUS_ACTIVE,
                'subscription_plan'       => $this->pick->plan->source,
                'winner'                  => true,
                // Solo quienes recibieron un pick en este ciclo
                'send_email'              => true,
            ]);
            
            
            if (!$suscriptionsUsers) {
                Log::warning("Job detenido: Pick sin suscripción", ['pick_id' => $this->pick->id ?? null]);
                return;
            }
            
            
            // Seguro del apostador: exige que todos los picks del plan publicados ese día estén calificados como perdidos
            $dayPicksLost = !Pick::where('plan_id', $this->pick->plan_id)
                ->where('source', Pick::SOURCE_SUSCRIPTION)
                ->whereDate('created_at', $this->pick->created_at->format('Y-m-d'))
                ->where(fn($q) => $q->whereNull('right')->orWhere('right', true))
                ->exists();
            
            $suscriptionsUsers->chunk(50, function ($subscriptions) use (&$successCount, &$failedCount, $dayPicksLost) {
                foreach ($subscriptions as $subscription) {
                    try {
                        
                        if ($this->pick->source === Pick::SOURCE_SUSCRIPTION && !$subscription->user) {
                            Log::warning("Suscripción {$subscription->id} sin usuario asociado");
                            $failedCount++;
                            continue;
                        }
                        
                        if ($subscription->subscription_plan == Subscription::PLAN_ELITE) {
                            // Un acierto del día no se pierde por un fallo calificado después
                            $subscription->winner = $subscription->winner || $this->pick->right;
                            
                            // Solo si perdió los dos picks que se le enviaron en el día
                            $lostBoth = !$subscription->winner && $subscription->quantity_pick == 2 && $dayPicksLost;
                            
                            if ($lostBoth && !$subscription->sure_bettor) {
                                $newDate                               = \Carbon\Carbon::parse($subscription->subscription_expires_at)
                                    ->addDay()
                                    ->startOfDay()
                                    ->toDateTimeString();
                                $subscription->subscription_expires_at = $newDate;
                            }
                            
                            $subscription->sure_bettor = $lostBoth;
                        } else {
                            $subscription->winner = $this->pick->right;
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