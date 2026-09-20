<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
        return [
            'is_customer' => 'required',
            'full_name'   => 'required',
            'email'       => 'required',
            'comment'     => 'required',
        
        ];
    }
    
    public function messages()
    {
        return [
            'is_customer.required' => 'El campo eres cliente es obligatorio.',
            'full_name.required'   => 'El campo nombres y apellidos cliente es obligatorio.',
            'email.required'       => 'El campo correo electrónico y apellidos cliente es obligatorio.',
            'comment.required'     => 'El campo comentarios electrónico y apellidos cliente es obligatorio.',
        
        ];
    }
}
