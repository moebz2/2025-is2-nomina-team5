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
        Schema::create('cargos_empleado', function (Blueprint $table) {
            $table->id();

            $table->foreignId('empleado_id')->references('id')->on('empleados');
            $table->foreignId('cargo_id')->references('id')->on('cargos');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->boolean('es_principal')->default(true);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos_empleado');
    }
};
