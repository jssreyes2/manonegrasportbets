<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class WebSuscriptionRequest extends FormRequest
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
        $rules = [
            'email'     => 'required|unique:web_suscriptions,email,' . $this->id,
            'full_name' => ['required', 'string', 'max:255', 'regex:/^[\pL\s]+$/u'],
        
        ];
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'email.required'     => 'El campo correo electrónico es obligatorio.',
            'email.email'        => 'El formato del correo electrónico no es válido.',
            'email.unique'       => 'Este correo electrónico ya se encuentra registrado.',
            'full_name.required' => 'El nombre completo es obligatorio.',
            'full_name.regex'    => 'El nombre completo solo debe contener letras y espacios.',
        ];
    }
}
