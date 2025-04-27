<?php

namespace Database\Seeders;

use App\Models\Concepto;
use App\Models\EmpleadoConcepto;
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
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {
            LiquidacionEmpleadoDetalle::query()->delete();
            LiquidacionEmpleadoCabecera::query()->delete();
            LiquidacionCabecera::query()->delete();
            Movimiento::query()->delete();
        });

        $usersData = [
            [
                'email' => 'pperez@nomina.com',
                'nombre' => 'Pedro Perez',
                'cedula' => '8765888',
                'sexo' => 'M',
                'nacimiento_fecha' => '1990-01-01',
                'password' => 'password123',
                'salario' => 12500000,
                'bonificacion' => 1000000,
            ],
            [
                'email' => 'ggonzalez@nomina.com',
                'nombre' => 'Gonzalo Gonzalez',
                'cedula' => '8654321',
                'sexo' => 'M',
                'nacimiento_fecha' => '1985-05-15',
                'password' => 'password123',
                'salario' => 15700000,
                'bonificacion' => 750000,
            ],
            [
                'email' => 'arojas@nomina.com',
                'nombre' => 'Ana Rojas',
                'cedula' => '9223344',
                'sexo' => 'F',
                'nacimiento_fecha' => '1992-03-10',
                'password' => 'password123',
                'salario' => 22400000,
                'bonificacion' => 1369000,
            ],
        ];

        $bonificacionConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_BONIFICACION)->first();
        if (!$bonificacionConcepto) {
            throw new \Exception('Concepto with tipo_concepto = TIPO_BONIFICACION not found.');
        }

        $salarioConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_SALARIO)->first();
        if (!$salarioConcepto) {
            throw new \Exception('Concepto with tipo_concepto = TIPO_SALARIO not found.');
        }

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
                ]
            );

            // Create EmpleadoConcepto for bonification
            EmpleadoConcepto::create([
                'empleado_id' => $user->id,
                'concepto_id' => $bonificacionConcepto->id,
                'valor' => $userData['bonificacion'],
                'fecha_inicio' => now(),
                'estado' => true,
            ]);

            // Create EmpleadoConcepto for salary
            EmpleadoConcepto::create([
                'empleado_id' => $user->id,
                'concepto_id' => $salarioConcepto->id,
                'valor' => $userData['salario'],
                'fecha_inicio' => now(),
                'estado' => true,
            ]);
        }
    }
}
