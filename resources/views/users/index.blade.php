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

                        {{-- <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th> --}}
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Nombre</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Cédula</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Sexo</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Email</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Nacimiento</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Cargo</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Rol</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Estado</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Acciones</th>
                        <th>Bonificación Familiar</th>
                        <th>Hijos</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr>


                        {{-- <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->id }}</td> --}}
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->nombre }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->cedula }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->sexo }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->email }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->nacimiento_fecha->format('Y-m-d') }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500"> {{ $user->currentCargo() ? $user->currentCargo()->nombre : 'Sin cargo' }}
                        </td>
                        {{-- <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->fecha_egreso ? $user->fecha_egreso->format('Y-m-d') :'NA' }}</td> --}}
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->estado }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">

                            @foreach ($user->roles as $role)
                            <span class="ml-3 rounded-lg bg-blue-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-blue-700 ">{{$role->name}}</span>

                            @endforeach

                        </td>
                        <td class="border-b border-gray-100 p-4 text-gray-500 flex items-center gap-2">
                            <a href="{{ route('users.edit', $user->id) }}" title="Editar" class=" hover:text-blue-500 block cursor-pointer">
                                <i class="material-symbols-outlined">edit</i>
                            </a>

                            <form action="{{ route('users.setInactive', $user->id) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Está seguro de que desea marcar como inactivo a este usuario?');">
                                @csrf
                                @method('PATCH')
                                <button title="Dar de baja" type="submit" class=" hover:text-yellow-500 block text-left cursor-pointer">
                                    <i class="material-symbols-outlined">block</i>
                                </button>
                            </form>

                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mt-2" onsubmit="return confirm('¿Está seguro de que desea dar de baja a este usuario?');">
                                @csrf
                                @method('DELETE')
                                <button title="Eliminar" type="submit" class=" hover:text-red-500 block text-left cursor-pointer">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                            </form>
                        </td>
                        <td>
                            {{ $user->aplica_bonificacion_familiar ? 'Sí' : 'No' }}
                        </td>
                        <td>
                        {{ is_iterable($user->hijos) ? $user->hijos->count() : 0 }} hijo(s)
                        </td>

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