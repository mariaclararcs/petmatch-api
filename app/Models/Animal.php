<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Animal extends Model
{
    /** @use HasFactory<\Database\Factories\AnimalFactory> */
    use HasFactory;

    use SoftDeletes;
    use HasUuids;

    protected $table = 'animals';

    protected $fillable = [
        'ong_id',
        'name',
        'age',
        'gender',
        'type',
        'size',
        'shelter_date',
        'image',
        'description'
    ];
}
