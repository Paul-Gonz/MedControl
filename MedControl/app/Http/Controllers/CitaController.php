<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\Consultorio;
use App\Models\Expediente;
use Illuminate\Support\Facades\DB;

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
            'estado_cita' => 'required'
        ]);
        Cita::create($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita creada correctamente');
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
            'estado_cita' => 'required'
        ]);
        $cita->update($request->all());
        return redirect()->route('citas.index')->with('success', 'Cita actualizada correctamente');
    }

    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();
        return redirect()->route('citas.index')->with('success', 'Cita eliminada correctamente');
    }
}