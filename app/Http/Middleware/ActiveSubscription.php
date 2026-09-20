<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ActiveSubscription
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $user = $request->user();
        
        if (!$user) {
            return redirect()->route('login');
        }
        
        $active =
            $user->subscription_status === 'active'
            && (
                $user->subscription_expires_at === null
                || $user->subscription_expires_at->isFuture()
            );
        
        if (!$active) {
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