<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;

use App\Http\Controllers\ExpedienteController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::middleware(['web'])->prefix('admin')->group(base_path('routes/admin.php'));

Route::get('/Pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
Route::post('/Pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::post('/Pacientes/update', [PacientesController::class, 'update'])->name('pacientes.update');
Route::post('/Pacientes/destroy', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

Route::resource('doctores', App\Http\Controllers\DoctorController::class);


Route::get('/Expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
Route::post('/Expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');
Route::post('/Expedientes/update', [ExpedienteController::class, 'update'])->name('expedientes.update');
Route::post('/Expedientes/destroy', [ExpedienteController::class, 'destroy'])->name('expedientes.destroy');
