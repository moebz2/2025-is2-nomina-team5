<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use App\Models\User;

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
        $users = User::with('empleado.departamento')->get();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        $departamentos = Departamento::all();
        return view('users.create', compact('departamentos'));
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
                'departamento_id' => $request->departamento_id,
            ]);
        });

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente');
    }
}
