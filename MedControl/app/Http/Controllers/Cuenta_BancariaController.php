<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta_Bancaria; 


class Cuenta_BancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $cuentas_bancarias = Cuenta_Bancaria::all();
       return view('cuentas_bancarias', compact('cuentas_bancarias'));
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
        $cuenta_bancaria = new Cuenta_Bancaria();
        $cuenta_bancaria->nombre_titular = $request->nombre_titular;
        $cuenta_bancaria->cedula_titular = $request->cedula_titular;
        $cuenta_bancaria->banco = $request->banco;
        $cuenta_bancaria->numero_telefonico = $request->numero_telefonico;
        $cuenta_bancaria->pago_movil = $request->pago_movil;
        $cuenta_bancaria->activo_inactivo = $request->activo_inactivo;
        $cuenta_bancaria->save();
         return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria registrada correctamente.');
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
        $cuenta_bancaria = Cuenta_Bancaria::findOrFail($request->id_cuenta_bancaria);

        $cuenta_bancaria->nombre_titular = $request->nombre_titular;
        $cuenta_bancaria->cedula_titular = $request->cedula_titular;
        $cuenta_bancaria->banco = $request->banco;
        $cuenta_bancaria->numero_telefonico = $request->numero_telefonico;
        $cuenta_bancaria->pago_movil = $request->pago_movil;
        $cuenta_bancaria->activo_inactivo = $request->activo_inactivo;
        $cuenta_bancaria->save();

       return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Cuenta_Bancaria::destroy($request->id_cuenta_bancaria);
        return redirect()->route('cuentas_bancarias.index')->with('success', 'Cuenta bancaria eliminada correctamente.');
    }
}
