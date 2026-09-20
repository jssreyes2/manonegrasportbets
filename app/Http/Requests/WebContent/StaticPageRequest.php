<?php

namespace App\Http\Requests\WebContent;

use Illuminate\Foundation\Http\FormRequest;

class StaticPageRequest extends FormRequest
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
        return [
            'title'     => 'required | unique:static_pages,title,' . $this->id,
            'body'      => 'required',
            'type'      => 'required',
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'title.required'     => 'El titulo es obligatorio.',
            'body.required'      => 'La descripción es obligatoria.',
            'type.required'      => 'Eltipo es obligatorio.',
            'is_active.required' => 'El campo estatus es obligatorio.',
        ];
    }
}
