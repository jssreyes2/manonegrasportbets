<?php

namespace App\Http\Middleware;

use App\Services\AuthServices;
use App\Services\MiddlewareServices;
use App\Services\RolPermissionsServices;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRolPermissions
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $route)
    {
        return  app(MiddlewareServices::class)->checkRolPermissions($request, $next, $route);
    }
}
