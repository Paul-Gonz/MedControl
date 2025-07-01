<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\Cuenta_BancariaController;
use App\Http\Controllers\ConsultorioController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\EspecialidadController;
use App\Http\Controllers\TipoConsultorioController;


Route::get('/', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/Pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
Route::post('/Pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::post('/Pacientes/update', [PacientesController::class, 'update'])->name('pacientes.update');
Route::post('/Pacientes/destroy', [PacientesController::class, 'destroy'])->name('pacientes.destroy');

Route::get('/Doctores', [App\Http\Controllers\DoctorController::class, 'index'])->name('doctores.index');
Route::post('/Doctores', [App\Http\Controllers\DoctorController::class, 'store'])->name('doctores.store');
Route::post('/Doctores/update', [App\Http\Controllers\DoctorController::class, 'update'])->name('doctores.update');
Route::post('/Doctores/destroy', [App\Http\Controllers\DoctorController::class, 'destroy'])->name('doctores.destroy');
Route::post('/Doctores/{id}', [DoctorController::class, 'update'])->name('doctores.update');

Route::get('/Expedientes', [ExpedienteController::class, 'index'])->name('expedientes.index');
Route::post('/Expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');
Route::post('/Expedientes/update', [ExpedienteController::class, 'update'])->name('expedientes.update');
Route::post('/Expedientes/destroy', [ExpedienteController::class, 'destroy'])->name('expedientes.destroy');

Route::get('/Cuenta_Bancaria', [Cuenta_BancariaController::class, 'index'])->name('cuentas_bancarias.index');
Route::post('/Cuenta_Bancaria', [Cuenta_BancariaController::class, 'store'])->name('cuentas_bancarias.store');
Route::post('/Cuenta_Bancaria/update', [Cuenta_BancariaController::class, 'update'])->name('cuentas_bancarias.update');
Route::post('/Cuenta_Bancaria/destroy', [Cuenta_BancariaController::class, 'destroy'])->name('cuentas_bancarias.destroy');

Route::get('/Usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::post('/Usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
Route::post('/Usuarios/update', [UsuarioController::class, 'update'])->name('usuarios.update');
Route::post('/Usuarios/destroy', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

Route::post('/login', [LoginController::class, 'login'])->name('login.process');

Route::get('/Especialidades', [App\Http\Controllers\EspecialidadController::class, 'index'])->name('especialidades.index');
Route::post('/Especialidades', [App\Http\Controllers\EspecialidadController::class, 'store'])->name('especialidades.store');
Route::post('/Especialidades/update', [App\Http\Controllers\EspecialidadController::class, 'update'])->name('especialidades.update');
Route::post('/Especialidades/destroy', [App\Http\Controllers\EspecialidadController::class, 'destroy'])->name('especialidades.destroy');

Route::get('/Consultorios', [ConsultorioController::class, 'index'])->name('consultorios.index');
Route::post('/Consultorios', [ConsultorioController::class, 'store'])->name('consultorios.store');
Route::put('/Consultorios/update/{id}', [ConsultorioController::class, 'update'])->name('consultorios.update');
Route::delete('/Consultorios/destroy/{id}', [ConsultorioController::class, 'destroy'])->name('consultorios.destroy');

Route::get('/TiposConsultorio', [App\Http\Controllers\TipoConsultorioController::class, 'index'])->name('tipos-consultorio.index');
Route::post('/TiposConsultorio', [App\Http\Controllers\TipoConsultorioController::class, 'store'])->name('tipos-consultorio.store');
Route::post('/TiposConsultorio/update/{id}', [App\Http\Controllers\TipoConsultorioController::class, 'update'])->name('tipos-consultorio.update');
Route::post('/TiposConsultorio/destroy/{id}', [App\Http\Controllers\TipoConsultorioController::class, 'destroy'])->name('tipos-consultorio.destroy');

Route::resource('citas', CitaController::class);

Route::resource('pagos', App\Http\Controllers\PagoController::class);


//reportes
Route::get('/Pacientes/pdf', [PacientesController::class, 'reporte'])->name('pacientes.reporte');
Route::get('/Doctores/pdf', [DoctorController::class, 'reporte'])->name('doctores.reporte');
Route::get('/Doctores/pdf-especialidad', [DoctorController::class, 'reportePorEspecialidad'])->name('doctores.reporte.especialidad');
