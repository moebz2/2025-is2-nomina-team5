<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LiquidacionCabecera;
use App\Models\Parametro;
use App\Models\User;

class LiquidacionController extends Controller
{
    public function tomarDatosGeneracion()
    {
        return view('liquidacion.tomarDatosGeneracion');
    }

    public function generarLiquidacion(Request $request)
    {
        $request->validate([
            'periodo' => 'required|date',
        ]);

        // crear liquidacion_cabecera

        $periodo = $request->input('periodo');

        $liquidacionCabecera = LiquidacionCabecera::create([
            'generacion_fecha' => now(),
            'estado' => 'pendiente',
            'aprobacion_fecha' => null,
            'periodo' => $periodo,
        ]);

        // traer usuarios estado 'contratado'

        $empleados = User::where('estado', 'contratado')
            ->with('cargos')
            ->get();

        dd($empleados);

        // Debe realizar el cálculo según la cantidad de hijos, salario del empleado, etc: Bonificación por hijo menor de 18 años, si el empleado gana menos de 3 salarios mínimos oficiales. El monto es el 5% del salario mínimo oficial por cada hijo menor de 18 años.

        $salarioMinimo = Parametro::where('nombre', Parametro::SALARIO_MINIMO)->first()->valor;

        if (empty($salarioMinimo)) {
            return redirect()->back()->withErrors(['error' => 'No se encontró el salario mínimo']);
        }

        $bonificacionPorHijo = 0.05;
    }
}
