<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;

// Chema estuvo aquí 
Route::get('/', [HomeController::class, 'index']);
