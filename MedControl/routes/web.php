<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::middleware(['web'])
    ->prefix('admin')
    ->group(base_path('routes/admin.php'));
