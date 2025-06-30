<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Cuenta_Bancaria;
use App\Models\Especialidad;
use Barryvdh\DomPDF\Facade\Pdf;


class DoctorController extends Controller
{
    public function index()
    {
        $doctores = Doctor::all();
        // Obtener especialidad para cada doctor
        foreach ($doctores as $doctor) {
            $rel = \DB::table('doctor_por_especialidad')->where('doctor_id', $doctor->doctor_id)->first();
            if ($rel) {
                $especialidad = \DB::table('especialidades')->where('especialidad_id', $rel->especialidad_id)->first();
                $doctor->especialidad_id = $especialidad ? $especialidad->especialidad_id : null;
                $doctor->especialidad_nombre = $especialidad ? $especialidad->nombre : 'Sin asignar';
            } else {
                $doctor->especialidad_id = null;
                $doctor->especialidad_nombre = 'Sin asignar';
            }
        }
        $cuentas_bancarias = Cuenta_Bancaria::all();
        $especialidades = Especialidad::all();
        return view('doctores', compact('doctores', 'cuentas_bancarias', 'especialidades'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cuenta_id' => 'required|integer',
            'cedula_identidad' => 'required|string|max:255',
            'cedula_profesional' => 'required|string|max:255',
            'honorarios' => 'required|numeric',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'activo_inactivo' => 'required|boolean',
            'especialidad_id' => 'required|integer',
        ]);

        $doctor = Doctor::create($validatedData);
        // Relacionar doctor con especialidad
        \DB::table('doctor_por_especialidad')->insert([
            'doctor_id' => $doctor->doctor_id,
            'especialidad_id' => $validatedData['especialidad_id']
        ]);
        return redirect()->route('doctores.index')->with('success', 'Doctor creado correctamente.');
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::findOrFail($id);
        $validatedData = $request->validate([
            'nombre_completo' => 'required|string|max:255',
            'cuenta_id' => 'required|integer',
            'cedula_identidad' => 'required|string|max:255',
            'cedula_profesional' => 'required|string|max:255',
            'honorarios' => 'required|numeric',
            'contacto_telefono' => 'nullable|string|max:20',
            'contacto_email' => 'nullable|email|max:255',
            'activo_inactivo' => 'required|boolean',
            'especialidad_id' => 'required|integer',
        ]);
        $doctor->update($validatedData);
        // Actualizar relación doctor-especialidad
        \DB::table('doctor_por_especialidad')->updateOrInsert(
            ['doctor_id' => $doctor->doctor_id],
            ['especialidad_id' => $validatedData['especialidad_id']]
        );
        return redirect()->route('doctores.index')->with('success', 'Doctor actualizado correctamente.');
    }

    public function destroy($id)
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->delete();
        return redirect()->route('doctores.index')->with('success', 'Doctor eliminado correctamente.');
    }
    
    public function reporte()
    {
        $doctores = Doctor::all();
        // Obtener especialidad para cada doctor (igual que en index)
        foreach ($doctores as $doctor) {
            $rel = \DB::table('doctor_por_especialidad')->where('doctor_id', $doctor->doctor_id)->first();
            if ($rel) {
                $especialidad = \DB::table('especialidades')->where('especialidad_id', $rel->especialidad_id)->first();
                $doctor->especialidad_id = $especialidad ? $especialidad->especialidad_id : null;
                $doctor->especialidad_nombre = $especialidad ? $especialidad->nombre : 'Sin asignar';
            } else {
                $doctor->especialidad_id = null;
                $doctor->especialidad_nombre = 'Sin asignar';
            }
        }
        $pdf = Pdf::loadView('doctoresPDF', compact('doctores'));
        return $pdf->stream('reporteDoctores.pdf');
    }
}