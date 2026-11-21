<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch($locale)
    {
        if (in_array($locale, [Country::LANGUAGE_ES, Country::LANGUAGE_EN])) {
            // Guardamos explícitamente en la sesión
            session()->put('locale', $locale);
            // Establecemos el idioma en la aplicación inmediatamente
            app()->setLocale($locale);

            // Se recuerda en el usuario para los avisos que se envían fuera de su sesión (push)
            if ($user = auth()->user()) {
                $user->forceFill(['language' => $locale])->save();
            }
        }
        
        return redirect()->back();
    }
}
