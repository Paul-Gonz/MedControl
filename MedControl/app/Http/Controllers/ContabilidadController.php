<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\PagoDoctor;
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

        $pagos = Pago::whereBetween('fecha_pago', [$desde, $hasta])->get();
        $pagos_doctores = PagoDoctor::whereBetween('fecha_pago', [$desde, $hasta])->get();

        return view('contabilidad.libro_diario', compact('pagos', 'pagos_doctores', 'desde', 'hasta'));
    }

    public function libroMayor(Request $request)
    {
        $mes = $request->input('mes'); // formato: YYYY-MM
        $inicio = Carbon::parse($mes . '-01')->startOfMonth();
        $fin = Carbon::parse($mes . '-01')->endOfMonth();

        $pagos = Pago::whereBetween('fecha_pago', [$inicio, $fin])->get();
        $pagos_doctores = PagoDoctor::whereBetween('fecha_pago', [$inicio, $fin])->get();

        return view('contabilidad.libro_mayor', compact('pagos', 'pagos_doctores', 'mes'));
    }
}