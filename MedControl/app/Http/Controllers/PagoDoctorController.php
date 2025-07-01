<?php

namespace App\Http\Controllers;

use App\Models\PagoDoctor;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PagoDoctorController extends Controller
{
    public function index()
    {
        $pagos = PagoDoctor::with('doctor')->orderBy('fecha_pago', 'desc')->get();
        return view('pagos_doctores', compact('pagos'));
    }

    public function create()
    {
        $doctores = Doctor::all();
        return view('pagos_doctores.create', compact('doctores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doctor_id' => 'required|exists:doctores,id',
            'monto' => 'required|numeric|min:0',
            'fecha_pago' => 'required|date',
            'metodo_pago' => 'nullable|string|max:255',
            'observaciones' => 'nullable|string',
        ]);
        PagoDoctor::create($request->all());
        return redirect()->route('pagos_doctores.index')->with('success', 'Pago registrado correctamente.');
    }
}
