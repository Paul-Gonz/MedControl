<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita; 
class AgendaController extends Controller
{
    public function index()
    {
        return view('agenda');
    }

    public function citas()
    {
        $citas = Cita::all()->map(function ($cita) {
            return [
                'title' => $cita->paciente_nombre ?? 'Cita',
                'start' => $cita->fecha . 'T' . $cita->hora,
                'end'   => $cita->fecha . 'T' . ($cita->hora_fin ?? $cita->hora),
                'id'    => $cita->id,
            ];
                
        });
        return response()->json($citas);
    }
}