<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('usuario_id');
            $table->string('usuario', 16);
            $table->string('clave', 16);
            $table->string('nombre_asignado', 100);
            $table->string('cedula_asignado', 10);
            $table->boolean('admin')->default(0);
            $table->tinyInteger('activo_inactivo')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};