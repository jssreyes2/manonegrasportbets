<?php

namespace App\Services\User;

use App\Models\Pick;
use App\Models\Plan;
use App\Models\Subscription;
use App\Services\Register\PlanServices;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Datos de las vistas del cliente: Inicio (resumen) y Mis picks (historial).
 */
class CustomerPanelServices
{
    // Días antes del vencimiento en que se avisa al cliente
    const EXPIRY_WARNING_DAYS = 3;

    public function __construct(protected SubscriptionServices $subscription, protected PlanServices $plan)
    {
    }

    public function home()
    {
        $user = Auth::user();

        $activePlans = $this->activePlans();
        $todayPicks  = Pick::sentToUser($user->id, now()->format('Y-m-d'))->get();
        $recentPicks = Pick::sentToUser($user->id)->take(5)->get();
        $stats       = $this->stats($user->id);
        $hasElite    = $activePlans->contains(fn($plan) => $plan['is_elite']);

        return view('dashboard.views.customer-home', compact('user', 'activePlans', 'todayPicks', 'recentPicks', 'stats', 'hasElite'));
    }

    public function picks(array $data = [])
    {
        $user   = Auth::user();
        $result = $data['result'] ?? null;

        $picks = Pick::sentToUser($user->id)
            ->when($result === 'won', fn($q) => $q->where('picks.right', 1))
            ->when($result === 'lost', fn($q) => $q->where('picks.right', 0))
            ->when($result === 'pending', fn($q) => $q->whereNull('picks.right'))
            ->paginate(config('app.npage'))
            ->withQueryString();

        $stats       = $this->stats($user->id);
        $hasActive   = $this->activePlans()->isNotEmpty();

        return view('dashboard.views.picks', compact('picks', 'stats', 'result', 'hasActive'));
    }

    /**
     * Planes vigentes del cliente con nombre, duración del catálogo y % consumido.
     */
    public function activePlans(): Collection
    {
        $catalog = $this->plan->getPlans()->get()->keyBy(fn($plan) => strtolower($plan->source));

        return collect($this->subscription->getSubscriptionApproved()['plans'] ?? [])
            ->map(function ($active) use ($catalog) {
                $source   = strtolower($active['name']);
                $plan     = $catalog->get($source);
                $duration = max(1, (int)($plan->duration_days ?? 1));
                $days     = (int)$active['remainingDays'];

                return $active + [
                    'source'   => $source,
                    'label'    => $plan->name ?? capitalize_first($source),
                    'is_elite' => $source === Subscription::PLAN_ELITE,
                    'duration' => $duration,
                    // Avance del plan: cuánto del periodo ya pasó
                    'progress' => (int)round(min(100, max(0, ($duration - $days) * 100 / $duration))),
                    // El plan Elite dura un día: no tiene sentido avisar que "vence pronto"
                    'expiring' => $source !== Subscription::PLAN_ELITE && $days <= self::EXPIRY_WARNING_DAYS,
                ];
            })
            ->values();
    }

    /**
     * Rendimiento de los picks que recibió el cliente.
     */
    public function stats(int $userId): array
    {
        $received = DB::table('send_mail_picks')
            ->join('picks', 'picks.id', '=', 'send_mail_picks.pick_id')
            ->whereNull('picks.deleted_at')
            ->where('send_mail_picks.user_id', $userId)
            ->count();

        $graded = Pick::resultsSummary(null, $userId);

        return $graded + [
            'received' => $received,
            'pending'  => max(0, $received - $graded['total']),
        ];
    }
}
