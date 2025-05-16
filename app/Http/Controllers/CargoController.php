<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\Departamento;
use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        $cargos = Cargo::all();

        $view = view('cargos.index', compact('cargos'));

        return view('configuracion.index2', ['content' => $view]);

    }

    public function create()  {

        $departamentos = Departamento::all();

        $view = view('cargos.create', compact('departamentos'));
        return view('configuracion.index2', ['content' => $view]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:32',
            'descripcion' => 'nullable|string|max:255',
            'departamento_id' => 'required|exists:departamentos,id',
        ]);

        Cargo::create($request->all());

        return redirect()->route('cargos.index')->with('success', 'Cargo creado exitosamente');
    }
}
