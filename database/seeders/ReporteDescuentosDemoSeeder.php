<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Empleado;
use App\Models\Concepto;
use App\Models\Movimiento;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;

class ReporteDescuentosDemoSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario y empleado
        $user = User::factory()->create([
            'name' => 'Carlos Ruiz',
            'email' => 'carlos@example.com',
            'password' => bcrypt('password'),
        ]);

        $empleado = Empleado::create([
            'usuario_id' => $user->id,
            'departamento_id' => 1, // asumimos que ya hay un departamento
            'fecha_ingreso' => now()->subMonths(6),
            'estado' => 'CONTRATADO',
        ]);

        // Crear conceptos
        $ips = Concepto::create([
            'nombre' => 'IPS',
            'tipo_concepto' => 'ips',
            'es_debito' => true,
            'estado' => true,
            'ips_incluye' => false,
            'aguinaldo_incluye' => false,
        ]);

        $prestamo = Concepto::create([
            'nombre' => 'Préstamo',
            'tipo_concepto' => 'general',
            'es_debito' => true,
            'estado' => true,
            'ips_incluye' => false,
            'aguinaldo_incluye' => false,
        ]);

        // Crear movimientos
        $movimiento1 = Movimiento::create([
            'empleado_id' => $user->id,
            'concepto_id' => $ips->id,
            'monto' => 250000,
            'validez_fecha' => now(),
            'generacion_fecha' => now(),
        ]);

        $movimiento2 = Movimiento::create([
            'empleado_id' => $user->id,
            'concepto_id' => $prestamo->id,
            'monto' => 400000,
            'validez_fecha' => now(),
            'generacion_fecha' => now(),
        ]);

        // Crear cabecera de liquidación
        $cabecera = LiquidacionEmpleadoCabecera::create([
            'empleado_id' => $user->id,
            'liquidacion_cabecera_id' => 1, // asumimos que ya hay una cabecera general
            'estado' => 'aprobado',
            'periodo' => now(),
            'verificacion_fecha' => now(),
        ]);

        // Crear detalles
        LiquidacionEmpleadoDetalle::create([
            'cabecera_id' => $cabecera->id,
            'movimiento_id' => $movimiento1->id,
            'created_at' => now()->subDays(2),
        ]);

        LiquidacionEmpleadoDetalle::create([
            'cabecera_id' => $cabecera->id,
            'movimiento_id' => $movimiento2->id,
            'created_at' => now()->subDay(),
        ]);
    }
}
