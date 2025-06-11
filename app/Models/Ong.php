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

}