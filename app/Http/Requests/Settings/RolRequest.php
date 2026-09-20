<?php

namespace App\Http\Requests\Settings;

use Illuminate\Foundation\Http\FormRequest;

class RolRequest extends FormRequest
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
            'name'      => 'required | unique:roles,name,' . $this->id,
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'      => 'El campo Nombres es obligatorio.',
            'is_active.required' => 'El campo Nombres es obligatorio.',
        ];
    }
}
