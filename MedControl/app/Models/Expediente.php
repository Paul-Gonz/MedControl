<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{

    protected $table = 'expedientes_clinicos';

    protected $fillable = [
        'diagnostico',
        'tratamiento',
        'receta',
        'observaciones',
        'activo_inactivo',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    public $timestamps = false;

    protected $primaryKey = 'expediente_id';
}
