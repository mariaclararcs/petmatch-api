<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            // Logic here
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