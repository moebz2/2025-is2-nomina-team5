<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
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
        $users = User::with('empleado.departamento')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        $roles = Role::all();
        return view('users.create', compact('departamentos', 'roles'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|integer|unique:users',
            'sexo' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nacimiento_fecha' => 'required|date',
            'ingreso_fecha' => 'required|date',
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
                'domicilio' => strip_tags($request->domicilio),
            ]);

            Empleado::create([
                'usuario_id' => $usuario->id,
                'fecha_ingreso' => $request->ingreso_fecha,
                'fecha_egreso' => $request->salida_fecha,
                'estado' => Empleado::ESTADO_CONTRATADO,
                'departamento_id' => $request->departamento_id,
            ]);
        });

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }

    public function edit($id)
    {





        $roles = Role::all();
        $user = User::with('empleado')->findOrFail($id);
        $fecha_nacimiento = Carbon::parse($user->nacimiento_fecha)->format('Y-m-d');
        $fecha_ingreso = null;
        if (isset($user->empleado)) {

            $fecha_ingreso = Carbon::parse($user->empleado->fecha_ingreso)->format('Y-m-d');
        }
        $departamentos = Departamento::all();
        return view('users.edit', compact('user', 'departamentos', 'roles', 'fecha_nacimiento', 'fecha_ingreso'));
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
            'role'=> 'required',
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

            if(isset($user->empleado)){

                $user->empleado->update([
                    'fecha_ingreso' => $request->ingreso_fecha,
                    'fecha_egreso' => $request->salida_fecha,
                    'departamento_id' => $request->departamento_id,
                ]);
            }else{

                Empleado::create([
                    'usuario_id' => $user->id,
                    'fecha_ingreso' => $request->ingreso_fecha,
                    'fecha_egreso' => $request->salida_fecha,
                    'estado' => Empleado::ESTADO_CONTRATADO,
                    'departamento_id' => $request->departamento_id
                ]);


            }


            $user->assignRole($request->role);

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
