<?php

namespace App\Http\Controllers;

use App\Models\LiquidacionCabecera;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

class ReporteTotalLiquidacionController extends Controller
{
    public function index(Request $request)
    {
        $report = $this->getReport($request);
        $vista = view('reportes.total-liquidacion', compact('report'));
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
            ->name('reporte-total-liquidacion.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) use ($nodePath, $npmPath) {
                $browsershot
                    ->setNodeBinary($nodePath)
                    ->setNpmBinary($npmPath)
                    ->setIncludePath(env('INCLUDE_PATH'));
            });
    }

    private function getReport($request)
    {
        $liquidaciones = LiquidacionCabecera::with(['empleados.detalles.movimiento.concepto', 'empleados.empleado'])->get();

        $report = $liquidaciones->map(function ($cabecera) {
            $total = 0;
            foreach ($cabecera->empleados as $empleadoCab) {
                foreach ($empleadoCab->detalles as $detalle) {
                    $monto = $detalle->movimiento->monto;
                    $isDebito = $detalle->movimiento->concepto->es_debito;
                    $total += $isDebito ? -$monto : $monto;
                }
            }
            return [
                'periodo' => $cabecera->periodo->format('Y/m'),
                'total' => $total,
            ];
        });

        $totalGeneral = $report->sum('total');

        return [
            'report' => $report,
            'totalGeneral' => $totalGeneral,
        ];
    }
}
