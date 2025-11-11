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
        'ong_id',
        'name_adopter',
        'email_adopter',
        'birth_date',
        'phone_adopter',
        'address',
        'cep',
        'quest1',
        'quest2',
        'quest3',
        'quest4',
        'quest5',
        'quest6',
        'quest7',
        'quest8',
        'quest9',
        'quest10',
        'status',
        'request_at'
    ];

    protected $casts = [
        'id' => 'string',
        'adopter_id' => 'string',
        'animal_id' => 'string',
        'ong_id' => 'string',
        'name_adopter' => 'string',
        'email_adopter' => 'string',
        'birth_date' => 'date',
        'phone_adopter' => 'string',
        'address' => 'string',
        'cep' => 'string',
        'quest1' => 'string',
        'quest2' => 'string',
        'quest3' => 'string',
        'quest4' => 'string',
        'quest5' => 'string',
        'quest6' => 'string',
        'quest7' => 'string',
        'quest8' => 'string',
        'quest9' => 'string',
        'quest10' => 'string',
        'status' => 'string',
        'request_at' => 'datetime'
    ];

    public function adopter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'adopter_id');
    }

    public function animal(): BelongsTo
    {
        return $this->belongsTo(Animal::class, 'animal_id');
    }

    public function ong(): BelongsTo
    {
        return $this->belongsTo(Ong::class, 'ong_id');
    }
}