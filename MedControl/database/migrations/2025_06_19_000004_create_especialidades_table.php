<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('especialidades', function (Blueprint $table) {
            $table->id('especialidad_id');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->tinyInteger('activo_inactivo')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('especialidades');
    }
};