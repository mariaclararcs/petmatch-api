<?php

namespace App\Http\Requests\Animal;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'id' => 'nullable',
            'ong_id' => 'required|exists:ongs,id',
            'name' => 'required|string|max:255',
            'age' => 'required|integer',
            'gender' => 'required|in:male,female',
            'type' => 'required|in:dog,cat,other',
            'size' => 'required|in:small,medium,large',
            'shelter_date' => 'required|date',
            'image' => 'required|string|max:2048',
            'description' => 'required|string|max:1000',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'id' => $this->route('id'),
        ]);
    }
}
