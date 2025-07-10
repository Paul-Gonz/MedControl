<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoContable;
use App\Models\PlanCuenta;

class MovimientoContableController extends Controller
{
    public function create()
    {
        $cuentas = PlanCuenta::all();
        return view('movimientos', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cuenta' => 'required|integer',
            'descripcion' => 'required|string',
            'debe' => 'nullable|numeric|min:0',
            'haber' => 'nullable|numeric|min:0',
            'referencia' => 'nullable|string',
        ]);

        MovimientoContable::create([
            'fecha' => $request->fecha,
            'cuenta' => $request->cuenta,
            'descripcion' => $request->descripcion,
            'debe' => $request->debe ?? 0,
            'haber' => $request->haber ?? 0,
            'referencia' => $request->referencia ?? '',
        ]);

        return redirect()->back()->with('success', 'Movimiento registrado correctamente.');
    }
}
