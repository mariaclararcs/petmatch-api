<?php

use App\Http\Controllers\Adoption\AdoptionController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AdoptionController::class, 'store']);
Route::put('/{id}', [AdoptionController::class, 'update']);
Route::get('/', [AdoptionController::class, 'index']);
Route::get('/{id}', [AdoptionController::class, 'show']);
Route::delete('/{id}', [AdoptionController::class, 'destroy']);
