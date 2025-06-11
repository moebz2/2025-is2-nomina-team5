<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\Movimiento;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Exceptions;

class DashboardController extends Controller


{
    protected $meses = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre','diciembre'];

    public function index()
    {

        // Usuarios
        $usuarios = User::where('estado', User::ESTADO_CONTRATADO)->orderBy('created_at', 'desc')->get();
        $vacaciones = User::where('estado', User::ESTADO_INACTIVO)->get();
        $despedidos = User::where('estado', User::ESTADO_DESPEDIDO)->get();
        $cargos = Cargo::with('usuarios')->get();

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $inicioAno = Carbon::now()->startOfYear();

        $departamentos = Departamento::all();

        //$periodo = Carbon::now()->format('Y-m');

        $liquidaciones_periodo = LiquidacionEmpleadoCabecera::whereBetween('periodo', [$inicioMes, $finMes])->with('detalles.movimiento.concepto')->get();

        $liquidacion_monto_mes = 0;

        foreach ($liquidaciones_periodo as $liquidacion) {
            foreach ($liquidacion->detalles as $detalle) {


                if ($detalle->movimiento->concepto->es_debito == 0) {

                    $liquidacion_monto_mes = $liquidacion_monto_mes + $detalle->movimiento->monto;
                }
            }
        }

        $periodos_conceptos = [];
        $fecha_periodo = Carbon::now();
        $mes_actual = $fecha_periodo->month;

        for($i = 0; $i < $mes_actual; $i++){

            $fecha_periodo->set('month', $i + 1);

            $periodos_conceptos[$fecha_periodo->format('Y-m')] = $this->meses[$i + 1];


        }

        array_reverse($periodos_conceptos);



        $liquidacion_monto_ano = 0;

        $liquidaciones = LiquidacionEmpleadoCabecera::whereBetween('periodo', [$inicioAno, $finMes])->with('detalles.movimiento.concepto')->get();

        foreach ($liquidaciones as $liquidacion) {
            foreach ($liquidacion->detalles as $detalle) {
                if ($detalle->movimiento->concepto->es_debito == 0) {
                    $liquidacion_monto_ano = $liquidacion_monto_ano + $detalle->movimiento->monto;
                }
            }
        }


        return view('dashboard.index', compact('usuarios', 'liquidaciones', 'liquidaciones_periodo',  'departamentos', 'cargos', 'vacaciones', 'despedidos', 'liquidacion_monto_mes', 'liquidacion_monto_ano', 'periodos_conceptos'));
    }


