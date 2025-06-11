<?php

use App\Http\Controllers\CargoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\LiquidacionEmpleadoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ReporteDescuentosController;
use App\Http\Controllers\ReporteLiqEmpleadoController;
use App\Http\Controllers\ReporteSumConceptosController;
use Illuminate\Http\Request;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin'); // Redirect to /admin if logged in
    }
    return redirect('/login'); // Redirect to /login if logged out
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('vacaciones', function () {
    return view('vacaciones');
})->name('vacaciones.index');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Registrar todas las vistas de un usuario autenticado

    // Recursos de USUARIO

    Route::resource('/users', UserController::class);

    Route::post('/users/{id}/conceptos', [UserController::class, 'asignarConcepto'])->name('users.asignarConcepto');

    Route::post('/users/{id}/movimientos', [UserController::class, 'registrarMovimiento'])->name('users.registrarMovimiento');

    Route::delete('/users/{user}/conceptos/{concepto}', [UserController::class, 'eliminarConcepto'])->name('users.eliminarConcepto');

    Route::post('/users/{id}/salarios', [UserController::class, 'asignarSalario'])->name('users.asignarSalario');

    Route::post('/users/{user}/hijos', [UserController::class, 'agregarHijo'])->name('users.agregarHijo');

    Route::patch('/users/{id}/estado', [UserController::class, 'cambiarEstado'])->name('users.cambiarEstado');


    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::patch('/users/{id}/inactive', [UserController::class, 'setInactive'])->name('users.setInactive');

    Route::get('', [DashboardController::class, 'index'])->name('admin.index');



    Route::get('api/test', function (Request $request) {

        $user = $request->user();

        return response()->json([
            'message' => 'Hola '. $user->nombre,
            '0' => 'Este es un mensaje de prueba',
            '1' => 'No conteste por favor'
        ]);

    });

    Route::get('api/dashboard/departamentos',  [DashboardController::class, 'departamentosChartInfo']);
    Route::get('api/dashboard/liquidaciones',  [DashboardController::class, 'liquidacionesMensualesAno']);
    Route::get('api/dashboard/conceptos',  [DashboardController::class, 'conceptosDebito']);

    Route::get('/usuarios', function () {
        echo "Vista de Usuarios";
    });

    // Recursos de LIQUIDACION

    Route::get('/liquidacion', [LiquidacionController::class, 'index'])->name('liquidacion.index');

    Route::post('/liquidacion/generar', [LiquidacionController::class, 'generar'])->name('liquidacion.generar');

    Route::delete('/liquidacion/eliminar-generados', [LiquidacionController::class, 'eliminarGenerados'])->name('liquidacion.eliminarGenerados');

    Route::delete('/liquidacion/eliminar-todos', [LiquidacionController::class, 'eliminarTodos'])->name('liquidacion.eliminarTodos');

    Route::get('/liquidacion-empleados/{liquidacionId}', [LiquidacionEmpleadoController::class, 'index'])->name('liquidacion-empleado.index');

    Route::get('/liquidacion-empleado/{id}', [LiquidacionEmpleadoController::class, 'show'])->name('liquidacion-empleado.show');

    Route::get('/liquidacion-empleado/{id}/export', [LiquidacionEmpleadoController::class, 'export'])->name('liquidacion-empleado.export');

    // Recursos de movimientos

    Route::resource('/movimientos', MovimientoController::class);

    Route::prefix('reportes')->group(function () {

        Route::get('', function () {
            return redirect()->route('reportes.descuentos');
        })->name('reportes.index');

        Route::get('/descuentos', [ReporteDescuentosController::class, 'index'])->name('reportes.descuentos');
        Route::get('/sum-conceptos', [ReporteSumConceptosController::class, 'index'])->name('reportes.sum-conceptos');
        Route::get('/liq-empleado', [ReporteLiqEmpleadoController::class, 'index'])->name('reportes.liq-empleado');
    });

    // CONFIGURACION

    Route::prefix('configuracion')->group(function () {

        Route::get('', function () {
            return redirect()->route('conceptos.index');
        })->name('configuracion.index');



        Route::resource('/departamentos', DepartamentoController::class);

        Route::resource('/roles', RoleController::class);

        Route::resource('/conceptos', ConceptoController::class);

        Route::resource('/cargos', CargoController::class);

        Route::get('/liquidacion/generar', [LiquidacionController::class, 'showFormGenerar'])->name('liquidacion.generarForm');

        Route::get('/movimientos/generar', function () {
            $view = view('configuracion.movimientos.generar');
            return view('configuracion.index2', ['content' => $view]);
        })->name('movimientos.generarForm');
    });

    Route::post('/movimientos/generar', [MovimientoController::class, 'generarMovimientos'])->name('movimientos.generar');

    Route::resource('/prestamos', PrestamoController::class);



    Route::get('/reportes/liq-empleado/export', [ReporteLiqEmpleadoController::class, 'export'])->name('reportes.liq-empleado.export');


    Route::get('/reportes/sum-conceptos/export', [ReporteSumConceptosController::class, 'export'])->name('reportes.sum-conceptos.export');
});

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
