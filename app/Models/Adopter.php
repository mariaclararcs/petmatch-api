<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adopter extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'adopters';

    protected $fillable = [
        'user_id',
        'name',
        'birth_date',
        'phone',
        'address',
        'cep',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'birth_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function adoptions(): HasMany
    {
        return $this->hasMany(Adoption::class);
    }

    public function animals(): HasMany
    {
        return $this->hasMany(Animal::class);
    }
}
