<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    protected $table = 'facturas';
    protected $primaryKey = 'factura_id';
    public $timestamps = false;

    protected $fillable = [
        'cita_id',
        'fecha_emision',
        'subtotal',
        'iva',
        'total',
        'estado_factura',
        'activo_inactivo',
    ];

    // Relación con el modelo Cita
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'cita_id', 'cita_id');
    }

    // Puedes agregar relaciones y métodos según sea necesario
}
