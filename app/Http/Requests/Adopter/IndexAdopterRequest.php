<?php

namespace App\Http\Requests\Adopter;

use Illuminate\Foundation\Http\FormRequest;

class IndexAdopterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'per_page' => ['nullable', 'string'],
            'page' => ['nullable', 'string'],
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
            'page' => $this->query('page', 1),
            'per_page' => $this->query('per_page', 10),
            'search' => $this->query('search'),
        ]);
    }
}
