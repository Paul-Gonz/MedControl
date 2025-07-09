<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MovimientoContable;

class GastoController extends Controller
{
    public function create()
    {
        // Lista de cuentas posibles para gastos (puedes ampliar)
        $cuentas = [
            'Insumos Médicos',
            'Materiales',
            'Servicios',
            'Papelería',
            'Otros Gastos',
        ];
        return view('Gasto', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'cuenta' => 'required|string',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0.01',
            'referencia' => 'nullable|string',
        ]);

         // Asiento contable por compra de insumos/materiales
    MovimientoContable::create([
        'fecha' => now(),
        'cuenta' => 'Insumos Médicos', // o 'Materiales'
        'descripcion' => 'Compra de insumos/materiales',
        'debe' => $request->monto,
        'haber' => 0,
        'referencia' => $request->referencia ?? '',
    ]);
    MovimientoContable::create([
        'fecha' => now(),
        'cuenta' => 'Bancos',
        'descripcion' => 'Pago de compra de insumos/materiales',
        'debe' => 0,
        'haber' => $request->monto,
        'referencia' => $request->referencia ?? '',
    ]);

        return redirect()->route('Gasto')->with('success', 'Gasto registrado correctamente.');
    }
}