<?php

namespace App\Http\Controllers;

use App\Models\Departamento;
use App\Models\LiquidacionCabecera;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {

        $usuarios = User::all();
        $liquidaciones = LiquidacionCabecera::all();

        $departamentos = Departamento::all();

        return view('dashboard.index', compact('usuarios', 'liquidaciones', 'departamentos'));

    }
}
