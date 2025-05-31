<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class ReporteSumConceptosController extends Controller
{
    public function index(Request $request)
    {
        $data = $this->getData($request);
        return view('reportes.sum-conceptos', $data);
    }

    public function export(Request $request)
    {
        $nodePath = env('NODE_PATH', null);
        $npmPath = env('NPM_PATH', null);

        if ($nodePath == null || $npmPath == null) {
            return back()->withErrors('Asegurese de especificar en su archivo .env las rutas de NPM y NODE para generar el pdf');
        }

        $data = $this->getData($request);
        $data['isExport'] = true;

        return Pdf::view('reportes.sum-conceptos', $data)
            ->format('A4')
            ->name('reporte-sum-conceptos.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) use ($nodePath, $npmPath) {
                $browsershot
                    ->setNodeBinary($nodePath)
                    ->setNpmBinary($npmPath)
                    ->setIncludePath(env('INCLUDE_PATH'));
            });
    }

    private function getData(Request $request)
    {
        $limiteInferior = $request->input('sumatoria_limite_inferior') ?? 0;
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');
        $conceptoId = $request->input('concepto_id');

        $sql = "
            SELECT u.id AS empleado_id, u.nombre AS empleado_nombre, SUM(m.monto) AS total
            FROM users u
            JOIN movimientos m ON u.id = m.empleado_id
            JOIN liquidacion_empleado_detalles led ON m.id = led.movimiento_id
            WHERE 1=1
        ";

        $params = [];

        if ($fechaDesde) {
            $sql .= " AND m.validez_fecha >= :fecha_desde";
            $params['fecha_desde'] = $fechaDesde;
        }

        if ($fechaHasta) {
            $sql .= " AND m.validez_fecha <= :fecha_hasta";
            $params['fecha_hasta'] = $fechaHasta;
        }

        if ($conceptoId) {
            $sql .= " AND m.concepto_id = :concepto_id";
            $params['concepto_id'] = $conceptoId;
        }

        $sql .= "
            GROUP BY u.id, u.nombre
            HAVING SUM(m.monto) >= :sumatoria_limite_inferior
        ";
        $params['sumatoria_limite_inferior'] = $limiteInferior;

        $empleados = DB::select($sql, $params);

        $debugSql = $sql;
        foreach ($params as $key => $value) {
            $debugSql = str_replace(":$key", is_numeric($value) ? $value : "'$value'", $debugSql);
        }

        // Print the SQL with actual values
        error_log('SQL with parameters: ' . $debugSql);

        $conceptos = Concepto::all();

        return [
            'empleados' => $empleados,
            'limiteInferior' => $limiteInferior,
            'fechaDesde' => $fechaDesde,
            'fechaHasta' => $fechaHasta,
            'conceptoId' => $conceptoId,
            'conceptos' => $conceptos,
        ];
    }
}
