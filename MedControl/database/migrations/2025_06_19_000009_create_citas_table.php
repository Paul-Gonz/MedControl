<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id('cita_id');
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('doctor_especialista_id');
            $table->unsignedBigInteger('consultorio_id');
            $table->unsignedBigInteger('expediente_id');
            $table->text('motivo');
            $table->dateTime('fecha_hora_inicio');
            $table->dateTime('fecha_hora_fin');
            $table->enum('estado_cita', ['programada','completada','cancelada','aplazada'])->default('programada');
            $table->tinyInteger('activo_inactivo')->default(1);

            $table->foreign('paciente_id')->references('paciente_id')->on('pacientes')->onUpdate('cascade');
            $table->foreign('doctor_especialista_id')->references('relacion_id')->on('doctor_por_especialidad')->onUpdate('cascade');
            $table->foreign('consultorio_id')->references('consultorio_id')->on('consultorios')->onUpdate('cascade');
            $table->foreign('expediente_id')->references('expediente_id')->on('expedientes_clinicos')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('citas');
    }
};