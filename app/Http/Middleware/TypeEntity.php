<?php

namespace App\Http\Middleware;

use App\Services\RolPermissionsServices;
use Closure;

class TypeEntity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, $type)
    {
        // Añadir el parámetro a la solicitud
        $request->attributes->set('type_entity', $type);
        
        return $next($request);
    }
}
