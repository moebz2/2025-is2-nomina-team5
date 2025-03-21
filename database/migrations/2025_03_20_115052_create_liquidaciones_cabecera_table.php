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
        Schema::create('liquidaciones_cabecera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aprobacion_usuario_id')->references('id')->on('users');
            $table->timestamp('generacion_fecha');
            $table->string('estado');
            $table->timestamp('aprobacion_fecha')->nullable();
            // TODO: Como es el formato de fecha?. VERIFICAR
            $table->date('periodo');

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('liquidaciones_cabecera');
    }
};
