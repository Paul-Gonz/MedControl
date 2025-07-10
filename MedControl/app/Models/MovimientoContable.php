<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovimientoContable extends Model
{
    protected $table = 'movimientos_contables';

    protected $fillable = [
        'fecha', 'cuenta', 'descripcion', 'debe', 'haber', 'referencia'
    ];

    public function cuentaContable()
    {
        return $this->belongsTo(PlanCuenta::class, 'cuenta', 'cuenta_id');
    }
}