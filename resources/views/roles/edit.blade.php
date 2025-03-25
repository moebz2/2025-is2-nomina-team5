@extends('layouts.admin-layout')

@section('title', 'Crear rol')

@section('sidebar')
    @include('roles.partials.sidebar')
@endsection


@section('content')

    <div class="container p-10 mx-auto">

        <h1 class="text-3xl font-bold uppercase">Editar Rol</h1>
        <p class="text-gray-700">Puedes editar los permisos de un rol existente. Los cambios aplicaran a todos los usuarios a los que hayas asignado este rol
            anteriormente.
        </p>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm text-red-500">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="name" class="input-label">Nombre</label>
                    <div class="mt-2">
                        <input type="text" class="form-input" id="name" name="name" value="{{ $role->name }} "
                            readonly>

                    </div>
                    @error('name')
                        <p class="text-red-500 text-sm">{{$message}}</p>

                    @enderror
                </div>

                <div class="sm:col-span-6">

                    <h3 class="input-label">Asignar permisos</h3>
                    <p class="text-sm text-gray-500">El Rol debe tener asignado permisos para que sea válido. La primera columna son los modulos y las siguientes columnas son las acciones</p>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                            <thead class="text-xs text-gray-700 uppercase ">
                                <tr>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 ">
                                        Módulos
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Ver
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50 ">
                                        Editar
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Crear
                                    </th>
                                    <th scope="col" class="px-6 py-3 bg-gray-50">
                                        Eliminar
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($groupedPermissions as $module => $actions)

                                    @php
                                        $hasModule = isset($userGroupedPermissions[$module]);
                                    @endphp
                                    <tr class="border-b border-gray-200 ">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap bg-gray-50  ">
                                            {{ $module }}
                                        </th>
                                        @foreach ($availableActions as $key => $check)

                                            @php
                                                $hasAction = false;
                                                if($hasModule){

                                                    $hasAction = in_array($check, $userGroupedPermissions[$module]);
                                                }

                                            @endphp
                                            <td class="px-6 py-4 @if ($key % 2 != 0) bg-gray-50 @endif">
                                                <div class="flex h-6 shrink-0 items-center">
                                                    <div class="group grid size-4 grid-cols-1">
                                                        <input aria-describedby="permissions-description"
                                                            name="permissions[]" @if ($hasAction)
                                                                checked
                                                            @endif
                                                            value="{{ $module }} {{ $check }}" type="checkbox"
                                                            class="col-start-1 row-start-1 appearance-none rounded-sm border border-gray-300 bg-white checked:border-indigo-600 checked:bg-indigo-600 indeterminate:border-indigo-600 indeterminate:bg-indigo-600 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 disabled:border-gray-300 disabled:bg-gray-100 disabled:checked:bg-gray-100 forced-colors:appearance-auto">
                                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                                            viewBox="0 0 14 14" fill="none">
                                                            <path class="opacity-0 group-has-checked:opacity-100"
                                                                d="M3 8L6 11L11 3.5" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
                                                            <path class="opacity-0 group-has-indeterminate:opacity-100"
                                                                d="M3 7H11" stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round" />
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


                {{-- <div class="sm:col-span-6">
                    <label class="inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div
                            class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300  rounded-full peer  peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all  peer-checked:bg-blue-600">
                        </div>
                        <span class="ms-3 text-sm font-medium text-gray-900">Toggle me</span>
                    </label>
                </div> --}}







            </div>


            <div class="mt-4">
                <button class="p-2 bg-blue-500 font-medium text-white rounded cursor-pointer" type="submit">Actualizar rol</button>
            </div>
        </form>

    </div>



@endsection
