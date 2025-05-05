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
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Nombre
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Cédula
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Sexo</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Email</th>
                            {{-- <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Nacimiento
                            </th> --}}
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Cargo
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Estado
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Rol</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Bonificación Familiar</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Hijos</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-500">Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>


                                {{-- <td class="border-b border-gray-100 p-4 text-gray-500">{{ $user->id }}</td> --}}
                                <td class="border-b border-gray-100 p-4 font-medium">{{ $user->nombre }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">{{ $user->cedula }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">{{ $user->sexo }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">{{ $user->email }}</td>
                                {{-- <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ $user->nacimiento_fecha->format('Y-m-d') }}</td> --}}
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ $user->currentCargo() ? $user->currentCargo()->nombre : 'Sin cargo' }}
                                </td>
                                {{-- <td class="border-b border-gray-100 p-4 text-gray-700">{{ $user->fecha_egreso ? $user->fecha_egreso->format('Y-m-d') :'NA' }}</td> --}}
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    @if (strcmp($user->estado, 'baja') == 0)

                                    <span
                                    class="ml-3 rounded-lg bg-yellow-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-yellow-700 ">De baja</span>
                                    @else
                                    <span
                                    class="ml-3 rounded-lg bg-indigo-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-indigo-700 ">{{ $user->estado }}</span>

                                    @endif
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">

                                    @foreach ($user->roles as $role)
                                        <span
                                            class="ml-3 rounded-lg bg-blue-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-blue-700 ">{{ $role->name }}</span>
                                    @endforeach

                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    @if ($user->hijosMenores->count() > 0)
                                    <span
                                    class="ml-3 rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-700 ">Incluye</span>
                                    @else
                                    <span
                                    class="ml-3 rounded-lg bg-red-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-red-700 ">No incluye</span>
                                    @endif
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-700">
                                    {{ is_iterable($user->hijosMenores) ? $user->hijosMenores->count() : 0 }} hijo(s)
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-500 flex items-center gap-2">
                                    <a href="{{ route('users.show', $user->id) }}" title="Ver"
                                        class=" hover:text-blue-500 block cursor-pointer">
                                        <i class="material-symbols-outlined">preview</i>
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" title="Editar"
                                        class=" hover:text-blue-500 block cursor-pointer">
                                        <i class="material-symbols-outlined">edit</i>
                                    </a>

                                    <form action="{{ route('users.setInactive', $user->id) }}" method="POST"
                                        class="mt-2"
                                        onsubmit="return confirm('¿Está seguro de que desea marcar como inactivo a este usuario?');">
                                        @csrf
                                        @method('PATCH')
                                        <button title="Dar de baja" type="submit"
                                            class=" hover:text-yellow-500 block text-left cursor-pointer">
                                            <i class="material-symbols-outlined">block</i>
                                        </button>
                                    </form>

                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="mt-2"
                                        onsubmit="return confirm('¿Está seguro de que desea dar de baja a este usuario?');">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar" type="submit"
                                            class=" hover:text-red-500 block text-left cursor-pointer">
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
        <div class="mt-4">
            <a href="{{ route('users.create') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Registrar nuevo
                usuario</a>
        </div>
    </div>

@endsection
