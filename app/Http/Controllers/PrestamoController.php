<?php

namespace App\Http\Controllers;


use App\Models\Prestamo;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;


class PrestamoController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:prestamo crear')->only('create', 'store');
        $this->middleware('can:prestamo eliminar')->only('destroy');
    }

    public function create()
    {
        return view('prestamos.create');
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'empleado_id' => 'required|exists:users,id',
                'monto' => 'required|numeric|min:1',
                'cuotas' => 'required|integer|min:1',
            ]);

            Prestamo::create([
                'empleado_id' => $request->empleado_id,
                'monto' => $request->monto,
                'estado' => 'vigente',
                'cuotas' => $request->cuotas,
                'generacion_fecha' => now(),
            ]);


            return redirect()->route('users.show', $request->empleado_id)->with('success', 'Préstamo creado exitosamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Prestamo $prestamo)
    {
        try {
            $prestamo->update(['estado' => 'cancelado']);
            return redirect()->route('users.show', $prestamo->empleado_id)->with('success', 'Préstamo cancelado exitosamente');
        } catch (Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
