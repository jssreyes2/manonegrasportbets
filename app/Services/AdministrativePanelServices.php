<?php

namespace App\Services;


use App\Models\Payment;
use App\Models\Pick;
use App\Models\Plan;
use App\Models\Rol;
use App\Models\Subscription;
use App\Models\User;
use App\Repositories\Settings\UserRepository;
use App\Services\User\PaymentServices;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class AdministrativePanelServices
{
    // Meses que muestra el gráfico de ingresos
    private const REVENUE_MONTHS = 6;

    // Días hacia adelante para avisar de suscripciones por vencer
    private const EXPIRING_DAYS = 3;

    // Ventana para calcular el porcentaje de acierto de los picks
    private const ACCURACY_DAYS = 30;

    public function adminPanel()
    {

        if (Auth::user()->rol_id == Rol::ROL_CUSTOMER) {
            return redirect()->route('subscription');
        }

        $now        = now();
        $today      = $now->copy()->startOfDay();
        $monthStart = $now->copy()->startOfMonth();

        $revenueMonth = $this->revenueBetween($monthStart, $now);
        $revenuePrev  = $this->revenueBetween($monthStart->copy()->subMonth(), $monthStart->copy()->subSecond());

        $customers = UserRepository::getUserProfile(['rol_id' => Rol::ROL_CUSTOMER, 'completed_profile' => true]);

        $activeByPlan = $this->activeSubscriptions($today)
            ->selectRaw('subscriptions.subscription_plan, COUNT(*) AS total')
            ->groupBy('subscriptions.subscription_plan')
            ->pluck('total', 'subscription_plan');

        $pendingPicks = Pick::with('plan')
            ->where('source', Pick::SOURCE_SUSCRIPTION)
            ->whereNull('right')
            ->latest('id');

        return view('admin.dashboard', [
            'revenueMonth'    => $revenueMonth,
            'revenueDelta'    => $revenuePrev > 0 ? round(($revenueMonth - $revenuePrev) / $revenuePrev * 100) : null,
            'activeTotal'     => $activeByPlan->sum(),
            'activeByPlan'    => $this->withPlanNames($activeByPlan),
            'customersTotal'  => (clone $customers)->count(),
            'customersNew'    => User::where('rol_id', Rol::ROL_CUSTOMER)->where('created_at', '>=', $monthStart)->count(),
            'pendingTotal'    => (clone $pendingPicks)->count(),
            'pendingPicks'    => $pendingPicks->limit(5)->get(),
            'accuracy'        => $this->pickAccuracy($now),
            'revenueChart'    => $this->revenueByMonth($now),
            'insuranceActive' => $this->activeSubscriptions($today)->where('subscriptions.sure_bettor', true)->count(),
            'expiringSoon'    => $this->expiringSoon($today),
            'latestPayments'  => app(PaymentServices::class)->getPayments()->limit(5)->get(),
            'latestCustomers' => $customers->reorder()->orderByDesc('users.created_at')->limit(5)->get(),
        ]);
    }

    private function revenueBetween(Carbon $from, Carbon $to): float
    {
        return (float)Payment::where('substatus', Payment::PAYMENT_SUCCESS)
            ->whereBetween('paid_at', [$from, $to])
            ->sum('total');
    }

    /**
     * Ingresos exitosos por mes, incluidos los meses sin ventas para que la serie no tenga huecos.
     */
    private function revenueByMonth(Carbon $now): Collection
    {
        $from = $now->copy()->startOfMonth()->subMonths(self::REVENUE_MONTHS - 1);

        $totals = Payment::where('substatus', Payment::PAYMENT_SUCCESS)
            ->where('paid_at', '>=', $from)
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') AS month, SUM(total) AS amount")
            ->groupBy('month')
            ->pluck('amount', 'month');

        return collect(range(0, self::REVENUE_MONTHS - 1))->map(function ($offset) use ($from, $totals) {
            $month = $from->copy()->addMonths($offset);

            return [
                'label'  => ucfirst($month->locale(app()->getLocale())->isoFormat('MMM')),
                'title'  => ucfirst($month->locale(app()->getLocale())->isoFormat('MMMM YYYY')),
                'amount' => (float)($totals[$month->format('Y-m')] ?? 0),
            ];
        });
    }

    /**
     * Suscripciones vigentes con el mismo criterio que ve el cliente (SubscriptionServices::getSubscriptionApproved).
     */
    private function activeSubscriptions(Carbon $today)
    {
        return Subscription::where('subscriptions.subscription_status', Subscription::STATUS_ACTIVE)
            ->whereDate('subscriptions.subscription_expires_at', '>=', $today);
    }

    private function withPlanNames(Collection $countByPlan): Collection
    {
        $names = Plan::pluck('name', 'source');

        return $countByPlan->map(fn($total, $source) => [
            'name'  => $names[$source] ?? capitalize_first($source),
            'total' => (int)$total,
        ])->sortByDesc('total')->values();
    }

    /**
     * Porcentaje de acierto de los picks de suscripción calificados en la ventana reciente.
     */
    private function pickAccuracy(Carbon $now): ?array
    {
        $graded = Pick::where('source', Pick::SOURCE_SUSCRIPTION)
            ->whereNotNull('right')
            ->where('created_at', '>=', $now->copy()->subDays(self::ACCURACY_DAYS))
            ->selectRaw('COUNT(*) AS total, SUM(`right` = 1) AS won')
            ->first();

        if (!$graded || !$graded->total) {
            return null;
        }

        return [
            'percent' => (int)round($graded->won / $graded->total * 100),
            'won'     => (int)$graded->won,
            'total'   => (int)$graded->total,
        ];
    }

    /**
     * Planes no Elite que vencen pronto (Elite dura un día, siempre aparecería).
     */
    private function expiringSoon(Carbon $today): Collection
    {
        return Subscription::getSubscription()
            ->where('subscriptions.subscription_status', Subscription::STATUS_ACTIVE)
            ->where('subscriptions.subscription_plan', '!=', Subscription::PLAN_ELITE)
            ->whereDate('subscriptions.subscription_expires_at', '>', $today)
            ->whereDate('subscriptions.subscription_expires_at', '<=', $today->copy()->addDays(self::EXPIRING_DAYS))
            ->reorder()
            ->orderBy('subscriptions.subscription_expires_at')
            ->limit(5)
            ->get();
    }
}
