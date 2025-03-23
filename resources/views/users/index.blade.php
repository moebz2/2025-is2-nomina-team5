@extends('layouts.admin-layout')

@section('title', 'Usuarios')

@section('sidebar')
@include('users.partials.sidebar')
@endsection

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-medium uppercase">Lista de Usuarios</h1>
    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-x-auto">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Acciones</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Nombre</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Cédula</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Sexo</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Email</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Nacimiento</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Ingreso</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Salida</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Estado</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Domicilio</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Departamento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>
                        <td class="border-b border-gray-100 p-4 text-gray-500">
                            <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700 block cursor-pointer">Editar</a>

                            <form action="{{ route('users.setInactive', $user->id) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Está seguro de que desea marcar como inactivo a este usuario?');">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-yellow-500 hover:text-yellow-700 block text-left cursor-pointer">Marcar como inactivo</button>
                            </form>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Está seguro de que desea dar de baja a este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 block text-left cursor-pointer">Dar de baja</button>
                            </form>
                        </td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->id }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->nombre }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->cedula }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->sexo }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->email }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->nacimiento_fecha->format('Y-m-d') }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->empleado?->fecha_ingreso ? $user->empleado->fecha_ingreso->format('Y-m-d') : 'NA' }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->empleado?->fecha_egreso ? $user->empleado->fecha_egreso->format('Y-m-d') :'NA' }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->estado }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->domicilio }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->empleado->departamento->nombre ?? 'NA' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('users.create') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Registrar nuevo usuario</a>
    </div>
</div>

@endsection