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
        error_log('generarMovimientos.request: ' . json_encode($request->all()));

        $request->validate([
            'fecha' => 'nullable|date_format:Y-m-d',
        ]);

        $fecha = $request->input('fecha', Carbon::now()->format('Y-m-d'));
        $fechaCb = Carbon::parse($fecha)->startOfMonth();

        // Movimientos normales desde conceptos asociados a empleados

        $empleadoConceptos = EmpleadoConcepto::whereDate('fecha_inicio', '<=', $fechaCb)
            ->where(function ($query) use ($fechaCb) {
                $query->whereNull('fecha_fin')
                    ->orWhereDate('fecha_fin', '>=', $fechaCb);
            })->get();

        foreach ($empleadoConceptos as $empleadoConcepto) {
            Movimiento::create([
                'empleado_id' => $empleadoConcepto->empleado_id,
                'concepto_id' => $empleadoConcepto->concepto_id,
                'monto' => intval($empleadoConcepto->valor),
                'validez_fecha' => $fechaCb,
                'generacion_fecha' => now(),
            ]);
        }

        // Generar movimiento de bonificación familiar si corresponde

        $salarioMinimo = $this->liquidacionService->obtenerSalarioMinimo();
        $bonificacionConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_BONIFICACION)->first();
        $salarioConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

        error_log('generarMovimientos.salarioConceptoId: ' . $salarioConcepto->id);

        if ($bonificacionConcepto) {

            $empleados = User::with(['hijos', 'conceptos'])->where('estado', 'contratado')->orderBy('id', 'desc')->get();

            foreach ($empleados as $empleado) {

                $hijosMenores = $empleado->hijosMenores;

                if ($hijosMenores->count() == 0) {
                    continue;
                }

                error_log('generarMovimientos.empleadoId: ' . $empleado->id);
                error_log('generarMovimientos.empleadoNombre: ' . $empleado->nombre);

                $concepto_salario = $empleado->conceptos()->where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

                if (empty($concepto_salario)) {
                    error_log('No se encontró el salario para el empleado: ' . $empleado->id);
                    continue;
                }

                error_log('generarMovimientos.conceptoSalario: ' . var_export($concepto_salario, true));

                $salario = $concepto_salario->pivot->valor;

                error_log('generarMovimientos.salario: ' . $salario);
                error_log('generarMovimientos.salarioPorTres: ' . ($salarioMinimo * 3));
                error_log('generarMovimientos.hijosMenoresCount: ' . $hijosMenores->count());

                if ($hijosMenores->count() > 0 && $salario < ($salarioMinimo * 3)) {
                    $bono = $hijosMenores->count() * ($salarioMinimo * 0.05);

                    Movimiento::create([
                        'empleado_id' => $empleado->id,
                        'concepto_id' => $bonificacionConcepto->id,
                        'monto' => $bono,
                        'validez_fecha' => $fechaCb,
                        'generacion_fecha' => now(),
                    ]);
                }
            }
        }

        error_log('generarMovimientos.end');

        return redirect()->back()->with('success', 'Movimientos generados correctamente.');
    }
}
