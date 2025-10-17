<?php

use App\Http\Controllers\Animal\AnimalController;
use Illuminate\Support\Facades\Route;

Route::post('/', [AnimalController::class, 'store']);
Route::put('/{id}', [AnimalController::class, 'update']);
Route::get('/', [AnimalController::class, 'index']);
Route::get('/{id}', [AnimalController::class, 'show']);
Route::get('/my-animals', [AnimalController::class, 'myAnimals']);
Route::delete('/{id}', [AnimalController::class, 'destroy']);
