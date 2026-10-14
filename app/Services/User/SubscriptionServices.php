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
        $user = Auth::user();
        if ($user && !$user->profile?->completed_profile) {
            return redirect()->route('profile');
        }
        
        $plans = $this->plan->getPlans(['is_active' => true])->get();
        
        $plansActive  = $this->getSubscriptionApproved();
        $subscription = $user?->subscriptions()->where('subscription_plan', Subscription::PLAN_ELITE)->where('subscription_status', Subscription::STATUS_ACTIVE)->first();
        $msgElite     = null;
        if ($subscription && $subscription->subscription_expires_at?->isFuture()) {
            
            $msgElite = __t('text.backend.messages.my_plan', $msgElite);
            
            $msgElite = str_replace(
                ['[PLAN]', '[DATE]'],
                [Subscription::PLAN_ELITE, $subscription->subscription_expires_at->format('d/m/Y')],
                $msgElite
            );
        }
        
        return view('dashboard.views.frm-subscription', compact('plans', 'plansActive', 'msgElite'));
    }
    
    public function getClientSubscription()
    {
        $user = Auth::user();
        if ($user && !$user->profile?->completed_profile) {
            return redirect()->route('profile');
        }
        
        $plans = $this->plan->getPlans(['is_active' => true])->get();
        
        $plansActive = $this->getSubscriptionApproved();
        
        return view('dashboard.views.frm-subscription', compact('plans', 'plansActive'));
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