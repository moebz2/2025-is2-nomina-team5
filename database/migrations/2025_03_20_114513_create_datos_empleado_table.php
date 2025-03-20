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
        Schema::create('datos_empleado', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->references('id')->on('empleados');
            $table->string('tipo_dato', 50);
            $table->text('valor');
            $table->timestamp('fecha_actualizacion');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('datos_empleado');
    }
};
