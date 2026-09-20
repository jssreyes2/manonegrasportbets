<?php

namespace App\Http\Requests\WebContent;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'full_name' => 'required|regex:/^[\pL\s]+$/u',
            'email'     => 'required|email',
            'comment'   => 'required|string',
        ];
    }
    
    public function messages()
    {
        return [
            'full_name.required' => 'El campo Nombre Completo es obligatorio.',
            'full_name.regex'    => 'El campo Nombre Completo solo debe contener letras y espacios.',
            'email.required'     => 'El campo Correo Electrónico es obligatorio.',
            'email.email'        => 'El formato del correo electrónico no es válido.',
            'comment.required'   => 'El campo comentario es obligatorio.',
            'comment.string'     => 'El campo comentario debe ser texto válido.',
        ];
    }
}
