<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class BankingInformationRequest extends FormRequest
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
            'bank_id'  => 'required|numeric',
            'document' => 'required|numeric|unique:banking_information,document,' . \Auth::user()->id,
            'phone'    => 'required|numeric|unique:banking_information,phone,' . \Auth::user()->id,
        ];
    }
    
    public function messages()
    {
        return [
            'bank_id.required'  => 'El campo bancos es obligatorio.',
            'bank_id.numeric'   => 'El campo bancos debe ser un número.',
            'document.required' => 'El campo cédula es obligatorio.',
            'document.numeric'  => 'El campo cédula debe ser un número.',
            'document.unique'   => 'Esta cédula ya está registrada.',
            'phone.required'    => 'El campo Teléfono es obligatorio.',
            'phone.numeric'     => 'El campo Teléfono debe ser un número.',
            'phone.unique'      => 'El Teléfono ya esta registrado.',
        ];
    }
}
