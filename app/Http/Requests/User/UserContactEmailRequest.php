<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserContactEmailRequest extends FormRequest
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
            'full_name'   => 'required|string',
            'subject'     => 'required|string',
            'description' => 'required|string',
        ];
    }
    
    public function messages()
    {
        return [
            'subject.required'     => 'El campo Asunto es obligatorio.',
            'full_name.required'   => 'El campo Nombres y Apellidos es obligatorio.',
            'description.required' => 'El campo Descipción es obligatorio.',
        ];
    }
}
