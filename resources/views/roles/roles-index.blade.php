@extends('layouts.admin-layout')

@section('sidebar')
    @include('roles.partials.sidebar')
@endsection

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-medium uppercase">Lista de Roles</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Rol</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Permisos</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Acciones</th>


                </thead>
                @foreach ($roles as $role)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $role->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $role->name }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            @foreach ($role->permissions->pluck('name') as $permission)
                            <span class="ml-3 rounded-lg bg-blue-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-blue-700 ">{{$permission}}</span>
                            @endforeach
                        </td>
                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-500">
                            @can('rol editar')

                            <button class="hover:text-gray-700 cursor-pointer">
                                <i class="material-symbols-outlined">edit</i>

                            </button>
                            @endcan

                            @can('rol eliminar')

                            <button class="hover:text-red-700 cursor-pointer">
                                <i class="material-symbols-outlined">delete</i>

                            </button>
                            @endcan

                        </td>

                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="mt-4">

        <a href="{{route('roles.create')}}" class="bg-blue-500 p-2 rounded text-white font-medium">Registrar nuevo rol</a>
    </div>
</div>
@endsection
