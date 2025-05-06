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

        $cabecera = \App\Models\LiquidacionEmpleadoCabecera::with('empleado')
            ->findOrFail($liquidacionEmpleadoId);
        $detalles = \App\Models\LiquidacionEmpleadoDetalle::where('cabecera_id', $liquidacionEmpleadoId)
            ->with(['cabecera', 'movimiento'])
            ->get();
        $empleadoNombre = $cabecera->empleado->nombre ?? 'N/A';

        return view('liquidacion-empleado.detalles', [
            'liquidacionEmpleadoId' => $liquidacionEmpleadoId,
            'detalles' => $detalles,
            'empleadoNombre' => $empleadoNombre,
            'periodo' => $cabecera->liquidacionCabecera->periodo
        ]);
    }

    public function export($liquidacionEmpleadoId)
    {

        $nodePath = '/home/userubu/.nvm/versions/node/v20.18.1/bin/node';
        $npmPath = '/home/userubu/.nvm/versions/node/v20.18.1/bin/npm';

        $cabecera = \App\Models\LiquidacionEmpleadoCabecera::with('empleado')
            ->findOrFail($liquidacionEmpleadoId);

        $detalles = \App\Models\LiquidacionEmpleadoDetalle::where('cabecera_id', $liquidacionEmpleadoId)

            ->with(['cabecera', 'movimiento'])
            ->get();

        $empleadoNombre = $cabecera->empleado->nombre ?? 'N/A';

        return Pdf::view('liquidacion-empleado.detalles', ['detalles' => $detalles, 'isExport' => true, 'empleadoNombre' => $empleadoNombre, 'periodo' => $cabecera->liquidacionCabecera->periodo])
            ->format('A4')
            ->name('document.pdf')
            ->withBrowsershot(function (Browsershot $browsershot) use ($nodePath, $npmPath) {
                $browsershot
                    ->setNodeBinary($nodePath)
                    ->setNpmBinary($npmPath)
                    ->setIncludePath('$PATH:/home/userubu/.nvm/versions/node/v20.18.1/bin');
            });
    }
}
