<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_consultorio', function (Blueprint $table) {
            $table->id('tipo_consultorio_id');
            $table->text('descripcion');
            $table->text('equipamiento');
            $table->tinyInteger('activo_inactivo');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_consultorio');
    }
};