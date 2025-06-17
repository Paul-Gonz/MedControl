<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pacientes = Paciente::all();
        return view('pacientes', compact('pacientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $paciente = new Paciente();
        $paciente->cedula_identidad = $request->cedula_identidad;
        $paciente->nombre_completo = $request->nombre_completo;
        $paciente->fecha_nacimiento = $request->fecha_nacimiento;
        $paciente->contacto_telefono = $request->contacto_telefono;
        $paciente->contacto_email = $request->contacto_email;
        $paciente->datos_relevantes = $request->datos_relevantes;
        $paciente->fecha_registro = $request->fecha_registro;
        $paciente->activo_inactivo = $request->activo_inactivo;

        $paciente->save();


        return redirect()->route('pacientes.index')->with('success', 'Paciente creado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $paciente = Paciente::findOrFail($request->paciente_id);

        $paciente->cedula_identidad = $request->cedula_identidad;
        $paciente->nombre_completo = $request->nombre_completo;
        $paciente->fecha_nacimiento = $request->fecha_nacimiento;
        $paciente->contacto_telefono = $request->contacto_telefono;
        $paciente->contacto_email = $request->contacto_email;
        $paciente->datos_relevantes = $request->datos_relevantes;
        $paciente->fecha_registro = $request->fecha_registro;
        $paciente->activo_inactivo = $request->activo_inactivo;

        $paciente->save();

        return redirect()->route('pacientes.index')->with('success', 'Paciente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Paciente::destroy($request->paciente_id);

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }
}
