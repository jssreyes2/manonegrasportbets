<?php

namespace App\Http\Requests\Register;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
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
            'name' => [
                'required',
                Rule::unique('plans', 'name')->ignore($this->id)->where(function ($query) {
                    return $query->where('language', $this->language);
                }),
            ],
            'price'       => 'required',
            'recommended' => 'required',
            'is_active'   => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'        => 'El campo Nombre es obligatorio.',
            'price.required'       => 'El campo Precio es obligatorio.',
            'recommended.required' => 'El campo Recomendado es obligatorio.',
            'is_active.required'   => 'El campo Estatus es obligatorio.',
        ];
    }
}
