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
        Schema::create('usuario_conceptos', function (Blueprint $table) {
            $table->id();

            $table->foreignId('usuario_id')->references('id')->on('users');
            $table->foreignId('concepto_id')->references('id')->on('conceptos');


            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario_conceptos');
    }
};
