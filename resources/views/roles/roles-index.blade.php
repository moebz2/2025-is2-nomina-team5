@extends('layouts.admin-layout')

@section('sidebar')
    @include('roles.partials.sidebar')
@endsection

@section('content')
<div class="min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-4xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
        <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Lista de Roles</h1>
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
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Rol</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Permisos</th>
                        <th class="border-b border-blue-200 p-4 pt-0 pb-3 text-left font-semibold text-blue-700">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr class="hover:bg-blue-50/50 transition">
                        <td class="border-b border-blue-100 p-4 text-blue-900">{{ $role->id }}</td>
                        <td class="border-b border-blue-100 p-4 text-blue-900 font-semibold">{{ $role->name }}</td>
                        <td class="border-b border-blue-100 p-4">
                            <div class="flex flex-wrap gap-2">
                                @foreach ($role->permissions->pluck('name') as $permission)
                                    <span class="rounded-lg bg-blue-100 px-2 py-0.5 text-xs font-semibold text-blue-700">{{$permission}}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="border-b border-blue-100 p-4 flex gap-2">
                            @can('rol editar')
                                <a href="{{route('roles.edit', $role->id)}}" class="hover:text-blue-600 cursor-pointer transition">
                                    <i class="material-symbols-outlined">edit</i>
                                </a>
                            @endcan
                            @can('rol eliminar')
                                <button class="hover:text-red-700 cursor-pointer transition">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-6 text-center">
            <a href="{{route('roles.create')}}" class="inline-block w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">Registrar nuevo rol</a>
        </div>
    </div>
</div>
@endsection
