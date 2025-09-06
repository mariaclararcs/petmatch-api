<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'search' => ['nullable', 'string'],
            'per_page' => ['nullable', 'string'],
            'page' => ['nullable', 'string'],
            'sort_by' => ['nullable', 'string', 'in:name,age,shelter_date'],
            'sort_order' => ['nullable', 'string', 'in:asc,desc'],
            'type' => ['nullable', 'string', 'in:dog,cat,other'],
            'gender' => ['nullable', 'string', 'in:male,female'],
            'min_age' => ['nullable', 'integer', 'min:0'],
            'max_age' => ['nullable', 'integer', 'min:0'],
            'ong_id' => ['nullable', 'uuid']
        ];
    }

    public function attributes(): array
    {
        return [
            'search' => 'Pesquisa',
            'per_page' => 'Por página',
            'page' => 'Página',
            'sort_by' => 'Ordenar por',
            'sort_order' => 'Ordem',
            'type' => 'Tipo de animal',
            'gender' => 'Gênero',
            'min_age' => 'Idade mínima',
            'max_age' => 'Idade máxima',
            'ong_id' => 'Organização não governamental'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'page' => $this->query('page', 1),
            'per_page' => $this->query('per_page', 10),
            'search' => $this->query('search'),
            'sort_by' => $this->query('sort_by', 'name'),
            'sort_order' => $this->query('sort_order', 'asc'),
            'type' => $this->query('type'),
            'gender' => $this->query('gender'),
            'min_age' => $this->query('min_age'),
            'max_age' => $this->query('max_age'),
            'ong_id' => $this->query('ong_id'),
        ]);
    }
}
