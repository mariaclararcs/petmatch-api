<?php

namespace App\Http\Requests\Ong;

use Illuminate\Foundation\Http\FormRequest;

class DestroyRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'required',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}