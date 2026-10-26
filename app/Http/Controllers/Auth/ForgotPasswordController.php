<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset StaticPageController
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
    
    protected function validateEmail(Request $request)
    {
        $request->validate(['email' => 'required|email'], [
            'email.required' => __t('text.frontend.ux.v_required'),
            'email.email'    => __t('text.frontend.ux.v_email'),
        ]);
    }
    
    /**
     * Un correo no registrado recibe la misma respuesta que uno válido, para no revelar qué cuentas existen.
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($response === Password::INVALID_USER) {
            return $this->sendResetLinkResponse($request, Password::RESET_LINK_SENT);
        }
        
        return back()->withInput($request->only('email'))->withErrors(['email' => trans($response)]);
    }
}
