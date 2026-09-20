<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
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
            'category_id' => 'required',
            'name'        => 'required | unique:categories,name,' . $this->id,
            'is_active'   => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.category_id'   => 'El campo Categoría es obligatorio.',
            'name.required'      => 'El campo Nombre es obligatorio.',
            'is_active.required' => 'El campo Estatus es obligatorio.',
        ];
    }
}
