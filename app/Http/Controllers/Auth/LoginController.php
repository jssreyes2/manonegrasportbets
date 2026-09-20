<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Services\AuthServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    
    public function __construct(protected AuthServices $auth){}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function login()
    {
        return view('auth.login');
    }
    
    /**
     * Handle an authentication attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request):JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json(['status' => 'fail', 'message' => __t('text.backend.messages.error_login_form', 'Campo correo electrónico o contraseña incorrectos')]);
        }
        
      return $this->auth->login($request);
    }
    
    public function logout(Request $request)
    {
        return $this->auth->logout($request);
    }
    
    public function showLoginForm(Request $request)
    {
        return $this->auth->logout( $request);
    }
    
}
