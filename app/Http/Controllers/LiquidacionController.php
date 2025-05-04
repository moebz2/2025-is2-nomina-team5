<?php

namespace App\Http\Controllers;

use App\Models\Concepto;
use Illuminate\Http\Request;
use App\Models\LiquidacionCabecera;
use App\Models\LiquidacionEmpleadoCabecera;
use App\Models\LiquidacionEmpleadoDetalle;
use App\Models\Movimiento;
use App\Models\Parametro;
use App\Models\User;
use App\Services\LiquidacionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LiquidacionController extends Controller
{
    protected $liquidacionService;

    public function __construct(LiquidacionService $liquidacionService)
    {
        $this->liquidacionService = $liquidacionService;
    }

    public function index()
    {
        $liquidaciones = LiquidacionCabecera::orderBy('periodo', 'desc')
            ->get();

        return view('liquidacion.index', compact('liquidaciones'));
    }

    public function showFormGenerar()
    {
        return view('liquidacion.generar-liquidacion');
    }

    public function generar(Request $request)
    {
        $request->validate([
            'periodo' => 'required|date',
        ]);


        $periodo = Carbon::parse($request->input('periodo'))->format('Y-m');

        try {
            $this->liquidacionService->generarLiquidacion($periodo);

            return redirect()->route('liquidacion.index')->with('success', 'Liquidación generada correctamente');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // No sé si va a ser útil después, esto es para poder probar
    // fácilmente nomás.
    public function eliminarGenerados(Request $request)
    {
        $request->validate([
            'periodo' => 'required|date',
        ]);



        $periodo = Carbon::parse($request->input('periodo'))->format('Y-m');

        DB::transaction(function () use ($periodo) {
            // Find the liquidation header for the given period
            $liquidacionCabecera = LiquidacionCabecera::where('periodo', $periodo . '-01')->first();

            if (!$liquidacionCabecera) {
                return redirect()->back()->withErrors(['error' => 'No se encontró la liquidación para el período especificado.']);
            }

            // Delete LiquidacionEmpleadoDetalle records
            LiquidacionEmpleadoDetalle::whereHas('cabecera', function ($query) use ($liquidacionCabecera) {
                $query->where('liquidacion_cabecera_id', $liquidacionCabecera->id);
            })->delete();

            // Delete Movimiento records
            Movimiento::where('validez_fecha', '>=', date_create($periodo . '-01')->format('Y-m-d'))
                ->where('validez_fecha', '<', date_create($periodo . '-01')->modify('first day of next month')->format('Y-m-d'))
                ->delete();

            // Delete LiquidacionEmpleadoCabecera records
            LiquidacionEmpleadoCabecera::where('liquidacion_cabecera_id', $liquidacionCabecera->id)->delete();

            // Delete LiquidacionCabecera record
            $liquidacionCabecera->delete();
        });

        return redirect()->route('liquidacion.index')->with('success', 'Registros eliminados correctamente.');
    }

    public function eliminarTodos(Request $request)
    {
        try{

            $liquidaciones = LiquidacionCabecera::all();

            foreach ($liquidaciones as $liquidacion) {
                $liquidacion->delete();
            }

            return redirect()->route('liquidacion.index')->with('success', 'Todos los registros eliminados correctamente.');

        }catch(Exception $e){

            dd($e->getMessage());
            // return redirect()->route('liquidacion.index')->with('error', $e->getMessage());

        }
    }
}
