<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoContable;
use App\Models\PlanCuenta;

class GastoController extends Controller
{
    public function create()
    {
        // Obtener todas las cuentas de tipo gasto
        $cuentas = PlanCuenta::where('tipo', 'gasto')->get();
        return view('Gasto', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cuenta' => 'required|integer',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0.01',
            'referencia' => 'nullable|string',
        ]);

        MovimientoContable::create([
            'fecha' => $request->fecha,
            'cuenta' => $request->cuenta, // ahora es el ID
            'descripcion' => $request->descripcion,
            'debe' => $request->monto,
            'haber' => 0,
            'referencia' => $request->referencia ?? '',
        ]);

        return redirect()->back()->with('success', 'Gasto registrado correctamente.');
    }
}