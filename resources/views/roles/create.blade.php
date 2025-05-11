@extends('layouts.admin-layout')

@section('title', 'Crear rol')

@section('sidebar')
    @include('roles.partials.sidebar')
@endsection


@section('content')
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-3xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
            <h1 class="text-3xl font-bold uppercase text-center mb-8 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Crear Rol</h1>
            @if ($errors->any())
                <div class="rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100 mb-6">
                    <ul class="list-disc pl-5 space-y-1 text-blue-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('roles.store') }}" method="POST">
                @csrf
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium text-blue-700">Nombre</label>
                        <div class="mt-2">
                            <input type="text" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" id="name" name="name" value="{{ old('name') }}" required>
                        </div>
                    </div>
                    <div class="sm:col-span-6">
                        <h3 class="block text-sm font-medium text-blue-700 mb-1">Asignar permisos</h3>
                        <p class="text-sm text-blue-400 mb-2">El Rol debe tener asignado permisos para que sea válido. La primera columna son los módulos y las siguientes columnas son las acciones</p>
                        <div class="relative overflow-x-auto rounded-2xl bg-white/60 backdrop-blur-md shadow-lg mt-4">
                            <table class="w-full text-sm text-left text-blue-900">
                                <thead class="bg-blue-100/60">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 font-semibold text-blue-700">Módulos</th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-blue-700">Ver</th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-blue-700">Editar</th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-blue-700">Crear</th>
                                        <th scope="col" class="px-6 py-3 font-semibold text-blue-700">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($groupedPermissions as $module => $actions)
                                        <tr class="border-b border-blue-100 hover:bg-blue-50/50 transition">
                                            <th scope="row" class="px-6 py-4 font-medium text-blue-900 whitespace-nowrap">{{ $module }}</th>
                                            @foreach ($availableActions as $key => $check)
                                                <td class="px-6 py-4">
                                                    <div class="flex h-6 shrink-0 items-center">
                                                        <div class="group grid size-4 grid-cols-1">
                                                            <input aria-describedby="permissions-description" name="permissions[]" value="{{ $module }} {{ $check }}" type="checkbox" class="col-start-1 row-start-1 appearance-none rounded-sm border border-blue-300 bg-white checked:border-blue-600 checked:bg-blue-600 indeterminate:border-blue-600 indeterminate:bg-blue-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600 disabled:border-blue-300 disabled:bg-blue-100 disabled:checked:bg-blue-100 forced-colors:appearance-auto">
                                                            <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-blue-950/25" viewBox="0 0 14 14" fill="none">
                                                                <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                                <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="mt-8">
                    <button class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition" type="submit">Crear Rol</button>
                </div>
            </form>
        </div>
    </div>
@endsection
