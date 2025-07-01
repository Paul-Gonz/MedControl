<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Factura;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::all();
        $facturas = Factura::with([
            'cita.paciente',
            'cita.doctorPorEspecialidad.doctor',
            'cita.doctorPorEspecialidad.especialidad'
        ])->where('estado_factura', '!=', 'pagada')->get();
        return view('pagos', compact('pagos', 'facturas'))->with('mode', 'index');
    }

    public function create()
    {
        $facturas = Factura::with([
            'cita.paciente',
            'cita.doctorPorEspecialidad.doctor',
            'cita.doctorPorEspecialidad.especialidad'
        ])->where('estado_factura', '!=', 'pagada')->get();
        $mode = 'create';
        return view('pagos', compact('facturas', 'mode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'factura_id' => 'required|exists:facturas,factura_id',
            'metodo_pago' => 'required',
            'monto' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'numero_referencia' => 'required',
            'activo_inactivo' => 'required|boolean',
        ]);
        Pago::create($request->all());
        // Cambiar estado de la factura a 'pagada'
        $factura = \App\Models\Factura::find($request->factura_id);
        if ($factura) {
            $factura->estado_factura = 'pagada';
            $factura->save();
            // Cambiar estado de la cita relacionada a 'completada'
            if ($factura->cita_id) {
                $cita = \App\Models\Cita::find($factura->cita_id);
                if ($cita) {
                    $cita->estado_cita = 'completada';
                    $cita->save();
                }
            }
        }
        return redirect()->route('pagos.index')->with('success', 'Pago registrado correctamente.');
    }

    public function edit($id)
    {
        $pago = Pago::findOrFail($id);
        $facturas = Factura::with([
            'cita.paciente',
            'cita.doctorPorEspecialidad.doctor',
            'cita.doctorPorEspecialidad.especialidad'
        ])->where('estado_factura', '!=', 'pagada')->get();
        $mode = 'edit';
        return view('pagos', compact('pago', 'facturas', 'mode'));
    }

    public function update(Request $request, $id)
    {
        $pago = Pago::findOrFail($id);
        $request->validate([
            'factura_id' => 'required|exists:facturas,factura_id',
            'metodo_pago' => 'required',
            'monto' => 'required|numeric',
            'fecha_pago' => 'required|date',
            'numero_referencia' => 'required',
            'activo_inactivo' => 'required|boolean',
        ]);
        $pago->update($request->all());
        return redirect()->route('pagos.index')->with('success', 'Pago actualizado correctamente.');
    }

    public function destroy($id)
    {
        $pago = Pago::findOrFail($id);
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado correctamente.');
    }
}
