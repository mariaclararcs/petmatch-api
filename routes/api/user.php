<?php

use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::controller(UserController::class)
    ->group(function () {
        Route::post(uri: '/', action: 'store')
            ->name('user.store');

        Route::middleware(['jwt.auth'])->group(function () {
            Route::get(uri: '/', action: 'index')
                ->name('user.index');

            Route::get(uri: '/{id}', action: 'show')
                ->name('user.show');

            Route::put(uri: '/{id}', action: 'update')
                ->name('user.update');

            Route::patch(uri: '/{id}', action: 'restore')
                ->name('user.restore');

            Route::delete(uri: '/{id}', action: 'destroy')
                ->name('user.destroy');
        });
    });