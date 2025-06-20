<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cuentas_bancarias', function (Blueprint $table) {
            $table->id('id_cuenta_bancaria');
            $table->string('nombre_titular', 200);
            $table->string('cedula_titular', 10);
            $table->string('banco', 20);
            $table->string('numero_telefonico', 15);
            $table->boolean('pago_movil');
            $table->tinyInteger('activo_inactivo')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cuentas_bancarias');
    }
};