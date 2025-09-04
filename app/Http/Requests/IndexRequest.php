<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
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
    public function rules()
    {
        return [
            'per_page' => 'integer|min:1|max:100',
            'page' => 'integer|min:1',
            'search' => 'sometimes|string|max:255',
            'sort_by' => 'sometimes|string|in:name,age,shelter_date',
            'sort_order' => 'sometimes|string|in:asc,desc',
            'type' => 'sometimes|string|in:dog,cat,other',
            'gender' => 'sometimes|string|in:male,female',
            'min_age' => 'sometimes|integer|min:0',
            'max_age' => 'sometimes|integer|min:0',
            'ong_id' => 'sometimes|string|exists:ongs,id',
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->input('per_page', 10),
            'page' => $this->input('page', 1),
            'search' => $this->input('search', ''),
            'sort_by' => $this->input('sort_by', 'name'),
            'sort_order' => $this->input('sort_order', 'asc'),
        ]);
    }
}
