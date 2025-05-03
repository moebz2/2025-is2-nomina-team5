<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmpleadoConcepto;
use App\Models\Movimiento;
use Carbon\Carbon;

class MovimientoController extends Controller
{
    public function generarMovimientos(Request $request)
    {
        $request->validate([
            'periodo' => 'nullable|date_format:Y-m',
        ]);

        $periodo = $request->input('periodo', Carbon::now()->format('Y-m'));

        [$year, $month] = explode('-', $periodo);

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
                'monto' => intval($empleadoConcepto->valor) ,
                'validez_fecha' => Carbon::createFromDate($year, $month, 1),
                'generacion_fecha' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Movimientos generados correctamente.');
    }
}