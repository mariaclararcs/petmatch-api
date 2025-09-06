<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(base_path('routes/api/authentication.php'));

Route::prefix('/animals')->group(base_path('/routes/api/animal.php'));

require base_path('/routes/api/ong.php');

require base_path('/routes/api/user.php');

Route::prefix('/adopter')->group(base_path(path: '/routes/api/adopter.php'));