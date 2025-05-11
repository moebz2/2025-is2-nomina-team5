@extends('layouts.admin-layout')


@section('content')

<div class="min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
        <div class="flex justify-end mb-4">
            <a href="{{route('departamentos.create')}}" class="inline-block py-3 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">Crear nuevo departamento</a>
        </div>
        <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Lista de Departamentos</h1>
        @if (session('success'))
            <div class="rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100 mb-6 text-blue-700 text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <div class="mt-10 overflow-auto rounded-2xl bg-white/60 backdrop-blur-md shadow-lg">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead class="bg-blue-100/60">
                    <tr>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">ID</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Nombre</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Descripción</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Estado</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($departamentos as $departamento)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="border-b border-blue-100 p-4 text-blue-900">{{ $departamento->id }}</td>
                        <td class="border-b border-blue-100 p-4 text-blue-900 font-semibold">{{ $departamento->nombre }}</td>
                        <td class="border-b border-blue-100 p-4 text-blue-900">{{ $departamento->descripcion}}</td>
                        <td class="border-b border-blue-100 p-4">
                            @if ($departamento->estado == 1)
                                <span class="rounded-lg bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">Activo</span>
                            @else
                                <span class="rounded-lg bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Inactivo</span>
                            @endif
                        </td>
                        <td class="border-b border-blue-100 p-4 flex gap-2">
                            @can('departamento editar')
                                <a href="{{route('departamentos.edit', $departamento->id)}}" class="hover:text-blue-600 cursor-pointer transition">
                                    <i class="material-symbols-outlined">edit</i>
                                </a>
                            @endcan
                            @can('departamento eliminar')
                                <form action="{{ route('departamentos.destroy', $departamento->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea dar de baja a este departamento?');">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Eliminar" type="submit" class="hover:text-red-500 block text-left cursor-pointer transition">
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
</div>
@endsection
