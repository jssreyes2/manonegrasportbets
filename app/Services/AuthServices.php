<?php

namespace App\Services;


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
            
            $this->incrementLoginAttempts($parameter);
            
            Auth::logoutOtherDevices($parameter->password);
            
            if (empty(Auth::user()->is_valid_email)) {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_email_not_validate')]);
            }
            
            if (Auth::user()->is_active == 2) {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_login_user_suspend')]);
            }
            
            if (in_array(Auth::user()->rol_id, [3]) && $parameter->source != 'web') {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.error_login_form', 'Campo correo electrónico o contraseña incorrectos')]);
            }
            
            if (in_array(Auth::user()->rol_id, [1, 2]) && $parameter->source != 'admin') {
                return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_unauthorized_login')]);
            }
            
            return response()->json(['status' => 'success', 'message' => __t('text.backend.messages.text_login_success')]);
        }
        
        
        if ($parameter->loginFront) {
            return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.text_login_fail')]);
        }
        
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