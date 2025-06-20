<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('pago_id');
            $table->unsignedBigInteger('factura_id');
            $table->enum('metodo_pago', ['efectivo','tarjeta','transferencia','cheque','otro']);
            $table->decimal('monto', 10, 2);
            $table->dateTime('fecha_pago')->useCurrent();
            $table->text('numero_referencia');
            $table->tinyInteger('activo_inactivo')->default(1);

            $table->foreign('factura_id')->references('factura_id')->on('facturas');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos');
    }
};