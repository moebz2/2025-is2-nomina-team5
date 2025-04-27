@extends('layouts.admin-layout')

@section('title', 'Liquidaciones')

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-medium uppercase">Lista de Liquidaciones</h1>
    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-x-auto">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th>

                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Periodo</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Estado</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Fecha de Generación</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liquidaciones as $liquidacion)
                    <tr>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacion->id }}</td>

                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacion->periodo->format('Y-m') }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacion->estado }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacion->generacion_fecha->format('Y-m-d') }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500 flex items-center gap-2">
                            <a href="" title="Ver" class="hover:text-blue-500 block cursor-pointer">
                                <i class="material-symbols-outlined">visibility</i>
                            </a>
                            
                            {{-- <form action="{{ route('liquidaciones.destroy', $liquidacion->id) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Está seguro de que desea eliminar esta liquidación?');">
                                @csrf
                                @method('DELETE')
                                <button title="Eliminar" type="submit" class="hover:text-red-500 block text-left cursor-pointer">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                            </form> --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('liquidacion.generarForm') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Registrar nueva liquidación</a>
    </div>
</div>

@endsection