<?php

namespace App\Http\Controllers;

use App\Models\LiquidacionEmpleadoCabecera;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class ReporteLiqEmpleadoController extends Controller
{
    public function index(Request $request)
    {
        $report = $this->getReport($request);
        $vista =  view('reportes.liq-empleado', compact('report'));
        return view('reportes.index', ['content' => $vista]);
    }

    public function export(Request $request)
    {
        $nodePath = env('NODE_PATH', null);
        $npmPath = env('NPM_PATH', null);

        if ($nodePath == null || $npmPath == null) {
            return back()->withErrors('Asegurese de especificar en su archivo .env las rutas de NPM y NODE para generar el pdf');
        }

        $report = $this->getReport($request);

        return Pdf::view(
            'reportes.liq-empleado',
            [
                'report' => $report,
                'isExport' => true,
            ]
        )
            ->format('A4')
            ->name('liq-empleado.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) use ($nodePath, $npmPath) {
                $browsershot
                    ->setNodeBinary($nodePath)
                    ->setNpmBinary($npmPath)
                    ->setIncludePath(env('INCLUDE_PATH'));
            });
    }

    private function getReport($request)
    {
        $query = LiquidacionEmpleadoCabecera::with(['empleado', 'detalles.movimiento.concepto']);

        if ($request->filled('fecha_desde') || $request->filled('fecha_hasta')) {
            $query->whereBetween('periodo', [
                $request->input('fecha_desde', '1900-01-01'),
                $request->input('fecha_hasta', now()->format('Y-m-d')),
            ]);
        }

        $report = $query->get()->map(function ($cabecera) use ($request) {
            $netSum = $cabecera->detalles->reduce(function ($carry, $detalle) {
                $monto = $detalle->movimiento->monto;
                $isDebito = $detalle->movimiento->concepto->es_debito;

                return $carry + ($isDebito ? -$monto : $monto);
            }, 0);

            if ($request->filled('net_sum_min') && $netSum < $request->input('net_sum_min')) {
                return null;
            }
            if ($request->filled('net_sum_max') && $netSum > $request->input('net_sum_max')) {
                return null;
            }

            return [
                'periodo' => $cabecera->periodo->format('Y/m'),
                'empleado_nombre' => $cabecera->empleado->nombre,
                'net_sum' => $netSum,
            ];
        })->filter();

        return $report;
    }
}
