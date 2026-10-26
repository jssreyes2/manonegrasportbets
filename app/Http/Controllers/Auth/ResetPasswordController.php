<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset StaticPageController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    /**
     * Guarda la nueva contraseña sin iniciar sesión: el cliente entra por el login de la web.
     * Usar el enlace del correo demuestra que el correo es suyo, por eso queda verificado.
     */
    protected function resetPassword($user, $password)
    {
        $user->password = Hash::make($password);
        $user->setRememberToken(Str::random(60));
        
        if (!$user->is_valid_email) {
            $user->is_valid_email = true;
        }
        
        $user->save();
        
        event(new PasswordReset($user));
    }
    
    protected function rules()
    {
        return [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:8',
        ];
    }
    
    protected function validationErrorMessages()
    {
        return [
            'email.required'     => __t('text.frontend.ux.v_required'),
            'email.email'        => __t('text.frontend.ux.v_email'),
            'password.required'  => __t('text.frontend.ux.v_required'),
            'password.min'       => __t('text.frontend.ux.v_password_min'),
            'password.confirmed' => __t('text.frontend.ux.v_password_match'),
        ];
    }
    
    protected function sendResetResponse(Request $request, $response)
    {
        return redirect()->route('show.login-customer')->with('status', trans($response));
    }
}
