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

            // Diferenciamos salario, bonificacion de otros tipos
            // de conceptos. Conviene incluir como atributos estaticos
            // en el modelo de concepto para acceder de forma directa
            $table->enum('tipo_concepto', ['salario', 'bonificacion', 'ips', 'general'])->default('general');

            // Se indica como true cuando un concepto es debito (resta) todo lo demas es credito (suma)
            $table->boolean('es_debito')->default(false);

            // Con esta campo aseguramos que los conceptos salario
            // y bonificacion no sean modificables en el sistema
            // despues de creadas
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
