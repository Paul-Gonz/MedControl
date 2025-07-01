<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use Barryvdh\DomPDF\Facade\Pdf;

class PacientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Paciente::query();

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('cedula_identidad', 'like', "%$buscar%")
                    ->orWhere('nombre_completo', 'like', "%$buscar%")
                    ->orWhere('fecha_nacimiento', 'like', "%$buscar%")
                    ->orWhere('contacto_telefono', 'like', "%$buscar%")
                    ->orWhere('contacto_email', 'like', "%$buscar%")
                    ->orWhere('datos_relevantes', 'like', "%$buscar%")
                    ->orWhere('fecha_registro', 'like', "%$buscar%")
                    ->orWhere('activo_inactivo', 'like', "%$buscar%");
            });
        }

        $pacientes = $query->get();
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
        $request->validate([
            'cedula_identidad'   => 'required|string|max:50',
            'nombre_completo'    => 'required|string|max:255',
            'fecha_nacimiento'   => 'required|date',
            'contacto_telefono'  => 'nullable|string|max:50',
            'contacto_email'     => 'nullable|email|max:255',
            'datos_relevantes'   => 'nullable|string',
            'fecha_registro'     => 'required|date',
            'activo_inactivo'    => 'required|boolean',
        ]);

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
        $request->validate([
            'paciente_id'        => 'required|exists:pacientes,paciente_id',
            'cedula_identidad'   => 'required|string|max:50',
            'nombre_completo'    => 'required|string|max:255',
            'fecha_nacimiento'   => 'required|date',
            'contacto_telefono'  => 'nullable|string|max:50',
            'contacto_email'     => 'nullable|email|max:255',
            'datos_relevantes'   => 'nullable|string',
            'fecha_registro'     => 'required|date',
            'activo_inactivo'    => 'required|boolean',
        ]);

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
        $paciente = Paciente::findOrFail($request->paciente_id);
        $paciente->activo_inactivo = 0;
        $paciente->save();

        return redirect()->route('pacientes.index')->with('success', 'Paciente eliminado correctamente.');
    }

    public function reingresar(Request $request)
{
    $paciente = Paciente::findOrFail($request->paciente_id);
    $paciente->activo_inactivo = 1;
    $paciente->save();

    return redirect()->route('pacientes.index')->with('success', 'Paciente reingresado correctamente.');
}

    public function reporte(Request $request)
    {
        $query = Paciente::query();

        // Filtro por rango de fechas de nacimiento
        if ($request->filled('fecha_nacimiento_desde') && $request->filled('fecha_nacimiento_hasta')) {
            $query->whereBetween('fecha_nacimiento', [
                $request->fecha_nacimiento_desde,
                $request->fecha_nacimiento_hasta
            ]);
        } elseif ($request->filled('fecha_nacimiento_desde')) {
            $query->where('fecha_nacimiento', '>=', $request->fecha_nacimiento_desde);
        } elseif ($request->filled('fecha_nacimiento_hasta')) {
            $query->where('fecha_nacimiento', '<=', $request->fecha_nacimiento_hasta);
        }

        $pacientes = $query->get();

        $pdf = PDF::loadView('pacientesPDF', compact('pacientes'));
        return $pdf->stream('reportePacientes.pdf');
    }
}
