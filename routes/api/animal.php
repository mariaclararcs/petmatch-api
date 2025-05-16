<?php

use App\Http\Controllers\Animal\AnimalController;
use Illuminate\Support\Facades\Route;

Route::controller(AnimalController::class)
    ->group(function () {
        Route::post(uri: '/', action: 'store')
            ->name('animal.store');

        Route::get(uri: '/', action: 'index')
            ->name('animal.index');

        Route::get(uri: '/{id}', action: 'show')
            ->name('animal.show');

        Route::put(uri: '/{id}', action: 'update')
            ->name('animal.update');

        Route::patch(uri: '/{id}', action: 'restore')
            ->name('animal.restore');

        Route::delete(uri: '/{id}', action: 'destroy')
            ->name('animal.destroy');
    });