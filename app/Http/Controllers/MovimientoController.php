<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoConcepto;
use App\Models\Movimiento;
use App\Models\Concepto;
use App\Models\User;
use App\Services\LiquidacionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    protected $liquidacionService;

    public function __construct(LiquidacionService $liquidacionService)
    {
        $this->liquidacionService = $liquidacionService;
    }

    public function generarMovimientos(Request $request)
    {
        $request->validate([
            'periodo' => 'nullable|date_format:Y-m',
        ]);

        $periodo = $request->input('periodo', Carbon::now()->format('Y-m'));
        [$year, $month] = explode('-', $periodo);

        // Movimientos normales desde conceptos
        $empleadoConceptos = EmpleadoConcepto::where(function ($query) use ($year, $month) {
            $query->whereYear('fecha_inicio', $year)
                ->whereMonth('fecha_inicio', $month);
        })->orWhere(function ($query) use ($year, $month) {
            $query->whereYear('fecha_fin', $year)
                ->whereMonth('fecha_fin', $month);
        })->get();

        foreach ($empleadoConceptos as $empleadoConcepto) {
            Movimiento::create([
                'empleado_id' => $empleadoConcepto->empleado_id,
                'concepto_id' => $empleadoConcepto->concepto_id,
                'monto' => $empleadoConcepto->valor,
                'validez_fecha' => Carbon::createFromDate($year, $month, 1),
                'generacion_fecha' => now(),
            ]);
        }

        // Bonificación familiar
        $salarioMinimo = $this->liquidacionService->obtenerSalarioMinimo();
        $bonificacionConcepto = Concepto::where('nombre', 'Bonificación Familiar')->first();

        if ($bonificacionConcepto) {
            $empleados = User::with(['hijos', 'conceptos'])->where('aplica_bonificacion_familiar', true)->get();

            foreach ($empleados as $empleado) {
                $hijosMenores = $empleado->hijos->filter(function ($hijo) {
                    return Carbon::parse($hijo->fecha_nacimiento)->age < 18;
                });

                $salario = optional($empleado->conceptos->firstWhere('tipo_concepto', 'salario'))->valor ?? 0;

                if ($hijosMenores->count() > 0 && $salario < ($salarioMinimo * 3)) {
                    $bono = $hijosMenores->count() * ($salarioMinimo * 0.05);

                    Movimiento::create([
                        'empleado_id' => $empleado->id,
                        'concepto_id' => $bonificacionConcepto->id,
                        'monto' => $bono,
                        'validez_fecha' => Carbon::createFromDate($year, $month, 1),
                        'generacion_fecha' => now(),
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Movimientos generados correctamente.');
    }
}
