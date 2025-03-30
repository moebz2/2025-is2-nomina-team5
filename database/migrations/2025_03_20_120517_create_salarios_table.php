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
        Schema::create('salarios', function (Blueprint $table) {
            $table->id();

            // Actualizado referencia a tabla usuario
            $table->foreignId('empleado_id')->references('id')->on('users');
            $table->integer('monto');
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salarios');
    }
};
