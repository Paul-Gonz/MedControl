<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $table = 'pacientes';
    protected $primaryKey = 'paciente_id';
    public $timestamps = false;

    protected $fillable = [
        'cedula_identidad',
        'nombre_completo',
        'fecha_nacimiento',
        'contacto_telefono',
        'contacto_email',
        'datos_relevantes',
        'fecha_registro',
        'activo_inactivo',
    ];
}
