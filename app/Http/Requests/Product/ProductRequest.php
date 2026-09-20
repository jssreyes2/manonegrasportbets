<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
            'name_prod'        => 'required | unique:products,name_prod,' . Auth::user()->id,
            'category_id'      => 'required',
            'subcategory_id'   => 'required',
            'description_prod' => 'required',
            'is_active'        => 'required',
            'price'            => 'required|numeric',
            'photo'            => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'name.required'             => 'El campo Nombres es obligatorio.',
            'category_id.required'      => 'El campo Categoría es obligatorio.',
            'subcategory_id.required'   => 'El campo Sub Categoría es obligatorio.',
            'description_prod.required' => 'El campo Descripción es obligatorio.',
            'is_active.required'        => 'El campo Nombres es obligatorio.',
            'price.required'            => 'El campo Precio es obligatorio y debe ser númerico.',
            'photo.required'            => 'El campo Foto es obligatorio.',
            'photo.image'               => 'El archivo debe ser una imagen.',
            'photo.mimes'               => 'La imagen debe ser de tipo: jpeg, png, jpg.',
            'photo.max'                 => 'La imagen no debe pesar más de 1MB.',
        ];
    }
}
