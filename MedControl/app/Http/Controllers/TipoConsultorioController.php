<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoConsultorio;

class TipoConsultorioController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_consultorio' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'equipamiento' => 'nullable|string',
            'activo_inactivo' => 'required|boolean',
        ]);

        TipoConsultorio::create($validated);

        return redirect()->back()->with('success', 'Tipo de consultorio creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoConsultorio::findOrFail($id);

        $validated = $request->validate([
            'nombre_consultorio' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'equipamiento' => 'nullable|string',
            'activo_inactivo' => 'required|boolean',
        ]);

        $tipo->update($validated);

        return redirect()->back()->with('success', 'Tipo de consultorio actualizado correctamente.');
    }

    public function destroy($id)
    {
        $tipo = TipoConsultorio::findOrFail($id);
        $tipo->delete();

        return redirect()->back()->with('success', 'Tipo de consultorio eliminado correctamente.');
    }
}
