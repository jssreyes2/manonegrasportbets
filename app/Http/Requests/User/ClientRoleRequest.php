<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ClientRoleRequest extends FormRequest
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
            'email' => 'required|unique:users,email,' . \Auth::user()->id,
            'rol_id'   => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'email.required' => 'El campo correo electrónico es obligatorio.',
            'email.unique'   => 'El correo electrónico ya está registrada.',
            'rol_id.required'   => 'El campo tipo de usuario es obligatorio.',
        ];
    }
}
