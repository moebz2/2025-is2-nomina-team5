<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'cedula' => 'required|string|max:255',
            'sexo' => 'required|in:M,F',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'nacimiento_fecha' => 'required|date',
            'ingreso_fecha' => 'required|date',
            'domicilio' => 'nullable|string|max:255',
        ]);

        User::create([
            'nombre' => $request->nombre,
            'cedula' => $request->cedula,
            'sexo' => $request->sexo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nacimiento_fecha' => $request->nacimiento_fecha,
            'ingreso_fecha' => $request->ingreso_fecha,
            'salida_fecha' => $request->salida_fecha,
            'domicilio' => $request->domicilio,
        ]);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }
}
