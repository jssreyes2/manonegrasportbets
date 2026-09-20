<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Register\PlanServices;
use App\Services\Whop\WhopWebhookServices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Matchable\Whop\WhopApiClient;

class CheckoutController extends Controller
{
    
    function __construct(protected WhopWebhookServices $whopWebhook)
    {
    }
    
    public function create(Request $request, WhopApiClient $whop)
    {
        return $this->whopWebhook->createCheckout($request->all(), $whop);
    }
    
    /**
     * Muestra la vista al usuario cuando regresa a la web.
     */
    public function complete(Request $request): View
    {
        return view('checkout.complete', [
            'status' => $request->query('status'),
        ]);
    }
}
