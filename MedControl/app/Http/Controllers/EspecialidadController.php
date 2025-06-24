<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    
    public function index()
    {
        $especialidades = Especialidad::all();
        return view('especialidades', compact('especialidades'));
    }

    
    public function create()
    {
        //
    }

    
    public function store(Request $request)
    {
        $especialidad = new Especialidad();
        $especialidad->nombre = $request->nombre;
        $especialidad->descripcion = $request->descripcion;
        $especialidad->activo_inactivo = $request->activo_inactivo;

        $especialidad->save();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad creada correctamente.');
    }

   
    public function show(string $id)
    {
        //
    }

    
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request)
    {
        $especialidad = Especialidad::findOrFail($request->especialidad_id);

        $especialidad->nombre = $request->nombre;
        $especialidad->descripcion = $request->descripcion;
        $especialidad->activo_inactivo = $request->activo_inactivo;

        $especialidad->save();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad actualizada correctamente.');
    }

    
    public function destroy(Request $request)
    {
        Especialidad::destroy($request->especialidad_id);

        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada correctamente.');
    }
}
