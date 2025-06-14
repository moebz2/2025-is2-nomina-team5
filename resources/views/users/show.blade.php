@extends('layouts.admin-layout')

@section('title', 'Editar usuario')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')



    <div x-data="{ tab: '{{ $tab }}', conceptoForm: false, prestamoForm: false, movimientoForm: false, hijoForm: false, salarioForm: false, estadoForm: false }" class="container mx-auto p-10">

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Exito!</span> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
        @endif
        @if (session('errors'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <span class="font-medium">Error!</span> {{ session('errors') }}
            </div>
        @endif



        <div class="p-4 bg-gradient-to-tl from-teal-600 from-0% via-cyan-200 via-50% to-lime-200 to-100% rounded-xl">
            <div>
                <h3 class="font-bold text-xl text-slate-600">Detalles del empleado</h3>
            </div>
            <div class="mt-4">

                <h3 class="font-bold text-3xl">
                    {{ $user->nombre }}
                </h3>
                <p class="text-gray-700">{{ $user->email }}</p>


            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 mt-4 justify-around">
                <div>
                    <p class="text-sm text-gray-700">Cargo</p>
                    <h4 class="font-semibold text-lg">
                        @if ($cargo)
                            {{ $cargo->nombre }}
                        @else
                            No asignado
                        @endif
                    </h4>
                </div>
                <div>
                    <p class="text-sm text-gray-700">Departamento</p>
                    <h4 class="font-semibold text-lg">
                        @if ($cargo)
                            {{ $cargo->departamento->nombre }}
                        @else
                            No asignado
                        @endif
                    </h4>
                </div>
                <div class="flex gap-4 items-center">
                    <div>

                        <p class="text-sm text-gray-700">Estado</p>
                        <h4 class="font-semibold text-lg uppercase">{{ $user->estado }}</h4>
                    </div>
                    <button x-on:click="estadoForm = !estadoForm, salarioForm = false"
                        class="bg-white p-2 hover:bg-indigo-600 text-gray-700 hover:text-white cursor-pointer flex items-center rounded-xl"><i
                            class="material-symbols-outlined">edit</i></button>
                </div>
                <div>
                    <p class="text-sm text-gray-700">Fecha ingreso</p>
                    <h4 class="font-semibold text-lg">
                        @if ($cargo)
                            {{ $cargo->pivot->fecha_inicio }}
                        @else
                            No asignado
                        @endif
                    </h4>
                </div>




            </div>
        </div>

        <div class="grid grid-cols-4 mt-4 gap-4">
            <div class="border border-gray-300 p-4 rounded">
                <p class="text-sm font-medium text-gray-700">IPS</p>
                <h3 class="md:text-2xl text-xl font-medium">
                    @if ($salario)
                        {{  number_format(intval($salario->pivot->valor * $ips), 0, ',', '.') }} Gs.
                    @else
                        No calculable
                    @endif
                </h3>
            </div>
            <div class="border border-gray-300 p-4 rounded flex items-center">
                <div>
                    <p class="text-sm font-medium text-gray-700">Salario</p>
                    <h3 class="md:text-2xl text-xl font-medium">
                        @if ($salario)
                            {{   number_format($salario->pivot->valor, 0, ',', '.')  }} Gs
                        @else
                            No asignado
                        @endif
                    </h3>

                </div>
                <button x-on:click="salarioForm = !salarioForm, estadoForm = false" @if ($salario)
                    disabled="true"
                @endif
                    class="bg-gray-100 p-2 ml-auto hover:bg-indigo-600 text-gray-700 hover:text-white cursor-pointer flex items-center rounded-xl disabled:bg-gray-300 disabled:text-gray-100 disabled:cursor-not-allowed"><i
                        class="material-symbols-outlined">edit</i></button>
            </div>
            <div class="border border-gray-300 p-4 rounded">
                <p class="text-sm font-medium text-gray-700">Bonif. Familiar</p>
                <h3 class="md:text-2xl text-xl font-medium">
                    @if ($user->hijosMenores->count() > 0)
                        Aplica
                    @else
                        No aplica
                    @endif
                </h3>
            </div>
            <div class="border border-gray-300 p-4 rounded">
                <p class="text-sm font-medium text-gray-700">Cant. Hijos</p>
                <h3 class="md:text-2xl text-xl font-medium">{{ $user->hijos()->count() }}</h3>
            </div>
        </div>


        @include('users.partials.salario-form')
        @include('users.partials.estado-form')


        <div class="mt-4 border border-gray-300 rounded p-4">
            <ul class="flex text-gray-700 ">
                <li>
                    <a href="?pestana=liquidaciones"
                        :class="{ 'font-medium border-b-2 text-black': tab == 'liquidaciones' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Liquidaciones</a>
                </li>
                <li>
                    <a href="?pestana=movimientos" :class="{ 'font-medium border-b-2 text-black': tab == 'movimientos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Movimientos</a>
                </li>

                <li>
                    <a href="?pestana=conceptos" :class="{ 'font-medium border-b-2 text-black': tab == 'conceptos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Conceptos</a>
                </li>
                <li>
                    <a href="?pestana=prestamos" :class="{ 'font-medium border-b-2 text-black': tab == 'prestamos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Préstamos</a>
                </li>


                <li>
                    <a href="?pestana=hijos" :class="{ 'font-medium border-b-2 text-black': tab == 'hijos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Hijos</a>
                </li>

            </ul>
            <div>


                @if (strcmp($tab, 'liquidaciones') == 0)
                    @include('users.partials.tab-liquidaciones')
                @endif

                @if (strcmp($tab, 'conceptos') == 0)
                    @include('users.partials.tab-conceptos')
                @endif
                @if (strcmp($tab, 'prestamos') == 0)
                    @include('users.partials.tab-prestamos')
                @endif
                @if (strcmp($tab, 'movimientos') == 0)
                    @include('users.partials.tab-movimientos')
                @endif
                @if (strcmp($tab, 'hijos') == 0)
                    @include('users.partials.tab-hijos')
                @endif

            </div>
        </div>


    </div>



@endsection
