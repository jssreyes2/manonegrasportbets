<?php

namespace App\Http\Requests\WebContent;

use Illuminate\Foundation\Http\FormRequest;

class FrequentlyAskedQuestionRequest extends FormRequest
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
            'question'      => 'required | unique:frequently_asked_questions,question,' . $this->id,
            'answer' => 'required',
            'orden' => 'required',
            'is_active' => 'required',
        ];
    }
    
    public function messages()
    {
        return [
            'question.required'      => 'El campo Nombres es obligatorio.',
            'answer.required' => 'El campo Nombres es obligatorio.',
            'orden.required' => 'El campo Nombres es obligatorio.',
            'is_active.required' => 'El campo Nombres es obligatorio.',
        ];
    }
}
