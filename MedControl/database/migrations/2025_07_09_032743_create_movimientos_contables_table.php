<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up()
    {
        Schema::create('movimientos_contables', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('cuenta'); // Ej: 'Materiales', 'Insumos Médicos'
            $table->string('descripcion');
            $table->decimal('debe', 15, 2)->default(0);
            $table->decimal('haber', 15, 2)->default(0);
            $table->string('referencia')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_contables');
    }
};
