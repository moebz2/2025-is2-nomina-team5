<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('liquidacion_empleado_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabecera_id')->references('id')->on('liquidaciones_empleado_cabecera');
            $table->foreignId('movimiento_id')->references('id')->on('movimientos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('liquidacion_empleado_detalles');
    }
};
