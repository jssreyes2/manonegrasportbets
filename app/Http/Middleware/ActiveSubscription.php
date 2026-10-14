<?php

namespace App\Http\Middleware;

use App\Services\User\SubscriptionServices;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveSubscription
{
    public function __construct(protected SubscriptionServices $subscriptionServices)
    {
    }

    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // El estado vive en la tabla subscriptions, no en users
        if (!$this->subscriptionServices->verfirySubscription()) {
            return redirect()
                ->route('plans')
                ->with(
                    'error',
                    'Necesitas un plan activo para ver los picks.'
                );
        }

        return $next($request);
    }
}
