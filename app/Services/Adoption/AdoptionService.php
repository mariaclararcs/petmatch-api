<?php

namespace App\Services\Adoption;

use App\Models\Adoption;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class AdoptionService {
/**
     * @param  array{
     *     search: string,
     *     page: string,
     *     per_page: string,
     * }  $data
     * @return LengthAwarePaginator<Adoption>
     */
    public function index(array $data): LengthAwarePaginator
    {
        return Adoption::query()
            ->with([
                'adopter.user:id,name,email,type_user,avatar',
                'animal:id,ong_id,name,age,gender,type,size,shelter_date,image,description'
            ])
            ->when($data['search'], fn (Builder $query)  =>
                $query->where('id', 'like', '%' . $data['search'] . '%')
            )
            ->paginate(perPage: (int) $data['per_page'], page: (int) $data['page']);
    }
}