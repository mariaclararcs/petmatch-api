<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable','string'],
            'per_page' => ['nullable','string'],
            'page' => ['nullable','string'],
        ];
    }

    public function attributes(): array
    {
        return [
            'search' => 'Pesquisa',
            'per_page' => 'Por página',
            'page' => 'Página',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->query('page', null),
            'per_page' => $this->query('per_page', null),
            'search' => $this->query('search', null),
        ]);
    }
}