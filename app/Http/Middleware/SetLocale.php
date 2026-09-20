<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Si existe en la sesión, tiene máxima prioridad
        if (session()->has('locale')) {
            $locale = session('locale');
        }
        // Si viene por parámetro en la URL (ej: ?lang=es)
        elseif ($request->has('lang') && in_array($request->lang, [Country::LANGUAGE_ES, Country::LANGUAGE_EN])) {
            $locale = $request->lang;
            session(['locale' => $locale]);
        }
        else {
            $locale = Country::LANGUAGE_EN; // Por defecto
        }
        
        App::setLocale($locale);
        
        return $next($request);
    }
}