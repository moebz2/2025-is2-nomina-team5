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
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Nombre</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Cédula</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Sexo</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Email</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Nacimiento
                        Fecha</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Ingreso
                        Fecha</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Salida
                        Fecha</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Estado</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Domicilio
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        Departamento</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Acciones</th>
                </thead>
                @foreach ($users as $user)
                <tr>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->id }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->nombre }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->cedula }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->sexo }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->email }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->nacimiento_fecha }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                        {{ $user->empleado->fecha_ingreso ?? 'NA' }}
                    </td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                        {{ $user->empleado->fecha_egreso ?? 'NA' }}
                    </td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->estado }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $user->domicilio }}</td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                        {{ $user->empleado->departamento->nombre ?? 'NA' }}
                    </td>
                    <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                        <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('users.create') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Registrar nuevo usuario</a>
    </div>
</div>

@endsection