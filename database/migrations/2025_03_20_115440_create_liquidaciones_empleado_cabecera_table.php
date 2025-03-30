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
        Schema::create('liquidaciones_empleado_cabecera', function (Blueprint $table) {
            $table->id();

            // Actualizado referencia a tabla usuario
            $table->foreignId('empleado_id')->references('id')->on('users');
            $table->foreignId('liquidacion_cabecera_id')->references('id')->on('liquidaciones_cabecera');
            $table->string('estado',32);
            $table->timestamp('periodo_inicio');
            $table->timestamp('periodo_fin');
            $table->timestamp('verificacion_fecha')->nullable();
            // VERIFICAR: Hace falta agregar quien hace la verificacion: usuario_id?

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidaciones_empleado_cabecera');
    }
};
