<?php

use App\Http\Controllers\ConceptoController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\LiquidacionController;
use App\Http\Controllers\LiquidacionEmpleadoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;



Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin'); // Redirect to /admin if logged in
    }
    return redirect('/login'); // Redirect to /login if logged out
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Registrar todas las vistas de un usuario autenticado

    //Route::resource('users', UserController::class);
    Route::resource('users', UserController::class)->except(['show']);


    // Recursos de USUARIO

    Route::post('users/{id}/conceptos', [UserController::class, 'asignarConcepto'])->name('users.asignarConcepto');

    Route::post('users/{id}/movimientos', [UserController::class, 'registrarMovimiento'])->name('users.registrarMovimiento');



    Route::resource('departamentos', DepartamentoController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('conceptos', ConceptoController::class);

    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::patch('/users/{id}/inactive', [UserController::class, 'setInactive'])->name('users.setInactive');

    Route::get('', function () {
        return view('admin-index');
    });

    Route::get('usuarios', function () {
        echo "Vista de Usuarios";
    });

    Route::get('liquidacion', [LiquidacionController::class, 'index'])->name('liquidacion.index');

    Route::get('liquidacion/generar', [LiquidacionController::class, 'showFormGenerar'])->name('liquidacion.generarForm');

    Route::post('liquidacion/generar', [LiquidacionController::class, 'generar'])->name('liquidacion.generar');

    Route::delete('liquidacion/eliminar-generados', [LiquidacionController::class, 'eliminarGenerados'])->name('liquidacion.eliminarGenerados');

    Route::delete('liquidacion/eliminar-todos', [LiquidacionController::class, 'eliminarTodos'])->name('liquidacion.eliminarTodos');

    Route::get('configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');

    Route::post('movimientos/generar', [MovimientoController::class, 'generarMovimientos'])->name('movimientos.generar');

    Route::get('/liquidacion-empleados/{liquidacionId}', [LiquidacionEmpleadoController::class, 'index'])->name('liquidacion-empleado.index');

    Route::get('/liquidacion-empleado/{id}', [LiquidacionEmpleadoController::class, 'show'])->name('liquidacion-empleado.show');
});

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
/*
Route::middleware([EnsureUserIsAuthenticated::class])->prefix('admin')->group(function(){

    Route::get('/sesion', function(){
        echo "Sesion iniciada";
    });

}); */
