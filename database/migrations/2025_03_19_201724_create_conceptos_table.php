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
        /**
         * Que hace esta migracion:
         *  - Agrega campo identificando al concepto como: débito o crédito.
         *  - Indicar si será considerado en el cálculo del aguinaldo.
         *  - Se indica que tipo de concepto es: salario y bonificación o un concepto general
         */
        Schema::create('conceptos', static function (Blueprint $table) {

            $table->id();
            $table->string('nombre');
            $table->boolean('ips_incluye')->default(true);
            $table->boolean('estado')->default(true);
            $table->timestamps();

            // Determinamos si se incluye en el cálculo del aguinaldo
            $table->boolean('aguinaldo_incluye')->default(true);

            // Diferenciamos salario, bonificación y tipos de conceptos
            $table->enum('tipo_concepto', ['salario', 'bonificacion', 'ips', 'general'])->default('general');

            // Se indica como true cuando un concepto es débito (resta), todo lo demás es crédito (suma)
            $table->boolean('es_debito')->default(false);

            // Aseguramos que los conceptos salario y bonificación no sean modificables en el sistema
            $table->boolean('es_modificable')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
