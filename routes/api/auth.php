<?php

use App\Http\Controllers\Authentication\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)
    ->group(
        function () {
            Route::post(uri: '/login', action: 'login');
        }
    );