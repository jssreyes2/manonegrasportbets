<?php

namespace App\Http\Middleware;

use App\Models\Rol;
use App\Models\User;
use App\Services\MiddlewareServices;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCompletedProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        return  app(MiddlewareServices::class)->checkCompletedProfile($request, $next);
    }
}
