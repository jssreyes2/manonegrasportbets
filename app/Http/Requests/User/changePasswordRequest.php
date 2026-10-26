<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class changePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Cambia esto según tus necesidades de autorización
    }
    
    public function rules()
    {
        $user = \Auth::user();
        
        return [
            'email'            => 'required|email|max:191|unique:users,email,' . $user->id,
            // Las cuentas creadas con Google pueden no tener contraseña todavía
            'current_password' => $user->password ? 'required|current_password' : 'nullable',
            // Opcional: si se deja vacía solo se actualiza el correo
            'password'         => 'nullable|min:8|confirmed',
        ];
    }
    
    public function messages()
    {
        return [
            'email.required'                    => __t('text.frontend.ux.v_required'),
            'email.email'                       => __t('text.frontend.ux.v_email'),
            'email.unique'                      => __t('text.backend.messages.email_unique', 'Este correo electrónico ya se encuentra registrado.'),
            'current_password.required'         => __t('text.frontend.ux.v_required'),
            'current_password.current_password' => __t('text.backend.customer.current_password_wrong'),
            'password.min'                      => __t('text.frontend.ux.v_password_min'),
            'password.confirmed'                => __t('text.frontend.ux.v_password_match'),
        ];
    }
}
