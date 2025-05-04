<?php

namespace App\Services;

use App\Models\Concepto;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;
use App\Models\Movimiento;
use App\Models\Parametro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiquidacionService
{
    public function generarLiquidacion($periodo)
    {
        DB::transaction(function () use ($periodo) {

            // crear liquidacion_cabecera
            $liquidacionCabecera = $this->crearLiquidacionCabecera($periodo);

            // traer usuarios estado 'contratado'
            $empleados = $this->obtenerEmpleadosContratados();

            $salarioMinimo = $this->obtenerSalarioMinimo();

            if (empty($salarioMinimo)) {
                throw new \Exception('No se encontró el salario mínimo');
            }

            foreach ($empleados as $empleado) {
                // crear liquidacion de empleado
                $liquidacionEmpleadoCabecera = $this->crearLiquidacionEmpleado($empleado, $liquidacionCabecera, $periodo);

                // Traer todos los movimientos del empleado en el periodo
                $movimientosAProcesar = $this->obtenerMovimientosEmpleado($empleado, $periodo);

                // dd($movimientosAProcesar);

                // Registrar 9% de descuento por IPS, de
                // movimientos con concepto.ips_incluye = true
                $this->registrarIpsDescuento($empleado, $movimientosAProcesar, $periodo);

                $movimientosAIncluir = $this->obtenerMovimientosEmpleado($empleado, $periodo);

                // log('movimientosAProcesar', json_encode($movimientosAProcesar));
                // log('movimientosAIncluir', json_encode($movimientosAIncluir));

                // Registrar movimientos en la liquidación
                $this->registrarMovimientosEnLiquidacion($liquidacionEmpleadoCabecera, $movimientosAIncluir);
            }
        });
    }

    private function crearLiquidacionCabecera($periodo)
    {
        return LiquidacionCabecera::create([
            'generacion_fecha' => now(),
            'estado' => 'pendiente',
            'aprobacion_fecha' => null,
            'aprobacion_usuario_id' => null,
            'periodo' => $periodo . '-01',
        ]);
    }

    private function obtenerEmpleadosContratados()
    {
        return User::where('estado', 'contratado')
            ->orderBy('id', 'desc')
            ->get();
    }

    public function obtenerSalarioMinimo()
    {
        return Parametro::where('nombre', Parametro::SALARIO_MINIMO)->first()->valor;
    }

    private function crearLiquidacionEmpleado($empleado, $liquidacionCabecera, $periodo)
    {
        return LiquidacionEmpleadoCabecera::create([
            'empleado_id' => $empleado->id,
            'liquidacion_cabecera_id' => $liquidacionCabecera->id,
            'estado' => LiquidacionEmpleadoCabecera::ESTADO_PENDIENTE,
            'periodo' => date_create($periodo . '-31'),
            'verificacion_fecha' => null,
        ]);
    }

    private function obtenerMovimientosEmpleado($empleado, $periodo)
    {
        $query = Movimiento::where('empleado_id', $empleado->id)
            ->where('validez_fecha', '>=', date_create($periodo . '-01'))
            ->where('validez_fecha', '<', date_create($periodo . '-01')->modify('first day of next month'));

        error_log('obtenerMovimientosEmpleado.Query:' . json_encode($query->toSql()));
        error_log('obtenerMovimientosEmpleado.Bindings:' . json_encode($query->getBindings()));

        return $query->get();
    }

    private function registrarIpsDescuento($empleado, $movimientos, $periodo)
    {
        $totalImponible = 0;

        foreach ($movimientos as $movimiento) {
            if ($movimiento->concepto->ips_incluye) {
                $totalImponible += $movimiento->monto;
            }
        }

        $ipsDescuento = $totalImponible * Concepto::IPS_PORCENTAJE;

        Movimiento::create([
            'empleado_id' => $empleado->id,
            'concepto_id' => 3,
            'monto' => $ipsDescuento,
            'validez_fecha' => date_create($periodo . '-01'),
            'generacion_fecha' => now(),
        ]);
    }

    private function registrarMovimientosEnLiquidacion($liquidacionEmpleadoCabecera, $movimientos)
    {
        foreach ($movimientos as $movimiento) {

            error_log('registrarMovimientosEnLiquidacion.movimiento:' . json_encode($movimiento));
            error_log('registrarMovimientosEnLiquidacion.liquidacionEmpleadoCabecera:' . json_encode($liquidacionEmpleadoCabecera));

            LiquidacionEmpleadoDetalle::create([
                'cabecera_id' => $liquidacionEmpleadoCabecera->id,
                'movimiento_id' => $movimiento->id,
            ]);
        }
    }
}
