<?php
	namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PagoDoctor extends Model
{
    use HasFactory;

    protected $table = 'pagos_doctores';

    protected $fillable = [
        'doctor_id',
        'monto',
        'fecha_pago',
        'metodo_pago',
        'observaciones',
    ];

    public function doctor()
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }
}
