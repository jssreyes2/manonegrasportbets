<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\User\SubscriptionServices;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    
    public function __construct(protected SubscriptionServices $subscription)
    {
    }
    
    public function subscription()
    {
        return $this->subscription->index();
    }
    
    public function getClientSubscription()
    {
        return $this->subscription->getClientSubscription();
    }
    
    public function getSubscription(Request $request)
    {
        return $this->subscription->getSubscription($request->all());
    }
    
    public function getWebSubscription(Request $request)
    {
        return $this->subscription->getWebSubscription($request->all());
    }
    
}
