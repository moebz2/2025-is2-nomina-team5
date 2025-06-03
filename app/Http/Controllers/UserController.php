<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Concepto;
use App\Models\EmpleadoConcepto;
use App\Models\Movimiento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Carbon\Carbon;
use Exception;
use Spatie\Permission\Models\Role;
use App\Models\Hijo;
use App\Models\Parametro;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:usuario ver')->only('index');
        $this->middleware('can:usuario crear')->only('create', 'store');
        $this->middleware('can:usuario editar')->only('edit', 'update');
        $this->middleware('can:usuario eliminar')->only('destroy');
    }

    public function index()
    {
        $users = User::with(['cargos', 'hijos'])->paginate(10);


        // var_export(json_encode($users));
        // dd();

        return view('users.index', compact('users'));
    }

    public function create()
    {

        $roles = Role::all();
        $cargos = Cargo::all();

        return view('users.create', compact('cargos', 'roles'));
    }

    public function show(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $tab = $request->query('pestana') ??  'liquidaciones';


        // 2. Obtener el parámetro 'periodo' de la URL (si existe)
        $monthName = ['', 'enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre'];
        $periodoNombreMes = $request->query('periodo') ?? $monthName[Carbon::now()->month];
        $mesFiltro = null;
        $anoFiltro = Carbon::now()->year;


        $monthMap = [
            'enero'      => 1, 'febrero' => 2, 'marzo'   => 3, 'abril'   => 4,
            'mayo'       => 5, 'junio'   => 6, 'julio'   => 7, 'agosto'  => 8,
            'septiembre' => 9, 'octubre' => 10, 'noviembre' => 11, 'diciembre' => 12
        ];


        // 3. Determinar el mes y año para el filtro
        if ($periodoNombreMes) {
            // Intentar parsear como nombre de mes
            $lowerCasePeriodo = mb_strtolower($periodoNombreMes);
            if (isset($monthMap[$lowerCasePeriodo])) {
                $mesFiltro = $monthMap[$lowerCasePeriodo];
            } elseif (is_numeric($periodoNombreMes) && $periodoNombreMes >= 1 && $periodoNombreMes <= 12) {
                // Si el 'periodo' viene como número de mes (ej: /?periodo=5)
                $mesFiltro = (int)$periodoNombreMes;

            }
            // Opcional: parámetro de año (ej: /?periodo=5&anio=2024)
            // $anoParam = $request->query('anio');
            // if ($anoParam && is_numeric($anoParam)) {
            //     $anoFiltro = (int)$anoParam;
            // }
        }


        $movimientosQuery = $user->movimientos(); // Esto asume que tienes una relación 'movimientos' en tu modelo User

        // Aplicar el filtro de mes y año si se especificó
        if ($mesFiltro) {
            // Ahora podemos filtrar directamente por la columna 'validez_fecha' de la tabla 'movimientos'
            $movimientosQuery->whereYear('validez_fecha', $anoFiltro)
                             ->whereMonth('validez_fecha', $mesFiltro);
        }

        // 5. Obtener los movimientos finales (puedes añadir paginación si hay muchos)
        $movimientos = $movimientosQuery
                            ->whereNull('eliminacion_fecha')
                            ->orderBy('validez_fecha', 'desc')
                            ->get();




        $cargo = $user->currentCargo();
        $conceptos = Concepto::where('es_modificable', true)->get();
        $liquidaciones = $user->liquidaciones;
        $salario = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_SALARIO)->first();
        $bonificacion = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_BONIFICACION)->first();
        $ips = Concepto::IPS_PORCENTAJE;

        $salario_minimo = Parametro::where('nombre', Parametro::SALARIO_MINIMO)->first();


        return view('users.show', compact('user', 'cargo', 'conceptos', 'movimientos', 'liquidaciones', 'ips', 'salario', 'bonificacion', 'salario_minimo', 'tab', 'monthMap', 'periodoNombreMes'));
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|integer|unique:users',
            'sexo' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nacimiento_fecha' => 'required|date',
            'ingreso_fecha' => 'nullable|date',
            'cargo_id' => 'required|exists:cargos,id',
            'domicilio' => 'nullable|string|max:255',
        ]);


        DB::transaction(function () use ($request) {
            $usuario = User::create([
                'nombre' => strip_tags($request->nombre),
                'cedula' => strip_tags($request->cedula),
                'sexo' => strip_tags($request->sexo),
                'email' => strip_tags($request->email),
                'password' => Hash::make($request->password),
                'nacimiento_fecha' => $request->nacimiento_fecha,
                'domicilio' => strip_tags($request->domicilio),
            ]);
            // syncRoles = Reemplazar rol actual, no agregar
            $usuario->syncRoles($request->role);

            /*  if ($request->has('aplica_bonificacion_familiar')) {
                if ($request->has('hijos') && is_array($request->hijos)) {
                    foreach ($request->hijos as $hijoData) {
                        if (!empty($hijoData['nombre']) && !empty($hijoData['fecha_nacimiento'])) {
                            $usuario->hijos()->create($hijoData);
                        }
                    }
                }
            } else {
                $usuario->hijos()->delete(); // por si viene algo indebido
            } */

            if (isset($request->cargo_id)) {
                if (!isset($request->ingreso_fecha)) {
                    $request->ingreso_fecha = Carbon::now();
                }

                $cargo = Cargo::findOrFail($request->cargo_id);

                $usuario->asignarCargo($cargo->id, $request->ingreso_fecha);
            }
        });

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente');
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::with(['cargos', 'hijos'])->findOrFail($id);

        $fecha_nacimiento = Carbon::parse($user->nacimiento_fecha)->format('Y-m-d');
        $cargos = Cargo::all();



        return view('users.edit', compact('user', 'cargos', 'roles'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|integer|unique:users,cedula,' . $id,
            'sexo' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'nacimiento_fecha' => 'required|date',
            'ingreso_fecha' => 'required|date',
            'domicilio' => 'nullable|string|max:255',
            'cargo_id' => 'required|exists:cargos,id',
            'role' => 'required',
            'hijos.*.nombre' => 'nullable|string|max:255',
            'hijos.*.fecha_nacimiento' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $id) {
            $user = User::findOrFail($id);
            $user->update([
                'nombre' => strip_tags($request->nombre),
                'cedula' => strip_tags($request->cedula),
                'sexo' => strip_tags($request->sexo),
                'email' => strip_tags($request->email),
                'password' => $request->password ? Hash::make($request->password) : $user->password,
                'nacimiento_fecha' => $request->nacimiento_fecha,
                'domicilio' => strip_tags($request->domicilio),
                // 'aplica_bonificacion_familiar' => $request->has('aplica_bonificacion_familiar'),
            ]);

            $user->syncRoles($request->role);

            $cargo = Cargo::findOrFail($request->cargo_id);

            $cargo_actual = $user->currentCargo();

            // Solamente intentar asignar cargo si el cargo es diferente al actual
            if ($cargo_actual && $cargo_actual->id != $cargo->id) {

                $user->asignarCargo($cargo->id, $request->ingreso_fecha);

                $cargo_actual->update(['fecha_fin' => $request->ingreso_fecha]);

            }

            if(!$cargo_actual){

                $user->asignarCargo($cargo->id, $request->ingreso_fecha);

            }


        });

        return redirect()->route('users.index')->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        DB::transaction(function () use ($user) {
            $user->update(['estado' => 'baja']);
            // TODO: setear fecha de baja en cargo_empleado
        });

        return redirect()->route('users.index')->with('success', 'Usuario dado de baja correctamente');
    }

    public function setInactive($id)
    {
        $user = User::findOrFail($id);
        $user->update(['estado' => 'inactivo']);

        return redirect()->route('users.index')->with('success', 'Usuario marcado como inactivo correctamente');
    }

    public function asignarConcepto(Request $request, $id)
    {
        try {

            $request->validate([
                'empleado_id' => 'required|exists:users,id',
                'concepto_id' => 'required|exists:conceptos,id',
                'valor' => 'required|numeric',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date'
            ]);

            $concepto = Concepto::findOrFail($request->concepto_id);
            $user = User::findOrFail($id);

            if (strcmp($concepto->tipo_concepto, Concepto::TIPO_BONIFICACION) === 0) {

                if ($user->hijos === 0) {
                    throw new Exception('El empleado no tiene hijos');
                }
            }

            EmpleadoConcepto::create($request->all());

            return redirect()->route('users.show', [$id, 'pestana' => 'conceptos'])->with('success', 'Concepto asignado correctamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    public function registrarMovimiento(Request $request, $id)
    {

        try {

            $request->validate([
                'empleado_id' => 'required|exists:users,id',
                'concepto_id' => 'required|exists:conceptos,id',
                'monto' => 'required|numeric',
                'validez_fecha' => 'required|date',

            ]);

            $periodo = Carbon::parse($request->validez_fecha)->format('Y-m');

            [$year, $month] = explode('-', $periodo);

            $data = $request->all();

            $data['generacion_fecha'] = now();
            $data['validez_fecha'] = Carbon::createFromDate($year, $month, 1);



            Movimiento::create($data);

            return redirect()->route('users.show', [$id, 'pestana' => 'movimientos'])->with('success', 'Movimiento registrado correctamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function eliminarConcepto(Request $request, User $user,  $concepto)
    {
        try {


            $user->conceptos()->detach($concepto);





            return redirect()->route('users.show', $user->id)->with('success', 'Concepto eliminado correctamente');
        } catch (Exception $e) {

            dd($e->getMessage());
        }
    }

    // Hijos

    public function agregarHijo(Request $request, $id)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'fecha_nacimiento' => 'required|date',
        ]);

        try {

            $user = User::findOrFail($id);

            $user->hijos()->create($request->all());

            return redirect()->route('users.show', [$id, 'pestana' => 'hijos'])->with('success', 'Hijo creado correctamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function asignarSalario(Request $request, $id)
    {

        $request->validate([
            'empleado_id' => 'required|exists:users,id',
            'valor' => 'required|numeric|min:1',

        ]);

        try {

            $user = User::findOrFail($id);

            $salario = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

            if (isset($salario)) {

                $salario->estado = false;
                $salario->fecha_fin = now();
                $salario->save();


            }

            $concepto_salario = Concepto::where('tipo_concepto', Concepto::TIPO_SALARIO)->first();

            EmpleadoConcepto::create([
                'empleado_id' => $user->id,
                'concepto_id' => $concepto_salario->id,
                'valor' => $request->valor,
                'fecha_inicio' => now(),
                'estado' => true,
            ]);

            return redirect()->route('users.show', $id)->with('success', 'Salario asignado correctamente');

        } catch (Exception $e) {

            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function cambiarEstado (Request $request, $id){


        $request->validate([
            'empleado_id' => 'required|exists:users,id',
            'estado' => Rule::in(['contratado', 'baja', 'inactivo']),

        ]);

        try{

            $usuario = User::findOrFail($id);
            $usuario->update(['estado' => $request->estado]);

            return redirect()->route('users.index')->with('success', 'Estado actualizado correctamente');




        }catch(Exception $e){

            return redirect()->back()->with(['error' => $e->getMessage()]);

        }

    }
}
