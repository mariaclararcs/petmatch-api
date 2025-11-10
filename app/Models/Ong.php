<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ong extends Model
{
    /** @use HasFactory<\Database\Factories\OngFactory> */
    use HasFactory;

    use SoftDeletes;
    use HasUuids;

    protected $fillable = [
        'user_id',
        'name_institution',
        'document_responsible',
        'cnpj',
        'phone',
        'address',
        'cep',
        'description',
        'ong_image',
        'status'
    ];

    public function User(){
        return $this->belongsTo(User::class);
    }
}