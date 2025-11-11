<?php

namespace App\Http\Resources\Adoption;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdoptionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'request_at' => $this->request_at,
            'created_at' => $this->created_at,
            
            // Dados do formulário
            'name_adopter' => $this->name_adopter,
            'email_adopter' => $this->email_adopter,
            'birth_date' => $this->birth_date,
            'phone_adopter' => $this->phone_adopter,
            'address' => $this->address,
            'cep' => $this->cep,
            
            // Questionário
            'quest1' => $this->quest1,
            'quest2' => $this->quest2,
            'quest3' => $this->quest3,
            'quest4' => $this->quest4,
            'quest5' => $this->quest5,
            'quest6' => $this->quest6,
            'quest7' => $this->quest7,
            'quest8' => $this->quest8,
            'quest9' => $this->quest9,
            'quest10' => $this->quest10,
            
            // Relacionamentos
            'adopter' => $this->whenLoaded('adopter', [
                'id' => $this->adopter->id,
                'name' => $this->adopter->name,
                'email' => $this->adopter->email,
                'avatar' => $this->adopter->avatar,
            ]),
            
            'animal' => $this->whenLoaded('animal', [
                'id' => $this->animal->id,
                'name' => $this->animal->name,
                'age' => $this->animal->age,
                'gender' => $this->animal->gender,
                'type' => $this->animal->type,
                'size' => $this->animal->size,
                'image' => $this->animal->image,
            ]),
            
            'ong' => $this->whenLoaded('ong', [
                'id' => $this->ong->id,
                'name_institution' => $this->ong->name_institution,
            ]),
        ];
    }
}