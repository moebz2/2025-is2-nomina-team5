<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        // Usuarios
        $usuarios = User::where('estado', User::ESTADO_CONTRATADO)->orderBy('created_at', 'desc')->get();
        $vacaciones = User::where('estado', User::ESTADO_INACTIVO)->get();
        $despedidos = User::where('estado', User::ESTADO_DESPEDIDO)->get();

        $inicioMes = Carbon::now()->startOfMonth();
        $finMes = Carbon::now()->endOfMonth();
        $inicioAno = Carbon::now()->startOfYear();


        $cargos = Cargo::with('usuarios')->get();

        $periodo = Carbon::now()->format('Y-m');

        $liquidaciones_periodo = LiquidacionEmpleadoCabecera::whereBetween('periodo', [$inicioMes, $finMes])->with('detalles.movimiento.concepto')->get();

        $liquidacion_monto_mes = 0;

        foreach ($liquidaciones_periodo as $liquidacion) {
            foreach ($liquidacion->detalles as $detalle) {


                if ($detalle->movimiento->concepto->es_debito == 0) {

                    $liquidacion_monto_mes = $liquidacion_monto_mes + $detalle->movimiento->monto;
                }
            }
        }

        $liquidacion_monto_ano = 0;

        $liquidaciones = LiquidacionEmpleadoCabecera::whereBetween('periodo', [$inicioAno, $finMes])->with('detalles.movimiento.concepto')->get();

        foreach ($liquidaciones as $liquidacion) {
            foreach ($liquidacion->detalles as $detalle) {
                if ($detalle->movimiento->concepto->es_debito == 0) {
                    $liquidacion_monto_ano = $liquidacion_monto_ano + $detalle->movimiento->monto;
                }
            }
        }

        /** GRAFICA DE LIQUIDACIONES: CREDITOS VS DEBITOS */

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $rawMonthlyData = LiquidacionEmpleadoCabecera::select(
            DB::raw("EXTRACT(MONTH FROM liquidaciones_empleado_cabecera.periodo) as month_number"),
            DB::raw("SUM(CASE WHEN conceptos.es_debito = FALSE THEN movimientos.monto ELSE 0 END) as total_creditos"),
            DB::raw("SUM(CASE WHEN conceptos.es_debito = TRUE THEN movimientos.monto ELSE 0 END) as total_debitos")
        )
            ->join('liquidacion_empleado_detalles', 'liquidaciones_empleado_cabecera.id', '=', 'liquidacion_empleado_detalles.cabecera_id')
            ->join('movimientos', 'liquidacion_empleado_detalles.movimiento_id', '=', 'movimientos.id')
            ->join('conceptos', 'movimientos.concepto_id', '=', 'conceptos.id') // Unir con la tabla conceptos
            ->whereYear('liquidaciones_empleado_cabecera.periodo', $currentYear)
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

            if ($monthNumber > 9) {
                break;
            }
            $googleChartsData[] = [
                $monthName,
                $monthlyCredits[$monthNumber],
                $monthlyDebits[$monthNumber]
            ];
        }

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

        return view('dashboard.index', compact('usuarios', 'liquidaciones', 'liquidaciones_periodo',  'departamentos', 'cargos', 'vacaciones', 'despedidos', 'liquidacion_monto_mes', 'liquidacion_monto_ano', 'googleChartsData', 'currentYear', 'departamentosChart'));
    }
}
