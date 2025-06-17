<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    use HasFactory;

    protected $table = 'expediente';

    protected $fillable = [
        'diagnostico',
        'tratamiento',
        'receta',
        'observaciones',
        'activo_inactivo',
        'fecha_creacion',
        'fecha_actualizacion'
    ];

    public $timestamps = true;

    protected $primaryKey = 'expediente_id';
}
