<?php

namespace App\Http\Requests\Adoption;

use Illuminate\Foundation\Http\FormRequest;

class IndexAdoptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Mudar para true
    }

    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'per_page' => ['nullable', 'string'],
            'page' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:pending,approved,rejected'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->query('page', 1),
            'per_page' => $this->query('per_page', 10),
            'search' => $this->query('search'),
            'status' => $this->query('status'),
        ]);
    }
}