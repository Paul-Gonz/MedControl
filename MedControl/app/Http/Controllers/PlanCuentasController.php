<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PlanCuenta;

class PlanCuentasController extends Controller
{
    public function index()
    {
        $cuentas = PlanCuenta::all();
        return view('plan_cuentas', compact('cuentas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:plan_cuentas,codigo',
            'nombre' => 'required|string',
            'tipo' => 'required|string',
        ]);
        PlanCuenta::create($request->only('codigo', 'nombre', 'tipo'));
        return redirect()->route('plan-cuentas.index')->with('success', 'Cuenta registrada correctamente.');
    }

    public function edit($id)
    {
        $cuenta = PlanCuenta::findOrFail($id);
        $cuentas = PlanCuenta::all();
        return view('plan_cuentas_edit', compact('cuenta', 'cuentas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'codigo' => 'required|string|unique:plan_cuentas,codigo,' . $id . ',cuenta_id',
            'nombre' => 'required|string',
            'tipo' => 'required|string',
        ]);
        $cuenta = PlanCuenta::findOrFail($id);
        $cuenta->update($request->only('codigo', 'nombre', 'tipo'));
        return redirect()->route('plan-cuentas.index')->with('success', 'Cuenta actualizada correctamente.');
    }

    public function destroy($id)
    {
        $cuenta = PlanCuenta::findOrFail($id);
        $cuenta->delete();
        return redirect()->route('plan-cuentas.index')->with('success', 'Cuenta eliminada correctamente.');
    }
}
