<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use Illuminate\Http\Request;

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
            'mode' => 'create'
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
            'cita' => $cita
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