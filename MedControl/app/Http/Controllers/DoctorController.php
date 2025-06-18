<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;

class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::all();
        return view('doctores', compact('doctores'));
    }

    public function store(Request $request)
    {
        // Validar y filtrar solo los campos que existen en la base de datos
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cuenta_id' => 'required|integer',
            'cedula_identidad' => 'required|string|max:255',
            'cedula_profesional' => 'required|string|max:255',
            'honorarios' => 'required|numeric',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'activo_inactivo' => 'required|boolean',

            // Agregar otras validaciones según los campos de la base de datos
        ]);

        Doctor::create($validatedData);
        return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);

        // Validar y filtrar solo los campos que existen en la base de datos
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cuenta_id' => 'required|integer',
            'cedula_identidad' => 'required|string|max:255',
            'cedula_profesional' => 'required|string|max:255',
            'honorarios' => 'required|numeric',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'activo_inactivo' => 'required|boolean',
            // Agregar otras validaciones según los campos de la base de datos
        ]);

        $doctor->update($validatedData);
        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente.');
    }
}