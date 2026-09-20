<?php

namespace App\Http\Requests\Operation;

use Illuminate\Foundation\Http\FormRequest;

class PickRequest extends FormRequest
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
            'plan_id'   => 'required',
            'body'     => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'      => 'El campo Plna es obligatorio.',
            'body.required'     => 'El campo Contenido es obligatorio.',
        ];
    }
}
