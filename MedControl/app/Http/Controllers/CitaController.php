<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Doctor;
use App\Models\Consultorio;
use App\Models\Expediente;

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
    return view('citas', [
        'mode' => 'create',
        'pacientes' => Paciente::all(),
        'doctores' => Doctor::all(),
        'consultorios' => Consultorio::all(),
        'expedientes' => Expediente::all()
    ]);
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
    return view('citas', [
        'mode' => 'edit',
        'cita' => $cita,
        'pacientes' => Paciente::all(),
        'doctores' => Doctor::all(),
        'consultorios' => Consultorio::all(),
        'expedientes' => Expediente::all()
    ]);
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