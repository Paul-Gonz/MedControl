<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanCuenta extends Model
{
    protected $table = 'plan_cuentas';
    protected $primaryKey = 'cuenta_id';
    public $timestamps = false;

    protected $fillable = [
        'codigo', 'nombre', 'tipo'
    ];
}
