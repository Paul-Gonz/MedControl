<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Expediente; 


class ExpedienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $expedientes = Expediente::all();
       return view('expedientes', compact('expedientes'));
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
        $expediente = new Expediente();
        $expediente->diagnostico = $request->diagnostico;
        $expediente->tratamiento = $request->tratamiento;
        $expediente->receta = $request->receta;
        $expediente->observaciones = $request->observaciones;
        $expediente->activo_inactivo = $request->activo_inactivo;
        $expediente->fecha_creacion = now();
        $expediente->fecha_actualizacion = now();
        $expediente->save();
         return redirect()->route('expedientes.index')->with('success', 'Expediente registrado correctamente.');
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
        $expediente = Expediente::findOrFail($request->expediente_id);

        $expediente->diagnostico = $request->diagnostico;
        $expediente->tratamiento = $request->tratamiento;
        $expediente->receta = $request->receta;
        $expediente->observaciones = $request->observaciones;
        $expediente->fecha_actualizacion = now();
        $expediente->activo_inactivo = $request->activo_inactivo;
        $expediente->save();

       return redirect()->route('expedientes.index')->with('success', 'Expediente actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Expediente::destroy($request->expediente_id);
        return redirect()->route('expedientes.index')->with('success', 'Expediente eliminado correctamente.');
    }
}
