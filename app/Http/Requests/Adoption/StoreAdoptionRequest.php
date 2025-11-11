<?php

namespace App\Http\Requests\Adoption;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdoptionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'animal_id' => 'required|exists:animals,id',
            'name_adopter' => 'required|string|max:255',
            'email_adopter' => 'required|email|max:255',
            'birth_date' => 'required|date|before:today',
            'phone_adopter' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'cep' => 'required|string|max:10',
            'quest1' => 'required|string|max:1000',
            'quest2' => 'required|string|max:1000',
            'quest3' => 'required|string|max:1000',
            'quest4' => 'required|string|max:1000',
            'quest5' => 'required|string|max:1000',
            'quest6' => 'required|string|max:1000',
            'quest7' => 'required|string|max:1000',
            'quest8' => 'required|string|max:1000',
            'quest9' => 'required|string|max:1000',
            'quest10' => 'required|string|max:1000',
        ];
    }
}