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
use Carbon\Carbon; // Importar Carbon

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $nombreConceptoPrueba = 'Prueba no imponible por IPS';
        $nombreConceptoBonificacionFamiliar = 'Bonificacion Familiar'; // Asumo este nombre para el concepto de bonificación

        DB::transaction(function () use ($nombreConceptoPrueba) {
            LiquidacionEmpleadoDetalle::query()->delete();
            LiquidacionEmpleadoCabecera::query()->delete();
            LiquidacionCabecera::query()->delete();
            Movimiento::query()->delete();
            EmpleadoConcepto::query()->delete();
            Concepto::where('nombre', $nombreConceptoPrueba)->delete();
            User::where('email', '!=', 'admin@nomina.com')->delete(); // Conservar el usuario admin
            Concepto::where('tipo_concepto', Concepto::TIPO_BONIFICACION)->delete(); // Eliminar concepto de bonificación si existe para recrearlo
        });

        // Asegúrate de que los conceptos de salario y bonificación existan o créalos
        $salarioConcepto = Concepto::firstOrCreate(
            ['tipo_concepto' => Concepto::TIPO_SALARIO],
            [
                'nombre' => 'Salario Base',
                'ips_incluye' => true,
                'estado' => true,
                'aguinaldo_incluye' => true,
                'es_debito' => false,
                'es_modificable' => false,
            ]
        );

        $bonificacionFamiliarConcepto = Concepto::firstOrCreate(
            ['tipo_concepto' => Concepto::TIPO_BONIFICACION],
            [
                'nombre' => $nombreConceptoBonificacionFamiliar,
                'ips_incluye' => false,
                'estado' => true,
                'aguinaldo_incluye' => false, // La bonificación familiar puede no incluirse en aguinaldo
                'es_debito' => false,
                'es_modificable' => false,
            ]
        );

        $conceptoPrueba = Concepto::create([
            'nombre' => $nombreConceptoPrueba,
            'tipo_concepto' => Concepto::TIPO_GENERAL,
            'es_debito' => false,
            'estado' => true,
            'ips_incluye' => false,
            'aguinaldo_incluye' => true,
            'es_modificable' => true,
        ]);

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
                'salario' => 15700000, // No generará bonificación familiar (asumo más de 3 SM)
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
                'salario' => 22400000, // No generará bonificación familiar
                'domicilio' => 'Calle Principal 789',
                'hijos' => [
                    ['nombre' => 'Lucas', 'fecha_nacimiento' => '2011-01-10'],
                ],
            ],
        ];

        // Definir la fecha de inicio para la generación de liquidaciones
        $currentDate = Carbon::now(); // Fecha y hora actual: 2025-05-22 10:43:46
        $startDate = Carbon::create(2025, 1, 1, 0, 0, 0); // Enero 2025
        $endDate = $currentDate->copy()->endOfMonth(); // Fin del mes actual

        foreach ($usersData as $userData) {
            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                [
                    'nombre' => $userData['nombre'],
                    'cedula' => $userData['cedula'],
                    'sexo' => $userData['sexo'],
                    'nacimiento_fecha' => $userData['nacimiento_fecha'],
                    'password' => Hash::make($userData['password']),
                    'domicilio' => $userData['domicilio'],
                ]
            );

            // Insertar hijos
            foreach ($userData['hijos'] as $hijo) {
                Hijo::firstOrCreate( // Usar firstOrCreate para evitar duplicados si se corre varias veces
                    ['empleado_id' => $user->id, 'nombre' => $hijo['nombre']],
                    ['fecha_nacimiento' => $hijo['fecha_nacimiento']]
                );
            }

            // Insertar Conceptos fijos (Salario y Concepto Prueba)
            // Asegurarse de que solo haya una asignación activa de salario
            EmpleadoConcepto::updateOrCreate(
                [
                    'empleado_id' => $user->id,
                    'concepto_id' => $salarioConcepto->id,
                    // Si ya existe un salario para el mismo período, lo actualiza,
                    // sino crea uno nuevo. Aquí estamos asumiendo que el salario base
                    // no cambia desde 2025-01-01
                ],
                [
                    'valor' => $userData['salario'],
                    'fecha_inicio' => $startDate->toDateString(), // Desde el inicio de la generación de datos
                    'es_activo' => true,
                    'estado' => true,
                ]
            );

            EmpleadoConcepto::updateOrCreate(
                [
                    'empleado_id' => $user->id,
                    'concepto_id' => $conceptoPrueba->id,
                    // Similar al salario, asumiendo que el valor del concepto de prueba no cambia
                ],
                [
                    'valor' => 250000,
                    'fecha_inicio' => $startDate->toDateString(),
                    'es_activo' => true,
                    'estado' => true,
                ]
            );

            // --- Generación de liquidaciones mensuales ---
            $currentMonth = $startDate->copy();
            while ($currentMonth->lessThanOrEqualTo($endDate)) {

                // 1. Crear LiquidacionCabecera si no existe para el periodo
                $liquidacionCabecera = LiquidacionCabecera::firstOrCreate(
                    ['periodo' => $currentMonth->startOfMonth()->toDateString()],
                    ['nombre' => 'Liquidación de ' . $currentMonth->isoFormat('MMMM YYYY')]
                );

                // 2. Crear LiquidacionEmpleadoCabecera
                $liquidacionEmpleadoCabecera = LiquidacionEmpleadoCabecera::firstOrCreate(
                    [
                        'empleado_id' => $user->id,
                        'periodo' => $currentMonth->startOfMonth()->toDateString(),
                    ],
                    [
                        'liquidacion_cabecera_id' => $liquidacionCabecera->id,
                        'generacion_usuario_id' => 1, // Suponiendo un usuario generador con ID 1
                        'estado' => 'pagado', // Asumimos que todas las liquidaciones generadas se consideran pagadas
                        'verificacion_fecha' => $currentMonth->copy()->endOfMonth(), // Fecha de verificación al final del mes
                    ]
                );

                // 3. Obtener el salario base y el concepto de prueba para este usuario
                $salarioBase = $user->conceptos()
                                    ->where('conceptos.tipo_concepto', Concepto::TIPO_SALARIO)
                                    ->wherePivot('fecha_inicio', '<=', $currentMonth->toDateString())
                                    ->where(function ($query) use ($currentMonth) {
                                        $query->whereNull('fecha_fin')
                                              ->orWhere('fecha_fin', '>=', $currentMonth->toDateString());
                                    })
                                    ->first();

                $conceptoPruebaAsignado = $user->conceptos()
                                                ->where('conceptos.nombre', $nombreConceptoPrueba)
                                                ->wherePivot('fecha_inicio', '<=', $currentMonth->toDateString())
                                                ->where(function ($query) use ($currentMonth) {
                                                    $query->whereNull('fecha_fin')
                                                          ->orWhere('fecha_fin', '>=', $currentMonth->toDateString());
                                                })
                                                ->first();


                // 4. Crear Movimientos y Detalles de Liquidación
                $totalMontoMensual = 0;

                // Movimiento de Salario Base
                if ($salarioBase) {
                    $movimientoSalario = Movimiento::firstOrCreate(
                        [
                            'empleado_id' => $user->id,
                            'concepto_id' => $salarioConcepto->id,
                            'validez_fecha' => $currentMonth->startOfMonth()->toDateString(), // Valido para este mes
                            'generacion_fecha' => $currentMonth->copy()->endOfMonth()->toDateString(), // Fecha de generación (fin de mes)
                        ],
                        [
                            'monto' => $salarioBase->pivot->valor,
                            'prestamo_id' => null, // No es un préstamo
                            'eliminacion_fecha' => null,
                        ]
                    );
                    LiquidacionEmpleadoDetalle::firstOrCreate(
                        ['cabecera_id' => $liquidacionEmpleadoCabecera->id, 'movimiento_id' => $movimientoSalario->id]
                    );
                    $totalMontoMensual += $movimientoSalario->monto;
                }


                // Movimiento de Bonificación Familiar (solo si aplica)
                $salarioMinimo = 2680373; // Ejemplo de salario mínimo para Paraguay
                if ($user->hijos->count() > 0 && $user->conceptos()->where('conceptos.tipo_concepto', Concepto::TIPO_SALARIO)->first()->pivot->valor < (3 * $salarioMinimo)) {
                    $montoBonificacion = $user->hijos->count() * 50000; // Ejemplo: 50.000 por hijo
                    $movimientoBonificacion = Movimiento::firstOrCreate(
                        [
                            'empleado_id' => $user->id,
                            'concepto_id' => $bonificacionFamiliarConcepto->id,
                            'validez_fecha' => $currentMonth->startOfMonth()->toDateString(),
                            'generacion_fecha' => $currentMonth->copy()->endOfMonth()->toDateString(),
                        ],
                        [
                            'monto' => $montoBonificacion,
                            'prestamo_id' => null,
                            'eliminacion_fecha' => null,
                        ]
                    );
                    LiquidacionEmpleadoDetalle::firstOrCreate(
                        ['cabecera_id' => $liquidacionEmpleadoCabecera->id, 'movimiento_id' => $movimientoBonificacion->id]
                    );
                    $totalMontoMensual += $movimientoBonificacion->monto;
                }

                // Movimiento de Concepto de Prueba
                if ($conceptoPruebaAsignado) {
                    $movimientoPrueba = Movimiento::firstOrCreate(
                        [
                            'empleado_id' => $user->id,
                            'concepto_id' => $conceptoPrueba->id,
                            'validez_fecha' => $currentMonth->startOfMonth()->toDateString(),
                            'generacion_fecha' => $currentMonth->copy()->endOfMonth()->toDateString(),
                        ],
                        [
                            'monto' => $conceptoPruebaAsignado->pivot->valor,
                            'prestamo_id' => null,
                            'eliminacion_fecha' => null,
                        ]
                    );
                    LiquidacionEmpleadoDetalle::firstOrCreate(
                        ['cabecera_id' => $liquidacionEmpleadoCabecera->id, 'movimiento_id' => $movimientoPrueba->id]
                    );
                    $totalMontoMensual += $movimientoPrueba->monto;
                }

                // Aquí podrías agregar más movimientos (débitos, créditos, etc.) si los quieres para cada mes

                // Avanzar al siguiente mes
                $currentMonth->addMonth();
            }
        }
    }
}