    // OK
    public function departamentosChartInfo(Request $request)
    {

        try {


            $departamentos = Departamento::all();

            /* GRAFICA DEPARTAMENTOS (ANILLO): CANTIDAD DE EMPLEADOS POR DEPARTAMENTOS */
            $departamentosChart = [['Departamento', 'Cantidad de Empleados']];

            foreach ($departamentos as $departamento) {
                // Contar empleados únicos por departamento
                // Se unen las tablas:
                // 1. 'cargos': para obtener los cargos de cada departamento.
                // 2. 'cargos_empleado': para obtener las asignaciones de empleados a esos cargos.
                // 3. Se filtra por asignaciones activas (fecha_fin es NULL o en el futuro).
                // 4. Se usa DISTINCT en empleado_id para contar empleados únicos.
                $count = DB::table('users')
                    ->join('cargos_empleado', 'users.id', '=', 'cargos_empleado.empleado_id')
                    ->join('cargos', 'cargos_empleado.cargo_id', '=', 'cargos.id')
                    ->where('cargos.departamento_id', $departamento->id)
                    ->where(function ($query) {
                        $query->whereNull('cargos_empleado.fecha_fin')
                            ->orWhere('cargos_empleado.fecha_fin', '>=', Carbon::today()->toDateString());
                    })
                    ->distinct('users.id')
                    ->count('users.id');

                $departamentosChart[] = [$departamento->nombre, $count];
            }

            return response()->json([
                'estado' => true,
                'datos' => $departamentosChart,
                'mensaje' => 'Exito'
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'estado' => false,
                'datos' => [],
                'mensaje' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function liquidacionesMensualesAno(Request $request)
    {
        try {
            /** GRAFICA DE LIQUIDACIONES: CREDITOS VS DEBITOS */

            $anho = Carbon::now()->year;
            $fecha_actual = Carbon::now();


            if($request->query('periodo')){


                $anho = intval($request->periodo);

            }




            $rawMonthlyData = LiquidacionEmpleadoCabecera::select(
                DB::raw("EXTRACT(MONTH FROM liquidaciones_empleado_cabecera.periodo) as month_number"),
                DB::raw("SUM(CASE WHEN conceptos.es_debito = FALSE THEN movimientos.monto ELSE 0 END) as total_creditos"),
                DB::raw("SUM(CASE WHEN conceptos.es_debito = TRUE THEN movimientos.monto ELSE 0 END) as total_debitos")
            )
                ->join('liquidacion_empleado_detalles', 'liquidaciones_empleado_cabecera.id', '=', 'liquidacion_empleado_detalles.cabecera_id')
                ->join('movimientos', 'liquidacion_empleado_detalles.movimiento_id', '=', 'movimientos.id')
                ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id') // Unir con la tabla conceptos
                ->whereYear('liquidaciones_empleado_cabecera.periodo', $anho)
                ->groupBy(DB::raw("EXTRACT(MONTH FROM liquidaciones_empleado_cabecera.periodo)"))
                ->orderBy(DB::raw("month_number"))
                ->get();


            $googleChartsData = [['Mes', 'Créditos', 'Débitos']];

            $monthNames = [
                1 => 'Ene',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Abr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Ago',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dic'
            ];


            $monthlyCredits = array_fill(1, 12, 0.0);
            $monthlyDebits = array_fill(1, 12, 0.0);


            foreach ($rawMonthlyData as $row) {
                $monthlyCredits[$row->month_number] = (float)$row->total_creditos;
                $monthlyDebits[$row->month_number] = (float)$row->total_debitos;
            }


            foreach ($monthNames as $monthNumber => $monthName) {

                if ($monthNumber > $fecha_actual->month && $anho == $fecha_actual->year) {
                    break;
                }
                $googleChartsData[] = [
                    $monthName,
                    $monthlyCredits[$monthNumber],
                    $monthlyDebits[$monthNumber]
                ];
            }

            return response()->json([
                'estado' => true,
                'datos' => $googleChartsData,
                'periodo' => $anho,
                'mensaje' => 'Exito'
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'estado' => false,
                'datos' => [],
                'mensaje' => 'Error: ' . $th->getMessage()
            ]);
        }
    }

    public function conceptosDebito(Request $request)
    {
        try {

            $periodo = Carbon::now()->startOfMonth();
            $periodo_anterior = Carbon::now()->subMonth()->startOfMonth();

            if($request->query('periodo')){

                $periodo = Carbon::parse($request->periodo);
                $periodo_anterior = Carbon::parse($request->periodo)->subMonth();

            }


            $currentMonthDebits = Movimiento::select(
                'conceptos.nombre as concepto_nombre',
                DB::raw('SUM(movimientos.monto) as total_monto_actual')
            )
                ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id')
                ->join('liquidacion_empleado_detalles', 'movimientos.id', '=', 'liquidacion_empleado_detalles.movimiento_id')
                ->join('liquidaciones_empleado_cabecera', 'liquidacion_empleado_detalles.cabecera_id', '=', 'liquidaciones_empleado_cabecera.id')
                ->where('conceptos.es_debito', true)
                ->whereYear('liquidaciones_empleado_cabecera.periodo', $periodo->year)
                ->whereMonth('liquidaciones_empleado_cabecera.periodo', $periodo->month)
                ->groupBy('conceptos.nombre')
                ->orderByDesc('total_monto_actual')
                ->limit(10)
                ->get()
                ->keyBy('concepto_nombre');

            $previousMonthDebitsRaw = Movimiento::select(
                'conceptos.nombre as concepto_nombre',
                DB::raw('SUM(movimientos.monto) as total_monto_anterior')
            )
                ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id')
                ->join('liquidacion_empleado_detalles', 'movimientos.id', '=', 'liquidacion_empleado_detalles.movimiento_id')
                ->join('liquidaciones_empleado_cabecera', 'liquidacion_empleado_detalles.cabecera_id', '=', 'liquidaciones_empleado_cabecera.id')
                ->where('conceptos.es_debito', true)
                ->whereYear('liquidaciones_empleado_cabecera.periodo', $periodo_anterior->year)
                ->whereMonth('liquidaciones_empleado_cabecera.periodo', $periodo_anterior->month)
                ->whereIn('conceptos.nombre', $currentMonthDebits->pluck('concepto_nombre')->toArray())
                ->groupBy('conceptos.nombre')
                ->get()
                ->keyBy('concepto_nombre'); // Indexar por nombre del concepto

            $graficoBarras = [[
                'Concepto',
                'Periodo (' . $periodo->isoFormat('MMM YY') . ')',
                'Periodo anterior (' . $periodo_anterior->isoFormat('MMM YY') . ')'
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

            return response()->json([
                'estado' => true,
                'datos' => $graficoBarras,
                'periodo' => $periodo->format('Y-m'),
                'periodo_anterior' => $periodo_anterior->format('Y-m'),
                'mensaje' => 'Exito: tu periodo es ' . $periodo->format('Y-m')
            ]);
        } catch (\Throwable $th) {

            return response()->json([
                'estado' => false,
                'datos' => [],
                'mensaje' => 'Error: ' . $th->getMessage()
            ], 500);
        }
    }
}
