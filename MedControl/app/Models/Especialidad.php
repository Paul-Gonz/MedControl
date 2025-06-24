<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    
    protected $table = 'especialidades';
    protected $primaryKey = 'especialidad_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'activo_inactivo'
    ];
}
