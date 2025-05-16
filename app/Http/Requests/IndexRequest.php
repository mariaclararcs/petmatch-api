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
        ];
    }

    public function prepareForValidation()
    {
        $this->merge([
            'per_page' => $this->input('per_page', 10),
            'page' => $this->input('page', 1),
        ]);
    }
}
