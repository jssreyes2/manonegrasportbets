<?php

namespace App\Http\Requests\User;

use App\Models\Rol;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
    
    public function rules()
    {
        $data = [
            'first_name' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
            'last_name'  => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/|max:255',
            'phone'      => 'required|numeric',
            'country_id' => 'required',
            'photo'      => 'nullable|file|extensions:jpeg,jpg,png|max:10240',
        ];
        
        return $data;
    }
    
    public function messages()
    {
        $data = [
            'first_name.required' => 'El campo Nombres es obligatorio.',
            'last_name.required'  => 'El campo apellidos es obligatorio.',
            'first_name.regex'    => 'El nombre solo puede contener letras y espacios.',
            'last_name.regex'     => 'El apellido solo puede contener letras y espacios.',
            'phone.required'      => 'El campo Teléfono es obligatorio.',
            'phone.numeric'       => 'El campo Teléfono debe ser númerico.',
            'country_id.required' => 'El campo país es obligatorio.',
            'photo.image'         => 'El archivo debe ser una imagen',
            'photo.mimes'         => 'La imagen debe ser de tipo: jpeg, png, jpg',
            'photo.max'           => 'La imagen no debe pesar más de 10MB',
        ];
        
        return $data;
    }
}
