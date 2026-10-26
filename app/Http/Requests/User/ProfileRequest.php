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
        return [
            'first_name.required' => __t('text.frontend.ux.v_required'),
            'last_name.required'  => __t('text.frontend.ux.v_required'),
            'first_name.regex'    => __t('text.frontend.ux.v_name'),
            'last_name.regex'     => __t('text.frontend.ux.v_name'),
            'phone.required'      => __t('text.frontend.ux.v_required'),
            'phone.numeric'       => __t('text.backend.customer.v_phone'),
            'country_id.required' => __t('text.frontend.ux.v_required'),
            'photo.extensions'    => __t('text.backend.customer.photo_bad_type'),
            'photo.max'           => __t('text.backend.customer.photo_too_big'),
        ];
    }
}
