<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;

class DepartamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:departamento ver')->only('index');
        $this->middleware('can:departamento crear')->only('create', 'store');
        $this->middleware('can:departamento editar')->only('edit', 'update');
        $this->middleware('can:departamento eliminar')->only('destroy');
    }

    public function create()
    {
        return view('departamentos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:32',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Departamento::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento creado exitosamente');
    }
}
