<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('expediente', function (Blueprint $table) {
            $table->expediente_id();
            $table->string('diagnostico');
            $table->string('tratamiento');
            $table->string('receta');
            $table->string('observaciones');
            $table->boolval('activo_inactivo');
            $table->timestamps('fecha_creacion');
            $table->timestamps('fecha_actualizacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expediente');
    }
};
