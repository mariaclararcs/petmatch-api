<?php

namespace App\Services\Animal;

use App\Models\Animal;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AnimalService
{
    /**
     * @param  array{
     *     search: string,
     *     page: string,
     *     per_page: string,
     *     sort_by: string,
     *     sort_order: string,
     *     type: string|null,
     *     gender: string|null,
     *     min_age: int|null,
     *     max_age: int|null,
     *     ong_id: string|null,
     * }  $data
     * @return LengthAwarePaginator<Animal>
     */
    public function index(array $data): LengthAwarePaginator
    {
        $query = Animal::query();

        // Search by name
        if (!empty($data['search'])) {
            $query->where('name', 'like', '%' . $data['search'] . '%');
        }

        // Filter by type
        if (!empty($data['type'])) {
            $query->where('type', $data['type']);
        }

        // Filter by gender
        if (!empty($data['gender'])) {
            $query->where('gender', $data['gender']);
        }

        // Filter by age range
        if (!empty($data['min_age'])) {
            $query->where('age', '>=', $data['min_age']);
        }
        if (!empty($data['max_age'])) {
            $query->where('age', '<=', $data['max_age']);
        }

        // Filter by ONG
        if (!empty($data['ong_id'])) {
            $query->where('ong_id', $data['ong_id']);
        }

        // Sort by field
        $sortBy = $data['sort_by'] ?? 'name';
        $sortOrder = $data['sort_order'] ?? 'asc';
        $query->orderBy($sortBy, $sortOrder)->with('ong:id,name_institution');

        return $query->paginate(
            perPage: (int) $data['per_page'],
            page: (int) $data['page']
        );
    }

    /**
     * @param array<string,mixed> $data
     */
    public function store(array $data): Animal
    {
        return Animal::query()->create($data);
    }

    /**
     * @param array{id:string} $data
     */
    public function destroy(array $data): ?bool
    {
        return Animal::query()->findOrFail($data['id'])->delete();
    }

    /**
     * @param array{id:string} $data
     */
    public function show(array $data): ?Animal
    {
        return Animal::query()
            ->with('ong:id,name_institution')
            ->findOrFail($data['id']);
    }

    /**
     * @param array{id:string} $data
     */
    public function update(array $data): bool
    {
        return Animal::query()->findOrFail($data['id'])->update($data);
    }
}
