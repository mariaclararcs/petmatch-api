<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'animals';

    protected $fillable = [
        'id',
        'ong_id',
        'name',
        'age',
        'gender',
        'type',
        'size',
        'shelter_date',
        'image',
        'description',
    ];

    protected $casts = [
        'id' => 'string',
        'ong_id' => 'string',
        'shelter_date' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function ongs(): BelongsTo
    {
        return $this->belongsTo(Ong::class, 'ong_id');
    }
}
