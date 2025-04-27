<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConfiguracionController extends Controller
{
    /**
     * Display the configuration form.
     */
    public function index()
    {
        return view('configuracion.index');
    }
}