<?php

namespace App\Services\Adopter;

use App\Models\Adopter;

class AdopterService {
    public function store(array $data){
        return Adopter::query()->create($data);
    }

    public function index(array $data){
        return Adopter::query()->paginate($data['per_page'], ['*'], 'page', $data['page'])
            ->toArray();
    }

    public function show(array $data){
        return Adopter::query()->findOrFail($data['id']);
    }

    public function update(array $data){
        return Adopter::query()->findOrFail($data['id'])->update($data);
    }

    public function delete(array $data){
        return Adopter::query()->findOrFail($data['id'])->delete();
    }
}