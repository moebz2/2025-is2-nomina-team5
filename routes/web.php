<?php

use App\Http\Controllers\LoginController;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartamentoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

Route::middleware(['auth'])->prefix('admin')->group(function () {

    // Registrar todas las vistas de un usuario autenticado

    Route::resource('users', UserController::class);

    Route::resource('departamentos', DepartamentoController::class);

    Route::get('', function () {
        echo "Bienvenido a administrador";
    });

    Route::get('usuarios', function () {
        echo "Vista de Usuarios";
    });

    // Se debe registrar el recurso LOGOUT
});

/*
Route::middleware([EnsureUserIsAuthenticated::class])->prefix('admin')->group(function(){

    Route::get('/sesion', function(){
        echo "Sesion iniciada";
    });

}); */
