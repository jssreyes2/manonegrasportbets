<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class ParameterRequest extends FormRequest
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
            'identification' => 'required',
            'company'        => 'required',
            'phone'          => 'required',
            'email'          => 'required',
            'address'        => 'required',
        ];
        
        return $rules;
    }
    
    public function messages()
    {
        return [
            'identification.required' => 'El campo Rif  es obligatorio.',
            'company.required'        => 'El campo Empresa es obligatorio.',
            'phone.required'          => 'El campo Teléfono es obligatorio.',
            'email.required'          => 'El campo correo electrónico es obligatorio.',
            'email.email'             => 'El formato del correo electrónico no es válido.',
            'address.required'        => 'El campo Dirección es obligatorio.',
        ];
    }
}
