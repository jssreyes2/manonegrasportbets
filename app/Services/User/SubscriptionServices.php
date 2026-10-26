<?php

namespace App\Services\User;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\WebSuscription;
use App\Services\Register\CategoryServices;
use App\Services\Register\PlanServices;
use Illuminate\Support\Facades\Auth;

class SubscriptionServices
{
    
    public function __construct(protected PlanServices $plan)
    {
    }
    
    public function index()
    {
        return $this->subscriptionView();
    }

    public function getClientSubscription()
    {
        return $this->subscriptionView();
    }

    /**
     * Vista donde el cliente compra sus planes: catálogo, planes vigentes y aviso de inicio del Elite.
     */
    private function subscriptionView()
    {
        $user = Auth::user();
        if ($user && !$user->profile?->completed_profile) {
            return redirect()->route('profile');
        }

        // El scope filter ordena por precio; aquí el catálogo se muestra por ID
        $plans = $this->plan->getPlans(['is_active' => true])->reorder('id')->get();

        // Planes vigentes indexados por source para cruzarlos con el catálogo
        $activePlans = collect($this->getSubscriptionApproved()['plans'] ?? [])
            ->keyBy(fn($plan) => strtolower($plan['name']));

        // Si el pick Elite de hoy ya salió, un Elite comprado ahora empieza mañana
        $eliteStartsOn = Subscription::nextEliteDay();

        return view('dashboard.views.frm-subscription', compact('plans', 'activePlans', 'eliteStartsOn'));
    }
    
    public function getSubscription(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        
        $subscriptions = Subscription::getSubscription()->filter($filter)->paginate(config('app.npage'));
        
        $plans = $this->plan->getPlans()->get();
        
        return view('admin.operation.table-suscriptions', compact('subscriptions', 'filter', 'plans'));
    }
    
    public function getWebSubscription(array $data = [])
    {
        $filter = $data['filter'] ?? [];
        
        $webSubscriptions = WebSuscription::paginate(config('app.npage'));
        
        return view('admin.operation.table-web-suscriptions', compact('webSubscriptions', 'filter'));
    }
    
    public function getSubscriptionApproved(?string $plan = null): array
    {
        $user = Auth::user();
        
        $subscriptions = $user?->subscriptions();
        
        if (!$subscriptions) {
            return ['status' => 'fail', 'subscription' => null];
        }
        
        if ($plan) {
            $subscriptions = $subscriptions->where('subscription_plan', $plan);
        }
        
        $subscriptions->where('subscription_status', Subscription::STATUS_ACTIVE);
        $subscriptions = $subscriptions->get();
        
        if (count($subscriptions) == 0) {
            return ['status' => 'fail', 'subscription' => null];
        }
        
        $plans = [];
        
        $today = now()->startOfDay();

        foreach ($subscriptions as $subscription) {
            // daysRemaining() nunca devuelve negativos, por eso se valida el vencimiento directamente
            if (!$subscription->subscription_expires_at || $subscription->subscription_expires_at->copy()->startOfDay()->lt($today)) {
                continue;
            }

            // Índices consecutivos: createCheckout() consulta $plans[0]
            $plans[] = [
                'name'            => $subscription->subscription_plan,
                'expiration_date' => $subscription->subscription_expires_at->format('d/m/Y'),
                'remainingDays'   => daysRemaining($subscription->subscription_expires_at),
                'sure_bettor'     => $subscription->sure_bettor,
            ];
        }
        
        return ['plans' => $plans];
    }
    
    public function verfirySubscription()
    {
        $subscriptionPlans = $this->getSubscriptionApproved();
        
        if (isset($subscriptionPlans['plans']) && count($subscriptionPlans['plans']) > 0) {
            return true;
        }
        
        return false;
    }
    
}