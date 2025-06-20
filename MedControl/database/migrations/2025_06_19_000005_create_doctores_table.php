<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctores', function (Blueprint $table) {
            $table->id('doctor_id');
            $table->unsignedBigInteger('cuenta_id');
            $table->string('cedula_identidad', 10);
            $table->string('cedula_profesional', 20);
            $table->string('nombre_completo', 100);
            $table->decimal('honorarios', 10, 2)->nullable();
            $table->string('contacto_telefono', 20);
            $table->string('contacto_email', 150);
            $table->tinyInteger('activo_inactivo')->default(1);

            $table->foreign('cuenta_id')->references('id_cuenta_bancaria')->on('cuentas_bancarias')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctores');
    }
};