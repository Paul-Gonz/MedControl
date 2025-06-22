<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta_Bancaria extends Model
{
    protected $table = 'cuentas_bancarias';
    protected $primaryKey = 'id_cuenta_bancaria';
    public $timestamps = false;

    protected $fillable = [
        'nombre_titular',
        'cedula_titular',
        'banco',
        'numero_telefonico',
        'pago_movil',
        'activo_inactivo',
    ];
}