<?php

namespace App\Http\Controllers;

use App\Models\LiquidacionEmpleadoCabecera;
use Illuminate\Http\Request;

class LiquidacionEmpleadoController extends Controller
{
    public function index(Request $request, $liquidacionId)
    {
        $liquidacionEmpleados = LiquidacionEmpleadoCabecera::where('liquidacion_cabecera_id', $liquidacionId)
            ->with(['empleado', 'liquidacionCabecera'])
            ->get();

        return view('liquidacion-empleado.index', compact('liquidacionEmpleados'));
    }

    public function show($liquidacionEmpleadoId)
    {
        $detalles = \App\Models\LiquidacionEmpleadoDetalle::where('cabecera_id', $liquidacionEmpleadoId)
            ->with(['cabecera', 'movimiento'])
            ->get();

        return view('liquidacion-empleado.detalles', compact('detalles'));
    }
}
