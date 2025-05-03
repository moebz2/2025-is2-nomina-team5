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
        $users = User::with('cargos')->paginate(10);

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

    public function show($id){
        $user = User::findOrFail($id);
        $cargo = $user->currentCargo();
        $movimientos = $user->movimientos;
        $conceptos = Concepto::all();
        $liquidaciones = $user->liquidaciones;
        $salario = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_SALARIO)->first();
        $bonificacion = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_BONIFICACION)->first();
        $ips = $user->conceptos()->where('tipo_concepto', Concepto::TIPO_IPS)->first();


        return view('users.show', compact('user', 'cargo', 'conceptos', 'movimientos', 'liquidaciones', 'ips', 'salario', 'bonificacion'));
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
                // 'fecha_ingreso' => $request->ingreso_fecha,
                'domicilio' => strip_tags($request->domicilio),
            ]);

            // syncRoles = Reemplazar rol actual, no agregar
            $usuario->syncRoles($request->role);

            if (isset($request->cargo_id)) {
                if (!isset($request->ingreso_fecha)) {
                    $request->ingreso_fecha = Carbon::now();
                }

                $cargo = Cargo::findOrFail($request->cargo_id);

                $usuario->asignarCargo($cargo->id, $request->ingreso_fecha);
            }
        });

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
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
            ]);

            $user->syncRoles($request->role);

            $cargo = Cargo::findOrFail($request->cargo_id);

            // Solamente intentar asignar cargo si el cargo es diferente al actual
            if (!$user->cargos()->where('cargo_id', $cargo->id)->exists()) {
                $user->asignarCargo($cargo->id, $request->ingreso_fecha);
            }
        });

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        DB::transaction(function () use ($user) {
            $user->update(['estado' => 'baja']);
            // TODO: setear fecha de baja en cargo_empleado
        });

        return redirect()->route('users.index')->with('success', 'Usuario dado de baja exitosamente');
    }

    public function setInactive($id)
    {
        $user = User::findOrFail($id);
        $user->update(['estado' => 'inactivo']);

        return redirect()->route('users.index')->with('success', 'Usuario marcado como inactivo exitosamente');
    }

    public function asignarConcepto(Request $request, $id)
    {
        try{

            $request->validate([
                'empleado_id' => 'required|exists:users,id',
                'concepto_id' => 'required|exists:conceptos,id',
                'valor' => 'required|numeric',
                'fecha_inicio' => 'required|date',
                'fecha_fin' => 'nullable|date'
            ]);

            $concepto = Concepto::findOrFail($request->concepto_id);
            $user = User::findOrFail($id);

            if(strcmp($concepto->tipo_concepto, Concepto::TIPO_BONIFICACION) === 0){

                if($user->hijos === 0){
                    throw new Exception('El empleado no tiene hijos');
                }

            }

            EmpleadoConcepto::create($request->all());

            return redirect()->route('users.show', $id)->with('success', 'Concepto asignado exitosamente');


        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);
        }

    }
    public function registrarMovimiento(Request $request, $id){

        try{

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

            return redirect()->route('users.show', $id)->with('success', 'Movimiento registrado exitosamente');

        }catch(Exception $e){
            return back()->withErrors(['error' => $e->getMessage()]);

        }
    }
}
