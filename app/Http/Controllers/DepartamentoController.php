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

    public function index()
    {
        $view = view('departamentos.index', [
            'departamentos' => Departamento::all(),
        ]);
        return view('configuracion.index2', ['content' => $view]);
    }

    public function create()
    {
        $view = view('departamentos.create');
        return view('configuracion.index2', ['content' => $view]);
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

    public function edit($id)
    {
        $departamento = Departamento::findOrFail($id);
        $view = view('departamentos.edit', compact('departamento'));
        return view('configuracion.index2', ['content' => $view]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:32',
            'descripcion' => 'nullable|string|max:255',
        ]);

        $departamento = Departamento::findOrFail($id);
        $departamento->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento actualizado exitosamente');
    }

    public function destroy($id)
    {
        $departamento = Departamento::findOrFail($id);
        $departamento->update(['estado' => false]);

        return redirect()->route('departamentos.index')->with('success', 'Departamento dado de baja exitosamente');
    }
}
