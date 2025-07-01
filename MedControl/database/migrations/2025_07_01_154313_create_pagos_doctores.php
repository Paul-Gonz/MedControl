<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pagos_doctores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->decimal('monto', 10, 2);
            $table->date('fecha_pago');
            $table->string('metodo_pago', 50)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();

            $table->foreign('doctor_id')->references('doctor_id')->on('doctores')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos_doctores');
    }
};