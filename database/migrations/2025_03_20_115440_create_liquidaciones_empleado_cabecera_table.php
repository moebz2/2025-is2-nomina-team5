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
            $table->foreignId('empleado_id')->references('id')->on('users');
            $table->foreignId('liquidacion_cabecera_id')->references('id')->on('liquidaciones_cabecera');
            $table->foreignId('generacion_usuario_id')->nullable()->constrained()->references('id')->on('users'); // Usuario que creó el registro
            $table->string('estado', 32);
            $table->timestamp('periodo');
            $table->timestamp('verificacion_fecha')->nullable();
            $table->unique(['empleado_id', 'periodo']);
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