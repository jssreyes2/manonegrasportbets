<?php

namespace App\Jobs;

use App\Models\Pick;
use App\Models\Subscription;
use App\Models\WebSuscription;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
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
            
            // Los picks free no afectan a las suscripciones
            if ($this->pick->source !== Pick::SOURCE_SUSCRIPTION) {
                return;
            }
            
            $day        = $this->pick->created_at->format('Y-m-d');
            $dayResults = collect();
            $isElite = $this->pick->plan->source === Subscription::PLAN_ELITE;
            
            // reorder(): chunkById necesita ordenar solo por id, el filtro ordena por user_id
            $suscriptionsUsers = Subscription::getSubscription()->filter([
                'subscription_status' => Subscription::STATUS_ACTIVE,
                'subscription_plan'   => $this->pick->plan->source,
                // Solo quienes recibieron un pick en este ciclo
                'send_email'          => true,
            ])->reorder();
            
            if ($isElite) {
                // Elite del día del pick, incluidos los ganadores y quienes ya pasaron al día extra del seguro:
                // así una corrección de la calificación también les llega
                $suscriptionsUsers->where(function ($q) use ($day) {
                    $q->whereDate('subscriptions.subscription_expires_at', $day)
                        ->orWhereDate('subscriptions.sure_bettor_day', $day);
                });
                
                // Resultados de los picks Elite del día en el orden en que se enviaron
                $dayResults = Pick::where('plan_id', $this->pick->plan_id)
                    ->where('source', Pick::SOURCE_SUSCRIPTION)
                    ->whereDate('created_at', $day)
                    ->orderBy('id')
                    ->pluck('right')
                    ->map(fn($right) => $right === null ? null : (bool)$right)
                    ->values();
            } else {
                // Se compara contra el día del pick, no contra hoy: si se califica tarde no debe tocar a quien compró después
                $suscriptionsUsers->whereDate('subscriptions.subscription_expires_at', '>=', $day);
            }
            
            $suscriptionsUsers->chunkById(50, function ($subscriptions) use (&$successCount, &$failedCount, $isElite, $day, $dayResults) {
                foreach ($subscriptions as $subscription) {
                    try {
                        
                        if (!$subscription->user) {
                            Log::warning("Suscripción {$subscription->id} sin usuario asociado");
                            $failedCount++;
                            continue;
                        }
                        
                        if ($isElite) {
                            $this->recalculateElite($subscription, $dayResults, $day);
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
            }, 'subscriptions.id', 'id');
            
            Log::info("edición masiva completada: {$successCount}, Fallidos: {$failedCount}");
            
        } catch (\Exception $e) {
            Log::error("Error en MassiveUpdatePickJob: " . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Recalcula el estado Elite del día con todas las calificaciones actuales, para que una
     * corrección (perdido ↔ ganado) deje la suscripción igual que si se hubiera calificado bien desde el inicio.
     */
    private function recalculateElite(Subscription $subscription, Collection $dayResults, string $day): void
    {
        $insuranceDay      = $subscription->sure_bettor_day?->format('Y-m-d');
        $isInsuranceSource = $insuranceDay === $day;
        
        // Picks que recibió ese día: deja de recibir al ganar, así que son los primeros N del día.
        // quantity_pick es del ciclo: los 2 del día que activó el seguro se descuentan en el día extra.
        $received = $isInsuranceSource ? 2 : (int)$subscription->quantity_pick - ($insuranceDay ? 2 : 0);
        $results  = $dayResults->take(max(0, $received));
        
        $won      = $results->containsStrict(true);
        $lostBoth = $results->count() === 2 && $results->every(fn($right) => $right === false);
        
        if ($isInsuranceSource) {
            if ($lostBoth) {
                return;
            }
            
            // Ya no perdió los dos: se quita el día extra, salvo que ya haya empezado a recibir sus picks
            if ((int)$subscription->quantity_pick > 2) {
                Log::warning("Suscripción {$subscription->id}: corrección de calificación con el día extra del seguro ya en uso, se mantiene", [
                    'pick_id' => $this->pick->id,
                    'day'     => $day,
                ]);
                return;
            }
            
            $subscription->subscription_expires_at = Carbon::parse($day)->startOfDay();
            $subscription->sure_bettor             = false;
            $subscription->sure_bettor_day         = null;
            $subscription->winner                  = $won;
            return;
        }
        
        // Seguro del apostador: una sola vez por ciclo, cuando pierde los dos picks que recibió en el día
        if ($lostBoth && !$insuranceDay) {
            $subscription->subscription_expires_at = Subscription::nextEliteDay(Carbon::parse($day)->addDay());
            $subscription->sure_bettor             = true;
            $subscription->sure_bettor_day         = $day;
            $subscription->winner                  = false;
            return;
        }
        
        $subscription->winner = $won;
    }
}