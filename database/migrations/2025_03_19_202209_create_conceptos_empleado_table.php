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
        Schema::create('conceptos_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->references('id')->on('empleados');
            $table->foreignId('concepto_id')->references('id')->on('conceptos');
            $table->decimal('valor');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->boolean('estado')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos_empleado');
    }
};
