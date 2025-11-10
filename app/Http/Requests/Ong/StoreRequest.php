<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'user_id' => 'required',
            'name_institution' => 'required',
            'document_responsible' => 'required',
            'cnpj' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'cep' => 'required',
            'description' => 'required',
            'status' => 'required',
        ];
    }

    public function attributes(): array
    {
        return [
            // Logic here
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            // Logic here
        ]);
    }
}