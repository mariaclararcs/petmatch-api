<?php

namespace App\Http\Requests\Adoption;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdoptionStatusRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => 'required|in:pending,approved,rejected'
        ];
    }
}