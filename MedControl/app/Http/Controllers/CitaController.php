<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\Consultorio;
use App\Models\Expediente;
use App\Models\Factura;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CitaController extends Controller
{
    public function index()
    {
        $citas = Cita::with('paciente')->get();
        return view('citas', [
            'mode' => 'index',
            'citas' => $citas
        ]);
    }

    public function create()
    {
        $doctores = DB::table('doctor_por_especialidad as dpe')
            ->join('doctores as d', 'd.doctor_id', '=', 'dpe.doctor_id')
            ->join('especialidades as e', 'e.especialidad_id', '=', 'dpe.especialidad_id')
            ->select(
                'dpe.relacion_id',
                'd.doctor_id',
                'd.nombre_completo',
                'e.nombre as especialidad_nombre'
            )
            ->get();

        $pacientes = Paciente::all();
        $consultorios = Consultorio::with('tipoConsultorio')->get();
        $expedientes = Expediente::all();
        $mode = 'create';
        return view('citas', compact('doctores', 'pacientes', 'consultorios', 'expedientes', 'mode'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'doctor_especialista_id' => 'required',
            'consultorio_id' => 'required',
            'expediente_id' => 'required',
            'motivo' => 'required',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date',
            'estado_cita' => 'required',
            'costo' => 'required|numeric|min:0',
        ]);
        $cita = Cita::create($request->except('costo'));
        // Crear la factura automáticamente
        $subtotal = $request->input('costo');
        $iva = round($subtotal * 0.16, 2); // 16% IVA
        $factura = Factura::create([
            'cita_id' => $cita->cita_id,
            'fecha_emision' => now(),
            'subtotal' => $subtotal,
            'iva' => $iva,
            'estado_factura' => 'pendiente',
            'activo_inactivo' => 1,
        ]);
        return redirect()->route('citas.index')->with('success', 'Cita y factura creadas correctamente');
    }

    public function reportePdf(Request $request)
{
    $tipo = $request->input('tipo', 'especialidad');

    if ($tipo == 'doctor') {
        // Reporte por doctor
        $reporte = \DB::table('citas')
            ->join('doctor_por_especialidad', 'citas.doctor_especialista_id', '=', 'doctor_por_especialidad.relacion_id')
            ->join('doctores', 'doctor_por_especialidad.doctor_id', '=', 'doctores.doctor_id')
            ->select('doctores.nombre_completo as nombre', \DB::raw('COUNT(*) as total_citas'))
            ->groupBy('doctores.nombre_completo')
            ->get();
        $titulo = "Citas por Doctor";
        $columna = "Doctor";
    } else {
        // Reporte por especialidad
        $reporte = \DB::table('citas')
            ->join('doctor_por_especialidad', 'citas.doctor_especialista_id', '=', 'doctor_por_especialidad.relacion_id')
            ->join('especialidades', 'doctor_por_especialidad.especialidad_id', '=', 'especialidades.especialidad_id')
            ->select('especialidades.nombre as nombre', \DB::raw('COUNT(*) as total_citas'))
            ->groupBy('especialidades.nombre')
            ->get();
        $titulo = "Citas por Especialidad";
        $columna = "Especialidad";
    }

    $pdf = \PDF::loadView('citasreporte_pdf', compact('reporte', 'titulo', 'columna', 'tipo'));
    return $pdf->stream('reporte_citas.pdf');
    }



    public function edit($id)
    {
        $cita = Cita::findOrFail($id);
        $doctores = DB::table('doctor_por_especialidad as dpe')
            ->join('doctores as d', 'd.doctor_id', '=', 'dpe.doctor_id')
            ->join('especialidades as e', 'e.especialidad_id', '=', 'dpe.especialidad_id')
            ->select(
                'dpe.relacion_id',
                'd.doctor_id',
                'd.nombre_completo',
                'e.nombre as especialidad_nombre'
            )
            ->get();
        $pacientes = Paciente::all();
        $consultorios = Consultorio::with('tipoConsultorio')->get();
        $expedientes = Expediente::all();
        $mode = 'edit';
        return view('citas', compact('cita', 'doctores', 'pacientes', 'consultorios', 'expedientes', 'mode'));
    }

    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);
        $request->validate([
            'paciente_id' => 'required',
            'doctor_especialista_id' => 'required',
            'consultorio_id' => 'required',
            'expediente_id' => 'required',
            'motivo' => 'required',
            'fecha_hora_inicio' => 'required|date',
            'fecha_hora_fin' => 'required|date',
            'estado_cita' => 'required',
            'costo' => 'required|numeric|min:0',
        ]);
        // Actualizar la cita (sin el campo costo)
        $cita->update($request->except('costo'));
        // Actualizar la factura relacionada (solo la primera si hay varias)
        $factura = $cita->facturas()->first();
        if ($factura) {
            $factura->subtotal = $request->input('costo');
            $factura->iva = round($factura->subtotal * 0.16, 2); // 16% IVA
            $factura->save();
        }
        return redirect()->route('citas.index')->with('success', 'Cita y factura actualizadas correctamente');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
    }

    
}