@extends('layouts.admin-layout')


@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-medium uppercase">Lista de Departamentos</h1>
    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Nombre</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Descripción</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Acciones</th>


                </thead>
                @foreach ($departamentos as $departamento)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $departamento->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $departamento->nombre }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            {{ $departamento->descripcion}}
                        </td>
                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-500">
                            @can('departamento editar')

                            <a href="{{route('departamentos.edit', $departamento->id)}}" class="hover:text-gray-700 cursor-pointer">
                                <i class="material-symbols-outlined">edit</i>

                            </a>
                            @endcan

                            @can('departamento eliminar')

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

        <a href="{{route('departamentos.create')}}" class="bg-blue-500 p-2 rounded text-white font-medium">Crear nuevo departamento</a>
    </div>
</div>
@endsection
