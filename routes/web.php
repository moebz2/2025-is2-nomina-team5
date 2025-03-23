<?php

use App\Http\Controllers\LoginController;
use App\Http\Middleware\EnsureUserIsAuthenticated;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartamentoController;
use App\Http\Controllers\RoleController;

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

    Route::resource('roles', RoleController::class);

    Route::get('users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');

    Route::put('users/{id}', [UserController::class, 'update'])->name('users.update');

    Route::get('', function () {
        echo "Bienvenido a administrador";
    });

    Route::get('usuarios', function () {
        echo "Vista de Usuarios";
    });

    // Se debe registrar el recurso LOGOUT
});

Route::post('logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
/*
Route::middleware([EnsureUserIsAuthenticated::class])->prefix('admin')->group(function(){

    Route::get('/sesion', function(){
        echo "Sesion iniciada";
    });

}); */
