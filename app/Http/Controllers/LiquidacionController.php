<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;
use App\Models\Movimiento;
use App\Models\Parametro;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class LiquidacionController extends Controller
{
    public function index()
    {
        $liquidaciones = LiquidacionCabecera::with('aprobacionUsuario')->get();

        return view('liquidacion.index', compact('liquidaciones'));
    }

    public function showFormGenerar()
    {
        return view('liquidacion.generar-liquidacion');
    }

    public function generar(Request $request)
    {
        $request->validate([
            'periodo' => 'required|date',
        ]);

        DB::transaction(function () use ($request) {


            // crear liquidacion_cabecera

            $periodo = $request->input('periodo');

            $liquidacionCabecera = LiquidacionCabecera::create([
                'generacion_fecha' => now(),
                'estado' => 'pendiente',
                'aprobacion_fecha' => null,
                'aprobacion_usuario_id' => null,
                'periodo' => $periodo,
            ]);

            // traer usuarios estado 'contratado'

            $empleados = User::where('estado', 'contratado')
                ->with('cargos')
                ->get();

            $salarioMinimo = Parametro::where('nombre', Parametro::SALARIO_MINIMO)->first()->valor;

            if (empty($salarioMinimo)) {
                return redirect()->back()->withErrors(['error' => 'No se encontró el salario mínimo']);
            }

            $bonificacionPorHijo = 0.05;

            foreach ($empleados as $empleado) {
                // Columns:
                // id	bigint UN AI PK
                // empleado_id	bigint UN
                // liquidacion_cabecera_id	bigint UN
                // estado	varchar(32)
                // periodo_inicio	timestamp
                // periodo_fin	timestamp
                // verificacion_fecha	timestamp            
                $liquidacionEmpleadoCabecera =  LiquidacionEmpleadoCabecera::create(
                    [
                        'empleado_id' => $empleado->id,
                        'liquidacion_cabecera_id' => $liquidacionCabecera->id,
                        'estado' => LiquidacionEmpleadoCabecera::ESTADO_PENDIENTE,
                        'periodo' => date_create($periodo . '-31'),
                        'verificacion_fecha' => null,
                    ]
                );

                // Registrar movimiento del salario del empleado

                // Descomentar tras merge con cambios de Juan

                // $conceptoSalario = Concepto::where('tipo_concepto', 'salario')->first();
                // $conceptoEmpleadoSalario = EmpleadoConcepto::where('empleado_id', $empleado->id)
                //     ->where('concepto_id', $conceptoSalario->id) // Salario
                //     ->first();
                // if (empty($conceptoEmpleadoSalario->valor)) {
                //     return redirect()->back()->withErrors(['error' => 'No se encontró el salario del empleado']);
                // }
                // $salarioMonto = $conceptoEmpleadoSalario->valor;

                $salarioMonto = 12500000;

                Movimiento::create([
                    'empleado_id' => $empleado->id,
                    // 'concepto_id' => $concepto->id, // Descomentar tras merge con cambios de Juan
                    'concepto_id' => 1,
                    'monto' => $salarioMonto,
                    'validez_fecha' => date_create($periodo . '-01'),
                    'generacion_fecha' => now(),
                ]);

                // Registrar movimiento de la bonificación por hijo menor de 18 años, si el empleado gana menos de 3 salarios mínimos oficiales. El monto es el 5% del salario mínimo oficial por cada hijo menor de 18 años.

                if ($salarioMonto < ($salarioMinimo * 3)) {
                    $hijosMenores = $empleado->hijos;
                    if ($hijosMenores > 0) {
                        $bonificacionHijos = $salarioMinimo * $bonificacionPorHijo * $hijosMenores;
                        Movimiento::create([
                            'empleado_id' => $empleado->id,
                            // 'concepto_id' => $concepto->id, // Descomentar tras merge con cambios de Juan
                            'concepto_id' => 2,
                            'monto' => $bonificacionHijos,
                            'validez_fecha' => date_create($periodo . '-01'),
                            'generacion_fecha' => now(),
                        ]);
                    }
                }

                // Traer todos los movimientos del empleado en el periodo

                $movimientos = Movimiento::where('empleado_id', $empleado->id)
                    ->where(
                        'validez_fecha',
                        '>=',
                        date_create($periodo . '-01')
                    )
                    ->where(
                        'validez_fecha',
                        '<',
                        date_create($periodo . '-01')->modify('first day of next month')
                    )
                    ->get();

                // Registrar 9% de descuento por IPS, de
                // movimientos con concepto.ips_incluye = true

                $totalImponible = 0;

                foreach ($movimientos as $movimiento) {
                    if ($movimiento->concepto->ips_incluye) {
                        $totalImponible += $movimiento->monto;
                    }
                }

                $ipsDescuento = $totalImponible * Concepto::IPS_PORCENTAJE;

                Movimiento::create([
                    'empleado_id' => $empleado->id,
                    // 'concepto_id' => $concepto->id, // Descomentar tras merge con cambios de Juan
                    'concepto_id' => 3,
                    'monto' => $ipsDescuento,
                    'validez_fecha' => date_create($periodo . '-01'),
                    'generacion_fecha' => now(),
                ]);

                // Registrar movimientos en la liquidación

                foreach ($movimientos as $movimiento) {
                    LiquidacionEmpleadoDetalle::create([
                        'cabecera_id' => $liquidacionEmpleadoCabecera->id,
                        'movimiento_id' => $movimiento->monto,
                    ]);
                }
            }
        });


        return redirect()->route('liquidacion.index')->with('success', 'Liquidación generada correctamente');
    }
}
