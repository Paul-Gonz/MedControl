<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = 'usuarios';
    protected $primaryKey = 'usuario_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'usuario',
        'clave',
        'nombre_asignado',
        'cedula_asignado',
        'admin',
        'activo_inactivo'
    ];

    protected $casts = [
        'admin' => 'boolean',
        'activo_inactivo' => 'boolean',
    ];
}