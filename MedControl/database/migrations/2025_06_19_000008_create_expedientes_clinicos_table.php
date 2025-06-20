<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('expedientes_clinicos', function (Blueprint $table) {
            $table->id('expediente_id');
            $table->text('diagnostico');
            $table->text('tratamiento');
            $table->text('receta');
            $table->text('observaciones');
            $table->dateTime('fecha_creacion')->useCurrent();
            $table->dateTime('fecha_actualizacion');
            $table->tinyInteger('activo_inactivo')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('expedientes_clinicos');
    }
};