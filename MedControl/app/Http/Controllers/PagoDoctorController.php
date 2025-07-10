<?php

namespace App\Http\Controllers;

use App\Models\PagoDoctor;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PagoDoctorController extends Controller
{
    public function index()
    {
        $pagos = PagoDoctor::with('doctor')->orderBy('fecha_pago', 'desc')->get();
        $doctores = Doctor::all();
        return view('pagos_doctores', compact('pagos', 'doctores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,doctor_id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);
        PagoDoctor::create($request->all());

        // Buscar cuenta de egresos
        $cuentaEgreso = \App\Models\PlanCuenta::where('tipo', 'egreso')->first();
        if ($cuentaEgreso) {
            \App\Models\MovimientoContable::create([
                'fecha' => $request->fecha_pago,
                'cuenta' => $cuentaEgreso->cuenta_id,
                'descripcion' => 'Egreso por pago a doctor (Doctor ID: ' . $request->doctor_id . ')',
                'debe' => $request->monto,
                'haber' => 0,
                'referencia' => $request->metodo_pago,
            ]);
        }

        return redirect()->route('pagos_doctores.index')->with('success', 'Pago registrado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,doctor_id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);
        $pago = PagoDoctor::findOrFail($id);
        $pago->update($request->all());
        return redirect()->route('pagos_doctores.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = PagoDoctor::findOrFail($id);
        $pago->delete();
        return redirect()->route('pagos_doctores.index')->with('success', 'Pago eliminado correctamente.');
    }
}
