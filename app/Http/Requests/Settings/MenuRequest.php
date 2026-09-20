<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
            'type'      => 'required',
            'name'      => 'required|string',
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'type.required'      => 'El campo identificación es obligatorio.',
            'name.required'      => 'El campo Nombres es obligatorio.',
            'is_active.required' => 'El campo estatus es obligatorio.',
        ];
    }
}
