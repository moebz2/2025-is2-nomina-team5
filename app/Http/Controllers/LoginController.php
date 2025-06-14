<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function authenticate(Request $request): RedirectResponse
    {

        // dd("Hola, queriendo iniciar sesion verdad?");

        $credentials = $request->validate([

            'email' => ['required', 'email'],

            'password' => ['required'],

        ]);


        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->estado == User::ESTADO_DESPEDIDO) {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Ocurrió un error al intentar iniciar sesión.',
                ])->onlyInput('email');
            }

            if($user->estado == User::ESTADO_INACTIVO){
                Auth::logout();
                return redirect()->route('vacaciones.index');

            }



            // dd("Sesin iniciada!");

            return redirect()->intended('/admin');
        }


        // dd("Algo paso, pero no iniciaste sesion");

        return back()->withErrors([

            'email' => 'The provided credentials do not match our records.',

        ])->onlyInput('email');
    }
    public function logout(Request $request): RedirectResponse

    {

        Auth::logout();



        $request->session()->invalidate();



        $request->session()->regenerateToken();



        return redirect('/login');
    }
}
