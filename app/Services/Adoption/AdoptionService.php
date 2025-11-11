<?php

namespace App\Services\Adoption;

use App\Models\Adoption;
use App\Models\Animal;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class AdoptionService {
    
    /**
     * @param  array{
     *     search?: string,
     *     page?: string,
     *     per_page?: string,
     *     status?: string|null,
     * }  $data
     */
    public function index(array $data): LengthAwarePaginator
    {
        $user = Auth::user();
        
        return Adoption::query()
            ->with([
                'adopter:id,name,email,avatar',
                'animal:id,name,age,gender,type,size,image',
                'ong:id,name_institution' // Corrigido para name_institution
            ])
            ->when($user->type_user === 'ong', function(Builder $query) use ($user) {
                // ONG só vê as adoções dos seus animais
                return $query->whereHas('animal', function($q) use ($user) {
                    $q->where('ong_id', $user->ong->id);
                });
            })
            ->when($user->type_user === 'adopter', function(Builder $query) use ($user) {
                // Adotante só vê suas próprias adoções
                return $query->where('adopter_id', $user->id);
            })
            ->when($data['search'] ?? null, fn (Builder $query, string $search)  =>
                $query->where(function($q) use ($search) {
                    $q->where('name_adopter', 'like', '%' . $search . '%')
                      ->orWhere('email_adopter', 'like', '%' . $search . '%')
                      ->orWhereHas('animal', function($animalQuery) use ($search) {
                          $animalQuery->where('name', 'like', '%' . $search . '%');
                      });
                })
            )
            ->when($data['status'] ?? null, fn (Builder $query, string $status)  =>
                $query->where('status', $status)
            )
            ->orderBy('created_at', 'desc')
            ->paginate(perPage: (int) ($data['per_page'] ?? 15), page: (int) ($data['page'] ?? 1));
    }

    public function store(array $data): Adoption
    {
        $animal = Animal::findOrFail($data['animal_id']);
        
        return Adoption::create([
            ...$data,
            'adopter_id' => Auth::id(),
            'ong_id' => $animal->ong_id,
            'request_at' => now(),
        ]);
    }

    public function updateStatus(string $id, string $status): Adoption
    {
        $adoption = Adoption::findOrFail($id);
        
        // Verificar se o usuário é da ONG dona do animal
        if (Auth::user()->ong->id !== $adoption->ong_id) {
            abort(403, 'Unauthorized');
        }
        
        $adoption->update(['status' => $status]);
        
        return $adoption;
    }

    /**
     * @param array{id:string} $data
     */
    public function show(array $data): Adoption
    {
        $user = Auth::user();
        
        $adoption = Adoption::with([
            'adopter:id,name,email,avatar',
            'animal:id,name,age,gender,type,size,image,ong_id',
            'ong:id,name_institution'
        ])->findOrFail($data['id']);

        // Verificar permissões
        if ($user->type_user === 'ong' && $adoption->ong_id !== $user->ong->id) {
            abort(403, 'Unauthorized');
        }

        if ($user->type_user === 'adopter' && $adoption->adopter_id !== $user->id) {
            abort(403, 'Unauthorized');
        }

        return $adoption;
    }
}