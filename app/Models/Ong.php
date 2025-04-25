<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ong extends Model
{
    use HasFactory, SoftDeletes, HasUuids;

    protected $table = 'ongs';

    protected $fillable = [
        'id',
        'user_id',
        'name_institution',
        'name_responsible',
        'document_responsible',
        'cnpj',
        'phone',
        'address',
        'cep',
        'description',
        'status',
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'cnpj' => 'string',
        'phone' => 'string',
        'cep' => 'string',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
