@extends('layouts.admin-layout')


@section('title', 'Movimientos')

@section('content')
    <div x-data="{ create: {{ request('mode_create', 'false') }} }" class="container mx-auto p-10">

        <div class="flex gap-4">
            <h3 class="text-3xl font-bold">Movimientos</h3>
            <button x-on:click="create = true" type="button"
                class="flex items-center border bg-white hover:bg-gray-800 hover:text-white font-medium py-2 px-4 rounded">
                <i class="material-symbols-outlined mr-2">add_circle</i>
                Agregar
            </button>
        </div>

        @include('layouts.partials.banner-message')

        <div x-show="create" class="mt-4 p-4 bg-gray-100 rounded" style="display: none">

            <h3 class="text-xl font-medium">Registrar movimiento</h3>

            <form action="{{ route('movimientos.store') }}" method="POST">
                @csrf
                <div class=" mt-4 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                    <input type="checkbox" name="mode_create" hidden x-model="create">
                    <div class="col-span-1 md:col-span-3">
                        <label for="create_empleado_id"
                            class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="create_empleado_id" name="create_empleado_id" autocomplete="create_empleado_id"
                                class="form-select" required>
                                <option value="" disabled selected>-- SELECCIONE EL EMPLEADO --</option>
                                @foreach ($empleados as $empleado)
                                    <option value="{{ $empleado->id }}">{{ $empleado->nombre }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="create_monto" class="block text-sm font-medium text-gray-700">Monto del
                            movimiento</label>
                        <div class="mt-2">
                            <input type="number" name="create_monto" id="create_monto" value="0" required
                                class="form-input">
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="create_concepto_id" class="block text-sm font-medium text-gray-700">Concepto</label>


                        <div class="mt-2 grid grid-cols-1">
                            <select id="create_concepto_id" name="create_concepto_id" autocomplete="create_concepto_id"
                                class="form-select" required>
                                <option value="" disabled selected>-- SELECCIONE EL CONCEPTO --</option>
                                @foreach ($conceptos_create as $concepto)
                                    <option value="{{ $concepto->id }}">{{ $concepto->nombre }}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <p class="mt-1 text-sm/6 text-gray-600">Seleccione el concepto a asignar</p>

                    </div>



                    <div class="sm:col-span-3">
                        <label for="create_validez_fecha" class="block text-sm font-medium text-gray-700">Fecha de
                            validez</label>
                        <div class="mt-2">
                            <input type="date" name="create_validez_fecha" id="create_validez_fecha"
                                value="{{ old('create_validez_fecha') }}" required class="form-input">
                        </div>
                    </div>





                </div>
                <div class="mt-10 flex gap-4">
                    <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Guardar movimiento
                    </button>
                    <button x-show="create" x-on:click="create = false"
                        class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">

                        Cancelar
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-6 mt-4">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-6 gap-4">
                {{-- Empleado --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="empleado_id" class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
                    <select name="empleado_id" id="empleado_id" class="form-select w-full rounded border-gray-300">
                        <option value="">-- Todos --</option>
                        @foreach ($empleados as $empleado)
                            <option value="{{ $empleado->id }}"
                                {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                                {{ $empleado->nombre ?? 'Sin nombre' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Concepto --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="concepto_id" class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                    <select name="concepto_id" id="concepto_id" class="form-select w-full rounded border-gray-300">
                        <option value="">-- Todos --</option>
                        @foreach ($conceptos as $concepto)
                            <option value="{{ $concepto->id }}"
                                {{ request('concepto_id') == $concepto->id ? 'selected' : '' }}>
                                {{ $concepto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- tipo de movimiento --}}
                <div class="col-span-1 md:col-span-2">
                    <label for="es_debito" class="block text-sm font-medium text-gray-700 mb-1">Tipo de movimiento</label>
                    <select name="es_debito" id="es_debito" class="form-select w-full rounded border-gray-300">
                        <option value="">-- Todos --</option>
                        <option value="1" {{ request('es_debito') == '1' ? 'selected' : '' }}>Debitos</option>
                        <option value="0" {{ request('es_debito') == '0' ? 'selected' : '' }}>Creditos</option>

                    </select>
                </div>

                {{-- Fechas (en una fila) --}}
                <div class="col-span-1 md:col-span-4 grid grid-cols-3 gap-4">
                    <div>
                        <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                        <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                            class="form-input w-full rounded border-gray-300">
                    </div>

                    <div>
                        <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                        <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                            class="form-input w-full rounded border-gray-300">
                    </div>
                    <div>
                        <label for="paginate" class="block text-sm font-medium text-gray-700 mb-1">Cantidad a
                            mostrar</label>
                        <input type="number" name="paginate" min="1" max="50" step="1"
                            id="paginate" value="{{ request('paginate', 10) }}"
                            class="form-input w-full rounded border-gray-300">
                    </div>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>


        <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
            <div class="my-8 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse text-sm">
                    <thead>
                        <tr>

                            {{-- <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th> --}}
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Nombre
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Empleado
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Monto
                                (Gs)</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Tipo
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Validez
                            </th>
                            {{-- <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Nacimiento
                            </th> --}}
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Fecha
                                creación
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movimientos as $movimiento)
                            <tr>


                                {{-- <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->id }}</td> --}}
                                <td class="border-b border-gray-100 p-4 font-medium">{{ $movimiento->concepto->nombre }}
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">{{ $movimiento->empleado->nombre }}
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ number_format($movimiento->monto, 0, ',', '.') }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    @if ($movimiento->concepto->es_debito)
                                        <span
                                            class="ml-3 rounded-lg border-red-500 bg-red-100 px-2 border py-0.5 text-xs/6 font-semibold whitespace-nowrap text-red-500 ">Debito</span>
                                    @else
                                        <span
                                            class="ml-3 rounded-lg border-green-500 bg-green-100 px-2 border py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-500 ">Credito</span>
                                    @endif



                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ $movimiento->validez_fecha->format('F') }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ $movimiento->generacion_fecha->format('d-m-Y') }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">

                                    @can('movimiento eliminar')
                                        <form action="{{ route('movimientos.destroy', $movimiento->id) }}"
                                            onsubmit="return confirm('¿Está seguro de que desea eliminar {{ $movimiento->concepto->nombre }} de {{ $movimiento->empleado->nombre }}?');"
                                            method="post">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" @if (!$movimiento->concepto->es_modificable)
                                                @disabled(true)
                                            @endif class="hover:text-red-700 cursor-pointer disabled:cursor-not-allowed disabled:text-gray-300">

                                                <i class="material-symbols-outlined">delete</i>
                                            </button>

                                        </form>
                                    @endcan

                                </td>




                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-4">

            {{ $movimientos->links() }}
        </div>
    </div>
@endsection
