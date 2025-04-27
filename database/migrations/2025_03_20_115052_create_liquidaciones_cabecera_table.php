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
            $table->foreignId('aprobacion_usuario_id')->nullable()->constrained()->references('id')->on('users');
            $table->timestamp('generacion_fecha');
            $table->string('estado');
            $table->timestamp('aprobacion_fecha')->nullable();
            $table->date('periodo')->unique();

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
