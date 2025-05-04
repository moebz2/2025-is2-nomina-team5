@extends('layouts.admin-layout')

@section('title', 'Editar usuario')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')



    <div class="container mx-auto p-10">

        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
                role="alert">
                <span class="font-medium">Exito!</span> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
        @endif

        <div class="p-4 bg-gray-100 rounded-xl">
            <div>
                <h3 class="font-bold text-lg">Detalles del empleado</h3>
            </div>
            <div class="mt-4">

                <h3 class="font-bold text-xl">
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
                <div>
                    <p class="text-sm text-gray-700">Estado</p>
                    <h4 class="font-semibold text-lg uppercase">{{ $user->estado }}</h4>
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
            <div class="border border-gray-400 p-4 rounded">
              <p class="text-sm font-medium text-gray-700">IPS</p>
              <h3 class="md:text-2xl text-xl font-medium">
                @if ($ips)
                    {{$ips->pivot->valor}} %
                @else
                    No asignado
                @endif
              </h3>
            </div>
            <div class="border border-gray-400 p-4 rounded">
              <p class="text-sm font-medium text-gray-700">Salario</p>
              <h3 class="md:text-2xl text-xl font-medium">
                @if ($salario)
                    {{$salario->pivot->valor}} Gs
                @else
                    No asignado
                @endif
              </h3>
            </div>
            <div class="border border-gray-400 p-4 rounded">
              <p class="text-sm font-medium text-gray-700">Bonif. Familiar</p>
              <h3 class="md:text-2xl text-xl font-medium">
                @if ($bonificacion)
                    {{$bonificacion->pivot->valor}} Gs
                @else
                    No asignado
                @endif
              </h3>
            </div>
            <div class="border border-gray-400 p-4 rounded">
              <p class="text-sm font-medium text-gray-700">Cant. Hijos</p>
              <h3 class="md:text-2xl text-xl font-medium">{{$user->hijos}}</h3>
            </div>
          </div>

        <div x-data="{ tab: 'conceptos', conceptoForm: false, movimientoForm: false }" class="mt-4 w- border border-gray-300 rounded p-4">
            <ul class="flex text-gray-700">

                <li>
                    <button x-on:click="tab = 'conceptos'"
                        :class="{ 'font-medium border-b-2 text-black': tab == 'conceptos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Conceptos</button>
                </li>
                <li>
                    <button x-on:click="tab = 'movimientos'"
                        :class="{ 'font-medium border-b-2 text-black': tab == 'movimientos' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Movimientos</button>
                </li>
                <li>
                    <button x-on:click="tab = 'liquidaciones'"
                        :class="{ 'font-medium border-b-2 text-black': tab == 'liquidaciones' }"
                        class="py-2 px-6 hover:text-black hover:font-medium">Liquidaciones</button>
                </li>

            </ul>
            <div>

                


                @include('users.partials.tab-conceptos')
                @include('users.partials.tab-movimientos')
                <div x-show="tab == 'liquidaciones'">{{ $liquidaciones }}</div>
            </div>
        </div>


    </div>





@endsection
