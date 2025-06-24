<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoConsultorio extends Model
{
    protected $table = 'tipo_consultorio';
    protected $primaryKey = 'tipo_consultorio_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre_consultorio',
        'descripcion',
        'equipamiento',
        'activo_inactivo',
    ];
}
