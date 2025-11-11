<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'nullable',
            'name_institution' => 'nullable',
            'document_responsible' => 'nullable',
            'cnpj' => 'nullable',
            'phone' => 'nullable',
            'ong_email' => 'required|email|max:255',
            'address' => 'nullable',
            'cep' => 'nullable',
            'description' => 'nullable',
            'ong_image' => 'nullable|string',
            'status' => 'nullable',
        ];
    }
    
    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}