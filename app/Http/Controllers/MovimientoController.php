<?php

namespace App\Http\Controllers;

use App\Models\EmpleadoConcepto;
use App\Models\Movimiento;
use App\Models\Concepto;
use App\Models\Prestamo;
use App\Models\User;
use App\Services\LiquidacionService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    protected $liquidacionService;



    public function __construct(LiquidacionService $liquidacionService)
    {
        $this->liquidacionService = $liquidacionService;

        $this->middleware('can:movimiento ver')->only('index');
        $this->middleware('can:movimiento crear')->only('create', 'store');
        $this->middleware('can:movimiento editar')->only('edit', 'update');
        $this->middleware('can:movimiento eliminar')->only('destroy');

    }

    public function generarMovimientos(Request $request)
    {
        error_log('generarMovimientos.request: ' . json_encode($request->all()));

        $request->validate([
            'fecha' => 'nullable|date_format:Y-m-d',
        ]);

        $fecha = $request->input('fecha', Carbon::now()->format('Y-m-d'));
        $fechaCb = Carbon::parse($fecha)->startOfMonth();

        // Generar movimientos en base a conceptos asociados a empleados

        $empleadoConceptos = EmpleadoConcepto::whereDate('fecha_inicio', '<=', $fechaCb)
            ->where(function ($query) use ($fechaCb) {
                $query->whereNull('fecha_fin')
                    ->orWhereDate('fecha_fin', '>=', $fechaCb);
            })->get();

        foreach ($empleadoConceptos as $empleadoConcepto) {
            Movimiento::create([
                'empleado_id' => $empleadoConcepto->empleado_id,
                'concepto_id' => $empleadoConcepto->concepto_id,
                'monto' => intval($empleadoConcepto->valor),
                'validez_fecha' => $fechaCb,
                'generacion_fecha' => now(),
            ]);
        }

        // Generar movimiento de bonificación familiar si corresponde

        $salarioMinimo = $this->liquidacionService->obtenerSalarioMinimo();
        $bonificacionConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_BONIFICACION)->first();
        $salarioConcepto = Concepto::where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

        error_log('generarMovimientos.salarioConceptoId: ' . $salarioConcepto->id);

        if ($bonificacionConcepto) {

            $empleados = User::with(['hijos', 'conceptos'])->where('estado', 'contratado')->orderBy('id', 'desc')->get();

            foreach ($empleados as $empleado) {

                $hijosMenores = $empleado->hijosMenores;

                if ($hijosMenores->count() == 0) {
                    continue;
                }

                error_log('generarMovimientos.empleadoId: ' . $empleado->id);
                error_log('generarMovimientos.empleadoNombre: ' . $empleado->nombre);

                $concepto_salario = $empleado->conceptos()->where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

                if (empty($concepto_salario)) {
                    error_log('No se encontró el salario para el empleado: ' . $empleado->id);
                    continue;
                }

                error_log('generarMovimientos.conceptoSalario: ' . var_export($concepto_salario, true));

                $salario = $concepto_salario->pivot->valor;

                error_log('generarMovimientos.salario: ' . $salario);
                error_log('generarMovimientos.salarioPorTres: ' . ($salarioMinimo * 3));
                error_log('generarMovimientos.hijosMenoresCount: ' . $hijosMenores->count());

                if ($hijosMenores->count() > 0 && $salario < ($salarioMinimo * 3)) {
                    $bono = $hijosMenores->count() * ($salarioMinimo * 0.05);

                    Movimiento::create([
                        'empleado_id' => $empleado->id,
                        'concepto_id' => $bonificacionConcepto->id,
                        'monto' => intval($bono),
                        'validez_fecha' => $fechaCb,
                        'generacion_fecha' => now(),
                    ]);
                }
            }
        }

        // Generar cuota de préstamos si corresponde

        $prestamoService = new \App\Services\PrestamoService();
        $prestamoService->generarCuotas($fechaCb);

        error_log('generarMovimientos.end');

        return redirect()->back()->with('success', 'Movimientos generados correctamente.');
    }

    public function index(Request $request)
    {

        $empleados = User::all();
        $conceptos = Concepto::all();

        $conceptos_create = Concepto::where('es_modificable', true)->get();




        $query = Movimiento::with(['empleado', 'concepto']);

        // FILTRAMOS USUARIO
        if ($request->filled('empleado_id')) {
            $query->whereHas('empleado', function ($q) use ($request) {
                $q->where('id', $request->empleado_id);
            });
        }

        // FILTRAMOS CONCEPTO
        if ($request->filled('concepto_id')) {
            $query->whereHas('concepto', function ($q) use ($request) {
                $q->where('id', $request->concepto_id);
            });
        }

        // FILTRAMOS CREDITO | DEBITO
        if ($request->filled('es_debito')) {
            $query->whereHas('concepto', function ($q) use ($request) {

                $q->where('es_debito', boolval($request->es_debito));
            });
        }

         if ($request->filled('fecha_desde') || $request->filled('fecha_hasta')) {

                if ($request->filled('fecha_desde')) {
                    $query->whereDate('validez_fecha', '>=', $request->fecha_desde);
                }
                if ($request->filled('fecha_hasta')) {
                    $query->whereDate('validez_fecha', '<=', $request->fecha_hasta);
                }

        }

        $movimientos = $query->orderBy('generacion_fecha', 'desc')->paginate(perPage: $request->input('paginate', 10));

        return view('movimientos.index', compact('movimientos', 'empleados', 'conceptos', 'conceptos_create'));

    }

    public function store(Request $request)
    {

        try {

            $request->validate([
                'create_empleado_id' => 'required|exists:users,id',
                'create_concepto_id' => 'required|exists:conceptos,id',
                'create_monto' => 'required|numeric',
                'create_validez_fecha' => 'required|date',

            ]);

            $periodo = Carbon::parse($request->create_validez_fecha)->format('Y-m');

            [$year, $month] = explode('-', $periodo);

            Movimiento::create([
                'empleado_id' => $request->create_empleado_id,
                'concepto_id' => $request->create_concepto_id,
                'monto' => $request->create_monto,
                'validez_fecha' => Carbon::createFromDate($year, $month, 1),
                'generacion_fecha' => now(),
            ]);

            return redirect()->route('movimiento.index')->with('success', 'Movimiento registrado correctamente')->with('mode_create', true);
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }

}
