<?php

namespace Database\Seeders;

use App\Models\Concepto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConceptoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Concepto de salario no modificable
        Concepto::create([
            'nombre' => 'Salario',
            'ips_incluye' => true,
            'aguinaldo_incluye' => true,
            'tipo_concepto' => Concepto::TIPO_SALARIO,
            'es_debito' => false,
            'estado' => true,
            'es_modificable' => false,
        ]);

        // Concepto de bonificacion no modificable
        Concepto::create([
            'nombre' => 'Bonificación familiar',
            'ips_incluye' => true,
            'aguinaldo_incluye' => true,
            'tipo_concepto' => Concepto::TIPO_BONIFICACION,
            'es_debito' => false,
            'estado' => true,
            'es_modificable' => false,
        ]);

        // Concepto de ips no modificable
        Concepto::create([
            'nombre' => 'IPS',
            'ips_incluye' => false,
            'aguinaldo_incluye' => false,
            'tipo_concepto' => Concepto::TIPO_IPS,
            'es_debito' => true,
            'estado' => true,
            'es_modificable' => false,
        ]);
    }
}
