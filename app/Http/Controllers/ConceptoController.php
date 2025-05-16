<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Concepto;
use Exception;

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
        $view =  view('conceptos.index', [
            'conceptos' => Concepto::all(),
        ]);
        return view('configuracion.index2', ['content' => $view]);
    }

    public function create()
    {
        $view = view('conceptos.create');
        return view('configuracion.index2', ['content' => $view]);
    }

    public function store(Request $request)
    {

        $request->validate([
            'nombre' => 'required|string|max:255',
            'ips_incluye' => 'nullable|boolean',
            'aguinaldo_incluye' => 'nullable|boolean',
            'es_debito' => 'nullable|boolean'

        ]);

        try {
            Concepto::create($request->all());

            return redirect()->route('conceptos.index')->with('success', 'Concepto creado exitosamente');
        } catch (\Throwable $th) {
            return redirect()->back()->with(['error' => $th->getMessage()]);
        }
    }

    public function edit($id)
    {
        $concepto = Concepto::findOrFail($id);

        if (!$concepto->es_modificable) {

            return redirect()->back()->with(['error' => 'Este concepto no puede ser modificado']);
        }

        $view =  view('conceptos.edit', compact('concepto'));
        return view('configuracion.index2', ['content' => $view]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ips_incluye' => 'required|boolean',
        ]);

        try {

            $concepto = Concepto::findOrFail($id);
            $concepto->update([
                'nombre' => $request->nombre,
                'ips_incluye' => $request->ips_incluye,
            ]);

            return redirect()->route('conceptos.index')->with('success', 'Concepto actualizado exitosamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $concepto = Concepto::findOrFail($id);
        $concepto->update(['estado' => false]);

        return redirect()->route('conceptos.index')->with('success', 'Concepto dado de baja exitosamente');
    }
}
