<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use App\Models\User;
use App\Services\User\SubscriptionServices;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckConfigureRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        
        if ($user->rol_id == Rol::ROL_CUSTOMER) {
            return redirect()->route('profile.customer');
        }
        
        if (in_array($user->rol_id, [Rol::ROL_FREELANCER, Rol::ROL_MENTOR, Rol::ROL_MARKETPLACE])) {
            return redirect()->route('profile.customer');
        }
        
        
        return $next($request);
    }
}
