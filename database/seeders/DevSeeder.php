<?php

namespace Database\Seeders;

use App\Models\Concepto;
use App\Models\EmpleadoConcepto;
use App\Models\Hijo;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;
use App\Models\Movimiento;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $nombreConceptoPrueba = 'Prueba no imponible por IPS';

        DB::transaction(function () use ($nombreConceptoPrueba) {
            LiquidacionEmpleadoDetalle::query()->delete();
            LiquidacionEmpleadoCabecera::query()->delete();
            LiquidacionCabecera::query()->delete();
            Movimiento::query()->delete();
            EmpleadoConcepto::query()->delete();
            Concepto::where('nombre', $nombreConceptoPrueba)->delete();
            User::where('email', '!=', 'admin@nomina.com')->delete();
        });

        $usersData = [
            [
                'email' => 'pperez@nomina.com',
                'nombre' => 'Pedro Perez',
                'cedula' => '8765888',
                'sexo' => 'M',
                'nacimiento_fecha' => '1990-01-01',
                'password' => 'password123',
                // Menor a 3 salarios mínimos para que genere bonificación familiar
                'salario' => 6000000,
                'domicilio' => 'Calle Falsa 123',
                'hijos' => [
                    ['nombre' => 'Pedro Jr.', 'fecha_nacimiento' => '2010-06-15'],
                    ['nombre' => 'Martina', 'fecha_nacimiento' => '2012-03-20'],
                ],
            ],
            [
                'email' => 'ggonzalez@nomina.com',
                'nombre' => 'Gonzalo Gonzalez',
                'cedula' => '8654321',
                'sexo' => 'M',
                'nacimiento_fecha' => '1985-05-15',
                'password' => 'password123',
                'salario' => 15700000,
                'domicilio' => 'Avenida Siempre Viva 456',
                'hijos' => [],
            ],
            [
                'email' => 'arojas@nomina.com',
                'nombre' => 'Ana Rojas',
                'cedula' => '9223344',
                'sexo' => 'F',
                'nacimiento_fecha' => '1992-03-10',
                'password' => 'password123',
                'salario' => 22400000,
                'domicilio' => 'Calle Principal 789',
                'hijos' => [
                    ['nombre' => 'Lucas', 'fecha_nacimiento' => '2011-01-10'],
                ],
            ],
        ];

        $salarioConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

        $conceptoPrueba = Concepto::create([
            'nombre' => $nombreConceptoPrueba,
            'tipo_concepto' => Concepto::TIPO_GENERAL,
            'es_debito' => false,
            'estado' => true,
            'ips_incluye' => false,
            'aguinaldo_incluye' => true,
        ]);

        foreach ($usersData as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'nombre' => $userData['nombre'],
                    'email' => $userData['email'],
                    'cedula' => $userData['cedula'],
                    'sexo' => $userData['sexo'],
                    'nacimiento_fecha' => date_create($userData['nacimiento_fecha']),
                    'password' => Hash::make($userData['password']),
                    'domicilio' => $userData['domicilio'],
                ]
            );

            // Insertar hijos

            foreach ($userData['hijos'] as $hijo) {
                Hijo::create([
                    'empleado_id' => $user->id,
                    'nombre' => $hijo['nombre'],
                    'fecha_nacimiento' => $hijo['fecha_nacimiento'],
                ]);
            }

            // Insertar conceptos

            EmpleadoConcepto::create([
                'empleado_id' => $user->id,
                'concepto_id' => $salarioConcepto->id,
                'valor' => $userData['salario'],
                'fecha_inicio' => '2025-01-01',
                'estado' => true,
            ]);

            EmpleadoConcepto::create([
                'empleado_id' => $user->id,
                'concepto_id' => $conceptoPrueba->id,
                'valor' => 250000,
                'fecha_inicio' => '2025-01-01',
                'estado' => true,
            ]);
        }
    }
}
