<?php

namespace App\Services\User;

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
        
        $plansActive = $this->getSubscriptionApproved();
        
        return view('dashboard.views.frm-subscription', compact('plans', 'plansActive'));
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
        
        if(!$subscriptions){
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
        
        foreach ($subscriptions as $key => $subscription) {
            $remainingDays = daysRemaining($subscription->subscription_expires_at);
            if ($remainingDays >= 0) {
                $plans[$key]['name']            = $subscription->subscription_plan;
                $plans[$key]['expiration_date'] = $subscription->subscription_expires_at->format('d/m/Y');
                $plans[$key]['remainingDays']   = $remainingDays;
                $plans[$key]['sure_bettor']   = $subscription->sure_bettor;
            }
        }
        
        return ['plans' => $plans];
    }
    
    public function verfirySubscription()
    {
        $subscriptionPlans = $this->getSubscriptionApproved();
        
        if (isset($subscriptionPlans['plans']) && count($subscriptionPlans['plans']) >0) {
            return true;
        }
        
        return false;
    }
    
}