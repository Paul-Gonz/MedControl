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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PagoDoctorController;
use App\Http\Controllers\ContabilidadController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\PlanCuentasController;
use App\Http\Controllers\MovimientoContableController;

Route::get('/', function () {
    return view('login');
});
 
Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/dashboard/citas-por-mes', [DashboardController::class, 'citasPorMes'])->name('dashboard.citasPorMes');
Route::get('/dashboard/especialidades-mas-demandadas', [DashboardController::class, 'especialidadesMasDemandadas'])->name('dashboard.especialidadesMasDemandadas');
// Gráfica de ingresos y egresos mensuales
Route::get('/dashboard/ingresos-egresos', [DashboardController::class, 'ingresosEgresosPorMes'])->name('dashboard.ingresosEgresos');
// Horas de uso de consultorios
Route::get('/dashboard/horas-uso-consultorios', [App\Http\Controllers\DashboardController::class, 'horasUsoConsultorios'])->name('dashboard.horasUsoConsultorios');
// Cantidad de citas por día de la semana actual
Route::get('/dashboard/citas-por-dia-semana', [App\Http\Controllers\DashboardController::class, 'citasPorDiaSemana'])->name('dashboard.citasPorDiaSemana');
// Top 10 doctores con más consultas pagadas este mes
Route::get('/dashboard/top-doctores-pagadas', [App\Http\Controllers\DashboardController::class, 'topDoctoresPagadasMes'])->name('dashboard.topDoctoresPagadasMes');

//pacientes
Route::get('/Pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
Route::post('/Pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
Route::post('/Pacientes/update', [PacientesController::class, 'update'])->name('pacientes.update');
Route::post('/Pacientes/destroy', [PacientesController::class, 'destroy'])->name('pacientes.destroy');
Route::post('/Pacientes/reingresar', [PacientesController::class, 'reingresar'])->name('pacientes.reingresar');

//reporte de pacientes
Route::get('/Pacientes/pdf', [PacientesController::class, 'reporte'])->name('pacientes.reporte');

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
Route::put('/Usuarios/update/{usuario_id}', [UsuarioController::class, 'update'])->name('usuarios.update');
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
Route::post('consultorios/{id}/reingresar', [ConsultorioController::class, 'reingresar'])->name('consultorios.reingresar');

Route::get('/TiposConsultorio', [App\Http\Controllers\TipoConsultorioController::class, 'index'])->name('tipos-consultorio.index');
Route::post('/TiposConsultorio', [App\Http\Controllers\TipoConsultorioController::class, 'store'])->name('tipos-consultorio.store');
Route::post('/TiposConsultorio/update/{id}', [App\Http\Controllers\TipoConsultorioController::class, 'update'])->name('tipos-consultorio.update');
Route::post('/TiposConsultorio/destroy/{id}', [App\Http\Controllers\TipoConsultorioController::class, 'destroy'])->name('tipos-consultorio.destroy');
Route::post('tipos-consultorio/{id}/reingresar', [TipoConsultorioController::class, 'reingresar'])->name('tipos-consultorio.reingresar');

Route::resource('citas', CitaController::class);
Route::patch('/citas/{id}/completar', [CitaController::class, 'completar'])->name('citas.completar');

Route::resource('pagos', App\Http\Controllers\PagoController::class);

Route::get('/Doctores/pdf', [DoctorController::class, 'reporte'])->name('doctores.reporte');
Route::get('/Doctores/pdf-especialidad', [DoctorController::class, 'reportePorEspecialidad'])->name('doctores.reporte.especialidad');

Route::get('citas/reporte/pdf', [CitaController::class, 'reportePdf'])->name('citas.reporte.pdf');

Route::get('/pagos-doctores', [PagoDoctorController::class, 'index'])->name('pagos_doctores.index');
Route::post('/pagos-doctores', [PagoDoctorController::class, 'store'])->name('pagos_doctores.store');
Route::put('/pagos-doctores/update/{id}', [PagoDoctorController::class, 'update'])->name('pagos_doctores.update');
Route::delete('/pagos-doctores/destroy/{id}', [PagoDoctorController::class, 'destroy'])->name('pagos_doctores.destroy');

Route::get('/citas/reporte', [App\Http\Controllers\CitaController::class, 'reporte'])->name('citas.reporte');

Route::prefix('/Contabilidad')->group(function () {
    Route::get('/', [ContabilidadController::class, 'index'])->name('contabilidad.index');
    Route::post('/contabilidad/libro_diario', [ContabilidadController::class, 'libroDiario'])->name('contabilidad.libro_diario');
Route::post('/contabilidad/libro_mayor', [ContabilidadController::class, 'libroMayor'])->name('contabilidad.libro_mayor');
    });

Route::get('/agenda', [AgendaController::class, 'index'])->name('agenda.index');
Route::get('/agenda/citas', [AgendaController::class, 'citas'])->name('agenda.citas');

Route::get('plan-cuentas', [PlanCuentasController::class, 'index'])->name('plan-cuentas.index');
Route::post('plan-cuentas', [PlanCuentasController::class, 'store'])->name('plan-cuentas.store');
Route::get('plan-cuentas/{id}/edit', [PlanCuentasController::class, 'edit'])->name('plan-cuentas.edit');
Route::put('plan-cuentas/{id}', [PlanCuentasController::class, 'update'])->name('plan-cuentas.update');
Route::delete('plan-cuentas/{id}', [PlanCuentasController::class, 'destroy'])->name('plan-cuentas.destroy');

Route::get('movimientos/create', [MovimientoContableController::class, 'create'])->name('movimientos.create');
Route::post('movimientos', [MovimientoContableController::class, 'store'])->name('movimientos.store');