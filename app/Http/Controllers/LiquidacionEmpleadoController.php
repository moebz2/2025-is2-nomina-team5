<?php

namespace App\Http\Controllers;

use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;
use Illuminate\Http\Request;
use Spatie\Browsershot\Browsershot;
use Spatie\LaravelPdf\Facades\Pdf;

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

        $cabecera = LiquidacionEmpleadoCabecera::with('empleado')
            ->findOrFail($liquidacionEmpleadoId);
        $detalles = LiquidacionEmpleadoDetalle::where('cabecera_id', $liquidacionEmpleadoId)
            ->with(['cabecera', 'movimiento'])
            ->get();

        $creditos = [];
        $debitos = [];
        $totalCredito = 0;
        $totalDebito = 0;

        foreach ($detalles as $detalle) {
            $isDebito = $detalle->movimiento->concepto->es_debito;

            if ($isDebito) {
                array_push($debitos, $detalle);
                $totalDebito += $detalle->movimiento->monto;
            } else {
                array_push($creditos, $detalle);
                $totalCredito += $detalle->movimiento->monto;
            }
        }
        $empleadoNombre = $cabecera->empleado->nombre ?? 'N/A';

        return view('liquidacion-empleado.detalles-liquidacion', [
            'liquidacionEmpleadoId' => $liquidacionEmpleadoId,
            'detalles' => $detalles,
            'empleadoNombre' => $empleadoNombre,
            'periodo' => $cabecera->liquidacionCabecera->periodo,
            'cabecera' => $cabecera,
            'creditos' => $creditos,
            'debitos' => $debitos,
            'empleado' => $cabecera->empleado,
            'totalCredito' => $totalCredito,
            'totalDebito' => $totalDebito,
        ]);
    }

    public function export($liquidacionEmpleadoId)
    {

        $nodePath = env('NODE_PATH', null);
        $npmPath = env('NPM_PATH', null);

        if($nodePath == null || $npmPath == null){

            return back()->withErrors('Asegurese de  especificar en su ardchivo .env las rutas de NPM y NODE para general el pdf');


        }

        $cabecera = LiquidacionEmpleadoCabecera::with('empleado')
            ->findOrFail($liquidacionEmpleadoId);

        $detalles = LiquidacionEmpleadoDetalle::where('cabecera_id', $liquidacionEmpleadoId)

            ->with(['cabecera', 'movimiento'])
            ->get();

            $creditos = [];
            $debitos = [];
            $totalCredito = 0;
            $totalDebito = 0;
    
            foreach ($detalles as $detalle) {
                $isDebito = $detalle->movimiento->concepto->es_debito;
    
                if ($isDebito) {
                    array_push($debitos, $detalle);
                    $totalDebito += $detalle->movimiento->monto;
                } else {
                    array_push($creditos, $detalle);
                    $totalCredito += $detalle->movimiento->monto;
                }
            }

        $empleadoNombre = $cabecera->empleado->nombre ?? 'N/A';

        return Pdf::view('liquidacion-empleado.detalles-liquidacion', 
            ['detalles' => $detalles, 
            'isExport' => true, 
            'empleadoNombre' => $empleadoNombre, 
            'periodo' => $cabecera->liquidacionCabecera->periodo,
            'cabecera' => $cabecera,
            'creditos' => $creditos,
            'debitos' => $debitos,
            'empleado' => $cabecera->empleado,
            'totalCredito' => $totalCredito,
            'totalDebito' => $totalDebito,
            
            
            ])
            ->format('A4')
            ->name('document.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) use ($nodePath, $npmPath) {
                $browsershot
                    ->setNodeBinary($nodePath)
                    ->setNpmBinary($npmPath)
                    ->setIncludePath(env('INCLUDE_PATH'));
            });
    }
}
