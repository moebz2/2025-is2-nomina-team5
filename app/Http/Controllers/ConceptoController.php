<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concepto;

class ConceptoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:concepto ver')->only('index');
        $this->middleware('can:concepto crear')->only('create', 'store');
        $this->middleware('can:concepto editar')->only('edit', 'update');
        $this->middleware('can:concepto eliminar')->only('destroy');
    }

    public function index()
    {
        return view('conceptos.index', [
            'conceptos' => Concepto::all(),
        ]);
    }

    public function create()
    {
        return view('conceptos.create');
    }

    public function store(Request $request)
    {


        $request->validate([
            'nombre' => 'required|string|max:255',
            'ips_incluye' => 'required|boolean',
            'aguinaldo_incluye' => 'required|boolean',

        ]);

        Concepto::create([
            'nombre' => $request->nombre,
            'ips_incluye' => $request->ips_incluye,
            'aguinaldo_incluye' => $request->aguinaldo_incluye,
            'tipo_concepto' => Concepto::TIPO_GENERAL,
            'es_debito' => boolval($request->es_debito)
        ]);

        return redirect()->route('conceptos.index')->with('success', 'Concepto creado exitosamente');
    }

    public function edit($id)
    {
        $concepto = Concepto::findOrFail($id);
        return view('conceptos.edit', compact('concepto'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ips_incluye' => 'required|boolean',
        ]);

        $concepto = Concepto::findOrFail($id);
        $concepto->update([
            'nombre' => $request->nombre,
            'ips_incluye' => $request->ips_incluye,
        ]);

        return redirect()->route('conceptos.index')->with('success', 'Concepto actualizado exitosamente');
    }

    public function destroy($id)
    {
        $concepto = Concepto::findOrFail($id);
        $concepto->update(['estado' => false]);

        return redirect()->route('conceptos.index')->with('success', 'Concepto dado de baja exitosamente');
    }
}
