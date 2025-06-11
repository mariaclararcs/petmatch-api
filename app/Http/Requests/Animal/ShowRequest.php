<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;

class ShowRequest extends FormRequest
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