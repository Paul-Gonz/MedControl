<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id('factura_id');
            $table->unsignedBigInteger('cita_id');
            $table->dateTime('fecha_emision')->useCurrent();
            $table->decimal('subtotal', 10, 2);
            $table->decimal('iva', 10, 2);
            $table->decimal('total', 10, 2)->storedAs('subtotal + iva');
            $table->enum('estado_factura', ['pendiente','pago_parcial','pagada','cancelada'])->default('pendiente');
            $table->tinyInteger('activo_inactivo')->default(1);

            $table->foreign('cita_id')->references('cita_id')->on('citas')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('facturas');
    }
};