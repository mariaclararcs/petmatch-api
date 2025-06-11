<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users',UserController::class)
    ->parameters(['id' => 'id']);
