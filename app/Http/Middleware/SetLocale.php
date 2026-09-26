<?php

namespace App\Http\Middleware;

use App\Models\Country;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    private const SUPPORTED_LOCALES = [
        Country::LANGUAGE_ES,
        Country::LANGUAGE_EN,
    ];
    
    private const ADMIN_ROLES = [1, 2];
    
    public function handle(Request $request, Closure $next): Response
    {
        App::setLocale($this->resolveLocale($request));
        
        return $next($request);
    }
    
    private function resolveLocale(Request $request): string
    {
        $isAdmin = $this->isAdmin(Auth::user()?->rol_id);
        
        // 1. Query string (?lang=xx) — prioridad máxima
        if ($this->isValidLocale($request->query('lang'))) {
            $locale = $request->query('lang');
            
            // Solo persistimos si NO es admin
            if (! $isAdmin) {
                session(['locale' => $locale]);
            }
            
            return $locale;
        }
        
        // 2. Si es admin → destruimos cualquier locale guardado y forzamos español
        if ($isAdmin) {
            session()->forget('locale');
            
            return Country::LANGUAGE_ES;
        }
        
        // 3. Sesión (solo para no-admins)
        if ($this->isValidLocale(session('locale'))) {
            return session('locale');
        }
        
        // 4. Fallback para invitados / usuarios normales
        $locale = Country::LANGUAGE_EN;
        session(['locale' => $locale]);
        
        return $locale;
    }
    
    private function isAdmin(?int $roleId): bool
    {
        return in_array($roleId, self::ADMIN_ROLES, true);
    }
    
    private function isValidLocale(?string $locale): bool
    {
        return $locale !== null && in_array($locale, self::SUPPORTED_LOCALES, true);
    }
}