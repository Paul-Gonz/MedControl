<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\Cuenta_BancariaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
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


Route::get('/Cuenta_Bancaria', [Cuenta_BancariaController::class, 'index'])->name('cuentas_bancarias.index');
Route::post('/Cuenta_Bancaria', [Cuenta_BancariaController::class, 'store'])->name('cuentas_bancarias.store');
Route::post('/Cuenta_Bancaria/update', [Cuenta_BancariaController::class, 'update'])->name('cuentas_bancarias.update');
Route::post('/Cuenta_Bancaria/destroy', [Cuenta_BancariaController::class, 'destroy'])->name('cuentas_bancarias.destroy');

Route::resource('usuarios', UsuarioController::class);

Route::post('/login', [LoginController::class, 'login'])->name('login.process');