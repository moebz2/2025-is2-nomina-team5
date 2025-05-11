@extends('layouts.admin-layout')

@section('title', 'Usuarios')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-7xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
        <div class="flex justify-end mb-4">
            <a href="{{ route('users.create') }}" class="inline-block py-3 px-6 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">Registrar nuevo usuario</a>
        </div>
        <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Lista de Usuarios</h1>
        @if (session('success'))
            <div class="rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100 mb-6 text-blue-700 text-center font-semibold">
                {{ session('success') }}
            </div>
        @endif
        <div class="mt-10 overflow-auto rounded-2xl bg-white/60 backdrop-blur-md shadow-lg">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead class="bg-blue-100/60">
                    <tr>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Nombre</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Cédula</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Sexo</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Email</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Cargo</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Estado</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Rol</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Bonificación Familiar</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Hijos</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="hover:bg-blue-50/50 transition">
                            <td class="border-b border-blue-100 p-4 font-semibold text-blue-900">{{ $user->nombre }}</td>
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ $user->cedula }}</td>
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ $user->sexo }}</td>
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ $user->email }}</td>
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ $user->currentCargo() ? $user->currentCargo()->nombre : 'Sin cargo' }}</td>
                            <td class="border-b border-blue-100 p-4">
                                @if (strcmp($user->estado, 'baja') == 0)
                                    <span class="rounded-lg bg-yellow-100 px-2 py-0.5 text-xs font-semibold text-yellow-700">De baja</span>
                                @else
                                    <span class="rounded-lg bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">{{ $user->estado }}</span>
                                @endif
                            </td>
                            <td class="border-b border-blue-100 p-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($user->roles as $role)
                                        <span class="rounded-lg bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">{{ $role->name }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="border-b border-blue-100 p-4">
                                @if ($user->hijosMenores->count() > 0)
                                    <span class="rounded-lg bg-green-100 px-2 py-0.5 text-xs font-semibold text-green-700">Incluye</span>
                                @else
                                    <span class="rounded-lg bg-red-100 px-2 py-0.5 text-xs font-semibold text-red-700">No incluye</span>
                                @endif
                            </td>
                            <td class="border-b border-blue-100 p-4 text-blue-900">{{ is_iterable($user->hijosMenores) ? $user->hijosMenores->count() : 0 }} hijo(s)</td>
                            <td class="border-b border-blue-100 p-4 flex items-center gap-2">
                                <a href="{{ route('users.show', $user->id) }}" title="Ver" class="hover:text-blue-500 block cursor-pointer transition">
                                    <i class="material-symbols-outlined">preview</i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" title="Editar" class="hover:text-blue-500 block cursor-pointer transition">
                                    <i class="material-symbols-outlined">edit</i>
                                </a>
                                <form action="{{ route('users.setInactive', $user->id) }}" method="POST" class="mt-0" onsubmit="return confirm('¿Está seguro de que desea marcar como inactivo a este usuario?');">
                                    @csrf
                                    @method('PATCH')
                                    <button title="Dar de baja" type="submit" class="hover:text-yellow-500 block text-left cursor-pointer transition">
                                        <i class="material-symbols-outlined">block</i>
                                    </button>
                                </form>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mt-0" onsubmit="return confirm('¿Está seguro de que desea dar de baja a este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Eliminar" type="submit" class="hover:text-red-500 block text-left cursor-pointer transition">
                                        <i class="material-symbols-outlined">delete</i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
