<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id('paciente_id');
            $table->string('cedula_identidad', 10);
            $table->string('nombre_completo', 100);
            $table->date('fecha_nacimiento');
            $table->string('contacto_telefono', 20)->nullable();
            $table->string('contacto_email', 150)->nullable();
            $table->text('datos_relevantes')->nullable();
            $table->dateTime('fecha_registro')->useCurrent();
            $table->tinyInteger('activo_inactivo')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('pacientes');
    }
};