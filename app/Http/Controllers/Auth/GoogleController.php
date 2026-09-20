<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }
    
    public function handleGoogleCallback()
    {
        if (request()->has('error')) {
            return redirect()->route('show.login')->with('error', 'Acceso cancelado. Por favor, intenta nuevamente.');
        }
        
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            $user = User::where('email', $googleUser->email)->first();
            
            if (!$user) {

                $user = User::create([
                    'email'     => $googleUser->email,
                    'password'  => null,
                    'rol_id'    => Rol::ROL_CUSTOMER,
                    'is_active' => true,
                    'google_id' => $googleUser->id,
                ]);
                
                UserProfile::create([
                    'user_id' => $user->id,
                    'name'    => $googleUser->name,
                    'avatar'  => $googleUser->avatar,
                ]);
                
                Auth::login($user);
                
                return redirect()->route('subscription');
            }
            
            Auth::login($user);
            
            return redirect()->route('dasboard.index');
            
        } catch (\Throwable $e) {
            
            throw $e;
            
            return redirect()->route('show.login')->with('error', 'Error al iniciar sesión con Google: ' . $e->getMessage());
        }
    }
}
