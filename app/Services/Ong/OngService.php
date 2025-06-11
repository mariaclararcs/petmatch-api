<?php

namespace App\Services\Ong;

use App\Models\Ong;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class OngService
{

    /**
     * @param  array{
     *     search: string,
     *     page: string,
     *     per_page: string,
     * }  $data
     * @return LengthAwarePaginator<Ong>
     */
    public function index(array $data): LengthAwarePaginator
    {
        return Ong::query()->when($data['search'], fn (Builder $query)  =>
            $query->where('id', 'like', '%$search%')
        )->paginate(perPage: (int) $data['per_page'], page: (int) $data['page']);
    }

    /**
    * @param array<string,mixed> $data
    */
    public function store(array $data): Ong
    {
        return Ong::query()->create($data);
    }

    /**
    * @param array{id:string} $data
    */
    public function destroy(array $data): ?bool
    {
        return Ong::query()->findOrFail($data['id'])->delete();
    }

    /**
    * @param array{id:string} $data
    */
    public function show(array $data): ?Ong
    {
        return Ong::query()->findOrFail($data['id']);
    }

    /**
    * @param array{id:string} $data
    */
    public function update(array $data): bool
    {
        return Ong::query()->findOrFail($data['id'])->update($data);
    }
}