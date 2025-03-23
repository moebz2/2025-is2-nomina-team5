@extends('layouts.master')


@section('title', 'Inicia sesion')


@section('content')
    <div class="h-screen w-full flex items-center justify-center bg-gray-100">

        <div class="p-10 w-96 bg-white rounded-lg">

            <h2 class="text-3xl font-bold text-center">Sistema de nomina</h2>
            <div class="mt-4">
                <h3 class="text-center text-xl text-slate-800 font-medium">Inicie sesion</h3>

                <form action="{{ route('authenticate') }}" method="post">

                    @csrf

                    <div class="mt-4">
                        <label for="email" class="block text-sm/6 font-semibold text-gray-900">Correo electronico</label>
                        <div class="mt-2.5">
                            <input type="text" name="email" id="email" autocomplete="given-name"
                                placeholder="correo@ejemplo.com"
                                class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        </div>
                    </div>
                    <div class="mt-4">
                        <label for="password" class="block text-sm/6 font-semibold text-gray-900">Clave de acceso</label>
                        <div class="mt-2.5">
                            <input type="password" name="password" id="password" autocomplete="given-name"
                                placeholder="****"
                                class="block w-full rounded-md bg-white px-3.5 py-2 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600">
                        </div>
                    </div>


                    <div class="mt-10">
                        <button type="submit"
                            class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Iniciar sesión
                        </button>
                    </div>

                </form>





            </div>

        </div>

        @if ($errors->any())
            <div class="text-sm text-red-500">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
@endsection
