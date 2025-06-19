<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('usuario_id')->unique();
            $table->string('usuario')->unique();
            $table->string('nombre_asignado');
            $table->string('cedula_asignada');
            $table->string('clave');
            $table->boolean('es_admin')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}