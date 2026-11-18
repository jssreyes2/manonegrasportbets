<?php

namespace App\Http\Controllers\Dashboard;

use App\Services\Register\PlanServices;
use App\Services\Whop\WhopWebhookServices;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Matchable\Whop\WhopApiClient;

class CheckoutController extends Controller
{
    
    function __construct(protected WhopWebhookServices $whopWebhook)
    {
    }
    
    /**
     * Los planes se compran desde la vista de Suscripción del panel.
     * Se conserva el aviso que deja ActiveSubscription (flash 'error')
     * como 'warning', que es lo que muestra esa vista.
     */
    public function plans(): RedirectResponse
    {
        $redirect = redirect()->route('subscription');

        if (session()->has('error')) {
            $redirect->with('warning', session('error'));
        }

        return $redirect;
    }

    public function create(Request $request, WhopApiClient $whop)
    {
        return $this->whopWebhook->createCheckout($request->all(), $whop);
    }
    
    /**
     * Checkout directo desde el correo de renovación. Mismas validaciones que create():
     * un plan vigente no se puede volver a pagar.
     */
    public function renew(string $plan, WhopApiClient $whop)
    {
        return $this->whopWebhook->createCheckout(['plan_slug' => $plan], $whop);
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
