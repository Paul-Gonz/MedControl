<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('doctor_por_especialidad', function (Blueprint $table) {
            $table->id('relacion_id');
            $table->unsignedBigInteger('especialidad_id');
            $table->unsignedBigInteger('doctor_id');

            $table->foreign('especialidad_id')->references('especialidad_id')->on('especialidades')->onUpdate('cascade');
            $table->foreign('doctor_id')->references('doctor_id')->on('doctores')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('doctor_por_especialidad');
    }
};