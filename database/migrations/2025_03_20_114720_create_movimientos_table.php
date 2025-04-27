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
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            // Actualizado referencia a tabla usuario
            $table->foreignId('empleado_id')->references('id')->on('users');
            $table->foreignId('concepto_id')->references('id')->on('conceptos');
            $table->integer('monto');
            $table->timestamp('validez_fecha');
            $table->timestamp('generacion_fecha');
            $table->timestamp('eliminacion_fecha')->nullable();
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
