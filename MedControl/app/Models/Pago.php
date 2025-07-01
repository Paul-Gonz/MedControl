<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'pago_id';
    public $timestamps = false;

    protected $fillable = [
        'factura_id',
        'metodo_pago',
        'monto',
        'fecha_pago',
        'numero_referencia',
        'activo_inactivo',
    ];

    public function factura()
    {
        return $this->belongsTo(Factura::class, 'factura_id', 'factura_id');
    }
}
