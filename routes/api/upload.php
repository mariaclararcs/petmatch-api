<?php

use App\Http\Controllers\Upload\UploadController;
use Illuminate\Support\Facades\Route;

Route::post('/upload', [UploadController::class, 'upload'])->name('api.upload');

