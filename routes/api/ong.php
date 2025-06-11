<?php

use App\Http\Controllers\Ong\OngController;
use Illuminate\Support\Facades\Route;

Route::apiResource('ongs',OngController::class);
    