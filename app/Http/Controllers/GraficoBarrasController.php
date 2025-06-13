<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class GraficoBarrasController
{
  public function index(\Illuminate\Http\Request $request)
  {
    $currentMonthStart = $request->query('month1');
    $currentMonthStart = \Carbon\Carbon::parse($currentMonthStart);

    $previousMonth = $request->query('month2');
    $previousMonth = \Carbon\Carbon::parse($previousMonth);

    // 1. Obtener los 10 principales débitos del mes actual, ordenados por magnitud
    $currentMonthDebits = Movimiento::select(
      'conceptos.nombre as concepto_nombre',
      DB::raw('SUM(movimientos.monto) as total_monto_actual')
    )
      ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id')
      ->join('liquidacion_empleado_detalles', 'movimientos.id', '=', 'liquidacion_empleado_detalles.movimiento_id')
      ->join('liquidaciones_empleado_cabecera', 'liquidacion_empleado_detalles.cabecera_id', '=', 'liquidaciones_empleado_cabecera.id')
      ->where('conceptos.es_debito', true) // Filtrar solo conceptos de débito
      ->whereYear('liquidaciones_empleado_cabecera.periodo', $currentMonthStart->year)
      ->whereMonth('liquidaciones_empleado_cabecera.periodo', $currentMonthStart->month)
      ->groupBy('conceptos.nombre')
      ->orderByDesc('total_monto_actual') // Ordenar de mayor a menor monto
      ->limit(10) // Limitar a los 10 primeros
      ->get()
      ->keyBy('concepto_nombre'); // Indexar por nombre del concepto para facilitar la combinación

    // 2. Obtener los montos de los mismos conceptos (los del top 10 del mes actual) para el mes anterior
    $previousMonthDebitsRaw = Movimiento::select(
      'conceptos.nombre as concepto_nombre',
      DB::raw('SUM(movimientos.monto) as total_monto_anterior')
    )
      ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id')
      ->join('liquidacion_empleado_detalles', 'movimientos.id', '=', 'liquidacion_empleado_detalles.movimiento_id')
      ->join('liquidaciones_empleado_cabecera', 'liquidacion_empleado_detalles.cabecera_id', '=', 'liquidaciones_empleado_cabecera.id')
      ->where('conceptos.es_debito', true)
      ->whereYear('liquidaciones_empleado_cabecera.periodo', $previousMonth->year)
      ->whereMonth('liquidaciones_empleado_cabecera.periodo', $previousMonth->month)
      // Asegurarse de obtener solo los conceptos que están en el top 10 del mes actual
      ->whereIn('conceptos.nombre', $currentMonthDebits->pluck('concepto_nombre')->toArray())
      ->groupBy('conceptos.nombre')
      ->get()
      ->keyBy('concepto_nombre'); // Indexar por nombre del concepto

    // 3. Preparar los datos para Google Charts
    // Encabezado: ['Concepto', 'Mes Actual', 'Mes Anterior']
    $graficoBarras = [[
      'Concepto',
      \Illuminate\Support\Str::ucfirst($currentMonthStart->locale('es')->translatedFormat('F/Y')),
      \Illuminate\Support\Str::ucfirst($previousMonth->locale('es')->translatedFormat('F/Y'))
    ]];

    // Combinar los datos de ambos meses y añadir a $graficoBarras
    foreach ($currentMonthDebits as $conceptoNombre => $currentData) {
      $montoActual = (float) $currentData->total_monto_actual;
      $montoAnterior = 0;

      // Si el concepto existe en los datos del mes anterior, usar su monto
      if ($previousMonthDebitsRaw->has($conceptoNombre)) {
        $montoAnterior = (float) $previousMonthDebitsRaw[$conceptoNombre]->total_monto_anterior;
      }

      $graficoBarras[] = [$conceptoNombre, $montoActual, $montoAnterior];
    }

    return response()->json($graficoBarras);
  }
}
