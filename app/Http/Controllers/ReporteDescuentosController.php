<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use App\Models\Concepto;
use App\Models\LiquidacionEmpleadoDetalle;
use Illuminate\Http\Request;

class ReporteDescuentosController extends Controller
{
    public function index(Request $request)
    {
        // Trae todos los usuarios que podrían tener movimientos
        $empleados = Empleado::with('usuario')->get();

        // Solo conceptos de tipo débito
        $conceptos = Concepto::where('es_debito', true)->get();

        // Base query con relaciones necesarias
        $query = LiquidacionEmpleadoDetalle::with([
            'movimiento.concepto',
            'movimiento.empleado',
        ]);

        // Filtro por empleado
        if ($request->filled('empleado_id')) {
            $query->whereHas('movimiento.empleado', function ($q) use ($request) {
                $q->where('id', $request->empleado_id);
            });
        }

        // Filtro por concepto
        if ($request->filled('concepto_id')) {
            $query->whereHas('movimiento.concepto', function ($q) use ($request) {
                $q->where('id', $request->concepto_id);
            });
        }

        // Filtro por fechas
        if ($request->filled('fecha_desde')) {
            $query->whereDate('created_at', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('created_at', '<=', $request->fecha_hasta);
        }

        // Ejecutar consulta
        $resultados = $query->get();

        return view('reportes.descuentos', compact('empleados', 'conceptos', 'resultados'));
    }
}
