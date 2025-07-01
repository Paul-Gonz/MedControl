<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorPorEspecialidad extends Model
{
    protected $table = 'doctor_por_especialidad';
    protected $primaryKey = 'relacion_id';
    public $timestamps = false;

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidad::class, 'especialidad_id', 'especialidad_id');
    }
}
