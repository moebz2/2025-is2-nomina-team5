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

            // Actualizado referencia a tabla usuario
            $table->foreignId('empleado_id')->unique()->references('id')->on('users');
            $table->foreignId('cargo_id')->references('id')->on('cargos');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
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
