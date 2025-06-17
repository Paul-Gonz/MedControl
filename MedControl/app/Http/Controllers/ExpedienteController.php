<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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
       return $expedientes;
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
        $expediente->diagnostico = $request->input('diagnostico');
        $expediente->tratamiento = $request->input('tratamiento');
        $expediente->receta = $request->input('receta');
        $expediente->observaciones = $request->input('observaciones');
        $expediente->activo_inactivo = $request->input('activo_inactivo', true);
        $expediente->fecha_creacion = now();
        $expediente->fecha_actualizacion = now();
        $expediente->save();

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
    public function update(Request $request, string $id)
    {
        $expediente = Expediente::findOrFail($expediente_id);
        $expediente->diagnostico = $request->input('diagnostico', $expediente->diagnostico);
        $expediente->tratamiento = $request->input('tratamiento', $expediente->tratamiento);
        $expediente->receta = $request->input('receta', $expediente->receta);
        $expediente->observaciones = $request->input('observaciones', $expediente->observaciones);
        $expediente->activo_inactivo = $request->input('activo_inactivo', $expediente->activo_inactivo);
        $expediente->fecha_actualizacion = now();
        $expediente->save();

        return $expediente;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $expediente = Expediente::destroy($request->input('expediente_id'));
        return $expediente;
    }
}
