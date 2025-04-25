<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adoption extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'adoptions';

    protected $fillable = [
        'id',
        'adopter_id',
        'animal_id',
        'request_date',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'adopter_id' => 'string',
        'animal_id' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'request_date' => 'datetime',
    ];

    public function adopter(): BelongsTo
    {
        return $this->belongsTo(Adopter::class, 'adopter_id', 'id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id', 'id');
    }
}
