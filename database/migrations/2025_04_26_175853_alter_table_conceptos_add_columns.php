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
        /* Que hace esta migracion:
             *  - Agrega campo identificando al concepto como: débito o crédito.
                - Indicar si será considerado en el cálculo del aguinaldo.
                - Se indica que tipo de concepto es: salario y bonificacion o un concepto general

             */
        Schema::table('conceptos', function (Blueprint $table) {

            // Deterinamos si se incluye en el calculo del aguinaldo
            $table->boolean('aguinaldo_incluye')->default(true)->after('ips_incluye');
            // Diferenciamos salario, bonificacion de otros tipos de conceptos. Conviene incluir como atributos estaticos en
            // el modelo de concepto para acceder de forma directa
            $table->enum('tipo_concepto', ['salario', 'bonificacion', 'general'])->default('general')->after('nombre');

            // Se indica como true cuando un concepto es debito (resta) todo lo demas es credito (suma)
            $table->boolean('es_debito')->default(false)->after('estado');

            // Con esta campo aseguramos que los conceptos salario y bonificacion no sean modificables en el sistema
            // despues de creadas
            $table->boolean('es_modificable')->default(true)->after('es_debito');
        });



    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conceptos', function (Blueprint $table) {
            $table->dropColumn(['tipo_concepto', 'aguinaldo_incluye', 'es_debito', 'es_modificable']);
        });
    }
};
