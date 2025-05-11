@extends('layouts.admin-layout')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-5xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
            @if (session('success'))
                <div class="rounded-xl bg-green-50/80 backdrop-blur-sm p-4 border border-green-100 mb-6 text-green-700 text-center font-semibold">
                    <span class="font-medium">Éxito!</span> {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="rounded-xl bg-red-50/80 backdrop-blur-sm p-4 border border-red-100 mb-6 text-red-700 text-center font-semibold">
                    <span class="font-medium">Error!</span> {{ session('error') }}
                </div>
            @endif
            <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Lista de Conceptos</h1>
            <div class="mt-10 overflow-auto rounded-2xl bg-white/60 backdrop-blur-md shadow-lg">
                <table class="min-w-full table-auto border-collapse text-sm">
                    <thead class="bg-blue-100/60">
                        <tr>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">ID</th>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Nombre</th>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">IPS</th>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Aguinaldo</th>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Estado</th>
                            <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach ($conceptos as $concepto)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ $concepto->id }}</td>
                            <td class="border-b border-blue-100 p-4 text-blue-900 font-semibold">{{ $concepto->nombre }}</td>
                            <td class="border-b border-blue-100 p-4">
                                @if ($concepto->ips_incluye)
                                    <span class="rounded-lg bg-purple-100 px-2 py-0.5 text-xs font-semibold text-purple-700">Sí</span>
                                @else
                                    <span class="rounded-lg bg-yellow-100 px-2 py-0.5 text-xs font-semibold text-yellow-700">No</span>
                                @endif
                            </td>
                            <td class="border-b border-blue-100 p-4">
                                @if ($concepto->aguinaldo_incluye)
                                    <span class="rounded-lg bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">Sí</span>
                                @else
                                    <span class="rounded-lg bg-amber-100 px-2 py-0.5 text-xs font-semibold text-amber-700">No</span>
                                @endif
                            </td>
                            <td class="border-b border-blue-100 p-4">
                                @if ($concepto->estado)
                                    <span class="rounded-lg bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">Activo</span>
                                @else
                                    <span class="rounded-lg bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">Inactivo</span>
                                @endif
                            </td>
                            <td class="border-b border-blue-100 p-4 flex gap-2">
                                @if ($concepto->es_modificable)
                                    @can('concepto editar')
                                        <a href="{{ route('conceptos.edit', $concepto->id) }}" class="hover:text-blue-600 cursor-pointer transition">
                                            <i class="material-symbols-outlined">edit</i>
                                        </a>
                                    @endcan
                                    @can('concepto eliminar')
                                        <form action="{{ route('conceptos.destroy', $concepto->id) }}" method="POST" onsubmit="return confirm('¿Está seguro de que desea dar de baja este concepto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Eliminar" type="submit" class="hover:text-red-500 block text-left cursor-pointer transition">
                                                <i class="material-symbols-outlined">delete</i>
                                            </button>
                                        </form>
                                    @endcan
                                @else
                                    <span class="text-gray-400">Estáticos</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-6 text-center">
                <a href="{{ route('conceptos.create') }}" class="inline-block w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">Crear nuevo concepto</a>
            </div>
        </div>
    </div>
@endsection
