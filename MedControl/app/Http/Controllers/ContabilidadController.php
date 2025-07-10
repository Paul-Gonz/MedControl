<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\PagoDoctor;
use App\Models\MovimientoContable;
use App\Models\PlanCuenta;
use Carbon\Carbon;

class ContabilidadController extends Controller
{
    public function index()
    {
        return view('contabilidad');
    }

    public function libroDiario(Request $request)
    {
        $desde = $request->input('desde');
        $hasta = $request->input('hasta');
        $movimientos = MovimientoContable::with('cuentaContable')
            ->whereBetween('fecha', [$desde, $hasta])
            ->orderBy('fecha')
            ->get();
        return view('libro_diario', compact('movimientos', 'desde', 'hasta'));
    }

    public function libroMayor(Request $request)
    {
        $mes = $request->input('mes');
        $cuenta = $request->input('cuenta');
        $inicio = Carbon::parse($mes . '-01')->startOfMonth();
        $fin = Carbon::parse($mes . '-01')->endOfMonth();

        $movimientos = MovimientoContable::with('cuentaContable')
            ->where('cuenta', $cuenta)
            ->whereBetween('fecha', [$inicio, $fin])
            ->orderBy('fecha')
            ->get();
        $cuentaObj = PlanCuenta::find($cuenta);
        $cuentaNombre = $cuentaObj ? $cuentaObj->nombre : $cuenta;
        return view('libro_mayor', compact('movimientos', 'cuenta', 'cuentaNombre', 'mes'));
    }
}