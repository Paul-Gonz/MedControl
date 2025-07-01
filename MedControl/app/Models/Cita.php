<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $table = 'citas';
    protected $primaryKey = 'cita_id';
    public $timestamps = false;

    protected $fillable = [
        'paciente_id',
        'doctor_especialista_id',
        'consultorio_id',
        'expediente_id',
        'motivo',
        'fecha_hora_inicio',
        'fecha_hora_fin',
        'estado_cita',
        'activo_inactivo'
    ];

    // Relación opcional con paciente (ajusta si tienes el modelo Paciente)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'paciente_id');
    }
}