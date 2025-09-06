<?php

namespace App\Http\Requests\Adopter;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdopterRequest extends FormRequest
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
            'id' => 'required',
            'user_id' => 'nullable',
            'name' => 'nullable',
            'birth_date' => 'nullable',
            'phone' => 'nullable',
            'address' => 'nullable',
            'cep' => 'nullable'
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
