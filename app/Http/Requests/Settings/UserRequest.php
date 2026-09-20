<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $rules = [
            'email'     => 'required|unique:users,email,' . $this->id,
            'the_terms' => 'required_if:rol_id,3|nullable',
            
        ];
        
        if (!$this->edit) {
            $rules['password'] = 'required|min:6';
        }
        
        if ($this->rol_id == 3) {
            $rules['password'] = 'required|min:6|confirmed';
        }
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'email.required'        => __t('text.backend.messages.email_required', 'El campo correo electrónico es obligatorio.'),
            'email.email'           => __t('text.backend.messages.email_format', 'El formato del correo electrónico no es válido.'),
            'email.unique'          => __t('text.backend.messages.email_unique', 'Este correo electrónico ya se encuentra registrado.'),
            'the_terms.required_if' => __t('text.backend.messages.the_terms_required', 'Debe aceptar los términos y condiciones.'),
            'password.required'     => __t('text.backend.messages.password_required', 'El campo contraseña es obligatorio.'),
            'password.min'          => __t('text.backend.messages.password_min', 'La contraseña debe tener al menos 8 caracteres.'),
            'password.confirmed'    => __t('text.backend.messages.password_confirmed', 'Las contraseñas ingresadas no coinciden.'),
        ];
    }
}
