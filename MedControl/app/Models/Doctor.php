<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $table = 'doctores';
    protected $primaryKey = 'doctor_id';
    public $timestamps = false;

    protected $fillable = [
        'cuenta_id',
        'cedula_identidad',
        'cedula_profesional',
        'nombre_completo',
        'honorarios',
        'contacto_telefono',
        'contacto_email',
        'activo_inactivo',
    ];
}