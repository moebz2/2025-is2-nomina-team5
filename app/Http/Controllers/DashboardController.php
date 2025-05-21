<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

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



        $departamentos = Departamento::all();

        return view('dashboard.index', compact('usuarios', 'liquidaciones', 'liquidaciones_periodo',  'departamentos', 'cargos', 'vacaciones', 'despedidos', 'liquidacion_monto_mes', 'liquidacion_monto_ano'));
    }
}
