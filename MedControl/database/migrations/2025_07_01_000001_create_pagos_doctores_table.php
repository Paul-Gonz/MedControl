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
            $table->unsignedBigInteger('doctor_id'); // Solo el ID, sin foreign key
            $table->decimal('monto', 10, 2);
            $table->dateTime('fecha_pago');
            $table->string('metodo_pago', 50);
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pagos_doctores');
    }
};
