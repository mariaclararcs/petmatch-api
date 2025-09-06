<?php

use App\Http\Controllers\Adopter\AdopterController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AdopterController::class, 'store']);
Route::put('/{id}', [AdopterController::class, 'update']);
Route::get('/', [AdopterController::class, 'index']);
Route::get('/{id}', [AdopterController::class, 'show']);
Route::delete('/{id}', [AdopterController::class, 'destroy']);
