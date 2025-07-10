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
        'activo_inactivo',
        'costo',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'paciente_id');
    }

    public function facturas()
    {
        return $this->hasMany(\App\Models\Factura::class, 'cita_id', 'cita_id');
    }

    public function doctorEspecialista()
    {
        return $this->belongsTo(\App\Models\Doctor::class, 'doctor_especialista_id', 'doctor_id');
    }
    
    public function doctorPorEspecialidad()
    {
        return $this->belongsTo(\App\Models\DoctorPorEspecialidad::class, 'doctor_especialista_id', 'relacion_id');
    }
}