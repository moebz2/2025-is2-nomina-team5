<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Carbon\Carbon;
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
        $users = User::paginate(10);

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
            'cargo_id' => 'nullable|exists:cargos,id',
            'domicilio' => 'nullable|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
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

            $role = Role::findOrFail($request->role_id);
            $usuario->assignRole($role);

            if (isset($request->cargo_id)) {
                if (!isset($request->ingreso_fecha)) {
                    $request->ingreso_fecha = Carbon::now();
                }

                $cargo = Cargo::findOrFail($request->cargo_id);

                $usuario->asignarCargo($cargo, $request->ingreso_fecha);
            }
        });

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {
        $roles = Role::all();
        $user = User::findOrFail($id);
        $fecha_nacimiento = Carbon::parse($user->nacimiento_fecha)->format('Y-m-d');
        $fecha_ingreso = null;


        if (isset($user->empleado)) {

            $fecha_ingreso = Carbon::parse($user->empleado->fecha_ingreso)->format('Y-m-d');
        }
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
            'departamento_id' => 'required|exists:departamentos,id',
            'cargo_id' => 'required|exists:cargos,id',
            'salida_fecha' => 'nullable|date',
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
                'fecha_ingreso' => $request->ingreso_fecha,
                'fecha_egreso' => $request->salida_fecha,

                'domicilio' => strip_tags($request->domicilio),
            ]);

            $user->assignRole($request->role);

            $cargo = Cargo::findOrFail($request->cargo_id);

            $user->asignarCargo($cargo);
        });

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        DB::transaction(function () use ($user) {
            $user->update(['estado' => 'baja']);
            $user->empleado->update(['fecha_egreso' => Carbon::now()]);
        });

        return redirect()->route('users.index')->with('success', 'Usuario dado de baja exitosamente');
    }

    public function setInactive($id)
    {
        $user = User::findOrFail($id);
        $user->update(['estado' => 'inactivo']);

        return redirect()->route('users.index')->with('success', 'Usuario marcado como inactivo exitosamente');
    }
}
