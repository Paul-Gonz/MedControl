<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('consultorios', function (Blueprint $table) {
            $table->id('consultorio_id');
            $table->unsignedBigInteger('tipo_id');
            $table->text('ubicacion');
            $table->enum('estado_consultorio', ['disponible', 'en_mantenimiento', 'no_disponible'])->default('disponible');
            $table->tinyInteger('activo_inactivo')->default(1);

            $table->foreign('tipo_id')->references('tipo_consultorio_id')->on('tipo_consultorio')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('consultorios');
    }
};
