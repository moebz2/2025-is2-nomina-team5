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
                $movimientos = $this->obtenerMovimientosEmpleado($empleado, $periodo);

                // Registrar 9% de descuento por IPS, de
                // movimientos con concepto.ips_incluye = true
                $this->registrarIpsDescuento($empleado, $movimientos, $periodo);

                // Registrar movimientos en la liquidación
                $this->registrarMovimientosEnLiquidacion($liquidacionEmpleadoCabecera, $movimientos);
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
            ->with('cargos')
            ->get();
    }

    private function obtenerSalarioMinimo()
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
        return Movimiento::where('empleado_id', $empleado->id)
            ->where('validez_fecha', '>=', date_create($periodo . '-01'))
            ->where('validez_fecha', '<', date_create($periodo . '-01')->modify('first day of next month'))
            ->get();
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
            LiquidacionEmpleadoDetalle::create([
                'cabecera_id' => $liquidacionEmpleadoCabecera->id,
                'movimiento_id' => $movimiento->id,
            ]);
        }
    }
}