<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    protected $table = 'consultorios';
    protected $primaryKey = 'consultorio_id';
    public $timestamps = false;

    protected $fillable = [
        'nombre_consultorio',
        'tipo_id',
        'ubicacion',
        'estado_consultorio',
        'activo_inactivo',
    ];

    public function tipoConsultorio()
    {
        return $this->belongsTo(TipoConsultorio::class, 'tipo_id', 'tipo_consultorio_id');
    }
}