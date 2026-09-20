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
        }
        
        return redirect()->back();
    }
}
