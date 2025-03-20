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
        Schema::create('liquidacion_empleado_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('liquidacion_empleado_cabecera')->references('id')->on('liquidaciones_empleado_cabecera');
            $table->foreignId('movimiento_id')->references('id')->on('movimientos');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidacion_empleado_detalles');
    }
};
