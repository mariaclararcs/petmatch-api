<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/auth')->group(base_path('routes/api/auth.php'));

Route::prefix('/users')->group(base_path('routes/api/user.php'));

Route::prefix('/animal')->group(base_path('routes/api/animal.php'));