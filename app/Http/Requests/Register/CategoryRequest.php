<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name'      => 'required | unique:categories,name,' . $this->id,
            'destination' => 'required',
            'description' => 'required',
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'      => 'El campo Nombres es obligatorio.',
            'destination.required' => 'El campo Destino es obligatorio.',
            'description.required' => 'El campo Descripción es obligatorio.',
            'is_active.required' => 'El campo Nombres es obligatorio.',
        ];
    }
}
