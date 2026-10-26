<?php

namespace App\Services;


use App\Models\Rol;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;

class AuthServices
{
    use AuthenticatesUsers;
    
    public function login($parameter) :JsonResponse
    {
        $this->validateLogin($parameter);
        
        if ($this->hasTooManyLoginAttempts($parameter)) {
            $this->fireLockoutEvent($parameter);
            
            return response()->json(['error_time' => true]);
        }
        
        if ($this->attemptLogin($parameter)) {

            $this->clearLoginAttempts($parameter);

            Auth::logoutOtherDevices($parameter->password);

            $user = Auth::user();

            // En cada rechazo se cierra la sesión: si no, el usuario quedaba autenticado aunque se le dijera que no
            if (empty($user->is_valid_email)) {
                Auth::guard()->logout();
                return response()->json(['status' => 'fail', 'unverified' => true, 'message' => __t('text.backend.messages.text_email_not_validate')]);
            }

            if ($user->is_active == 2) {
                Auth::guard()->logout();
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_login_user_suspend')]);
            }

            if (in_array($user->rol_id, [3]) && $parameter->source != 'web') {
                Auth::guard()->logout();
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.error_login_form', 'Campo correo electrónico o contraseña incorrectos')]);
            }

            if (in_array($user->rol_id, [1, 2]) && $parameter->source != 'admin') {
                Auth::guard()->logout();
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_unauthorized_login')]);
            }

            // Idioma elegido por el cliente en "Mi cuenta"
            if ($user->language) {
                session(['locale' => $user->language]);
            }

            return response()->json([
                'status'   => 'success',
                'message'  => __t('text.backend.messages.text_login_success'),
                'redirect' => $user->rol_id == Rol::ROL_CUSTOMER ? route('customer.home') : null,
            ]);
        }

        // Solo los intentos fallidos cuentan para el bloqueo temporal
        $this->incrementLoginAttempts($parameter);

        return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_login_fail')]);
    }
    
    
    public function logout($parameter = null)
    {
        Auth::logout();
        
        if ($parameter instanceof Request) {
            $parameter->session()->invalidate();
            $parameter->session()->regenerateToken();
        } else {
            session()->invalidate();
            session()->regenerateToken();
        }
        
        return redirect('/');
    }
}