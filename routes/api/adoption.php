<?php

use App\Http\Controllers\Adoption\AdoptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AdoptionController::class, 'index']);
Route::post('/', [AdoptionController::class, 'store']);
Route::get('/{id}', [AdoptionController::class, 'show']);
Route::patch('/{id}/status', [AdoptionController::class, 'updateStatus']);