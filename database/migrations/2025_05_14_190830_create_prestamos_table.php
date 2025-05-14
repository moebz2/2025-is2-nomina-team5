<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empleado_id')->references('id')->on('users');
            $table->integer('monto');
            $table->string('estado');
            $table->timestamp('generacion_fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};