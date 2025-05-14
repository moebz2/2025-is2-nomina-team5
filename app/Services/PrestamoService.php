<?php

namespace App\Services;

use App\Models\Concepto;
use App\Models\Movimiento;
use App\Models\Prestamo;
use App\Models\User;

class PrestamoService
{
    public function generarCuotas($fechaCb)
    {
        error_log('generarCuotas.start');

        $prestamos = Prestamo::where('estado', 'vigente')->get();

        foreach ($prestamos as $prestamo) {
            $conceptoPrestamo = Concepto::where('tipo_concepto', Concepto::TIPO_PRESTAMO)->first();

            if (!$conceptoPrestamo) {
                throw new \Exception('Concepto de tipo préstamo no encontrado.');
            }

            $montoPagado = $prestamo->movimientos()
                ->whereHas('liquidacionEmpleadoDetalle')
                ->sum('monto');

            error_log('generarCuotas.montoPagado: ' . $montoPagado);

            $montoRestante = $prestamo->monto - $montoPagado;

            error_log('generarCuotas.montoRestante: ' . $montoRestante);

            if ($montoRestante <= 0) {
                // no debería entrar acá
                // significaría que ya se pagó todo pero no se marcó como pagado.
                continue;
            }

            $cuotasRestantes = $prestamo->cuotas - $prestamo->movimientos()->whereHas('liquidacionEmpleadoDetalle')->count();
            $montoCuota = intdiv($montoRestante, $cuotasRestantes);
            $diferencia = $montoRestante - ($montoCuota * $cuotasRestantes);

            $montoCuotaFinal = $cuotasRestantes === 1 ? $montoCuota + $diferencia : $montoCuota;

            Movimiento::create([
                'empleado_id' => $prestamo->empleado_id,
                'concepto_id' => $conceptoPrestamo->id,
                'monto' => $montoCuotaFinal,
                'validez_fecha' => $fechaCb,
                'generacion_fecha' => now(),
                'prestamo_id' => $prestamo->id,
            ]);
        }
    }
}
