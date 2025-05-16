<?php

namespace App\Services\Animal;

use App\Models\Animal;

class AnimalService {
    public function store(array $data): array
    {
        return Animal::create($data)->toArray();
    }

    public function destroy(array $data): array
    {
        $animal = Animal::find($data['id']);
        if ($animal instanceof Animal) {
            $animal->delete();
        }

        return Animal::onlyTrashed()->where('id', $data['id'])->first()?->toArray() ?? [];
    }

    public function restore(array $data): array
    {
        $animal = Animal::onlyTrashed()->where('id', $data['id'])->first();

        if ($animal) {
            $animal->restore();
        }

        return $animal ? $animal->toArray() : [];
    }

    public function update(array $data): array
    {
        Animal::where('id', $data['id'])->update($data);

        return Animal::find($data['id'])?->toArray() ?? [];
    }

    public function show(array $data): array
    {
        return Animal::find($data['id'])?->toArray() ?? [];
    }

    public function index(array $data): array
    {
        return Animal::paginate($data['per_page'], ['*'], 'page', $data['page'])
            ->toArray();
    }
}