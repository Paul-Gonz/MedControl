<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultorio;
use App\Models\TipoConsultorio;

class ConsultorioController extends Controller
{
    public function index()
    {
        $consultorios = Consultorio::with('tipoConsultorio')->get();
        $tiposConsultorio = TipoConsultorio::all();
        return view('consultorios', compact('consultorios', 'tiposConsultorio'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_consultorio' => 'required|string|max:50',
            'tipo_id' => 'required|exists:tipo_consultorio,tipo_consultorio_id',
            'ubicacion' => 'required|string|max:255',
            'estado_consultorio' => 'required|in:disponible,en_mantenimiento,no_disponible',
            'activo_inactivo' => 'required|boolean',
        ]);

        Consultorio::create($validatedData);
        return redirect()->route('consultorios.index')->with('success', 'Consultorio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $consultorio = Consultorio::findOrFail($id);

        $validatedData = $request->validate([
            'nombre_consultorio' => 'required|string|max:50',
            'tipo_id' => 'required|exists:tipo_consultorio,tipo_consultorio_id',
            'ubicacion' => 'required|string|max:255',
            'estado_consultorio' => 'required|in:disponible,en_mantenimiento,no_disponible',
            'activo_inactivo' => 'required|boolean',
        ]);

        $consultorio->update($validatedData);
        return redirect()->route('consultorios.index')->with('success', 'Consultorio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $consultorio = Consultorio::findOrFail($id);
        $consultorio->delete();
        return redirect()->route('consultorios.index')->with('success', 'Consultorio eliminado correctamente.');
    }
}