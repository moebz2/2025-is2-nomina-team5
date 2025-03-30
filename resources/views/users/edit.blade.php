@extends('layouts.admin-layout')

@section('title', 'Editar usuario')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')

    <div class="container p-10 mx-auto">

        <h1 class="text-3xl font-bold uppercase">Editar Usuario</h1>

        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="h-10"></div>

        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Datos de acceso</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">Estos son las credenciales de acceso a la plataforma del empleado</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">


                        <div class="sm:col-span-3">
                            <label for="email" class="input-label">Email:</label>
                            <div class="mt-2">
                                <input type="email" id="email" class="form-input" name="email"
                                    value="{{ old('email', $user->email) }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3"></div>
                        <div class="sm:col-span-3">
                            <label for="password" class="input-label">Contraseña:</label>
                            <div class="mt-2">
                                <input type="password" id="password" class="form-input" name="password">
                                <small>Dejar en blanco para mantener la contraseña actual</small>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="password_confirmation" class="input-label">Confirmar Contraseña:</label>
                            <div class="mt-2">
                                <input type="password" id="password_confirmation" class="form-input"
                                    name="password_confirmation">
                            </div>
                        </div>


                        <div class="sm:col-span-3">
                            <label for="role" class="input-label">Rol del empleado</label>
                            <p class="text-sm text-gray-700">Presione CTL para seleccionar mas de una opción</p>
                            <div class="mt-2">


                                <select id="role" class="form-select" name="role" required>
                                    <option value="" disabled>-- SELECCIONE UN ROL -- </option>
                                    @foreach ($roles as $role)
                                        @php

                                            $hasRole = $user->hasRole($role->name);

                                        @endphp
                                        <option value="{{ $role->name }}" @if ($hasRole) selected @endif>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @can('rol crear')
                                    <a class="text-blue-500 hover:text-blue-700 text-sm" href="{{ route('roles.create') }}">Crear
                                        rol</a>
                                @endcan
                            </div>

                        </div>
                    </div>

                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Datos del empleado</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">Es la información publica del empleado</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="nombre" class="input-label">Nombre</label>
                            <div class="mt-2">
                                <input type="text" class="form-input" id="nombre" name="nombre"
                                    value="{{ old('nombre', $user->nombre) }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="cedula" class="input-label">Cédula:</label>
                            <div class="mt-2">
                                <input type="text" class="form-input" id="cedula" name="cedula"
                                    value="{{ old('cedula', $user->cedula) }}" required>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="sexo" class="input-label">Sexo:</label>
                            <div class="mt-2">
                                <select id="sexo" class="form-select" name="sexo" required>
                                    <option value="M" {{ old('sexo', $user->sexo) == 'M' ? 'selected' : '' }}>Masculino
                                    </option>
                                    <option value="F" {{ old('sexo', $user->sexo) == 'F' ? 'selected' : '' }}>Femenino
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="nacimiento_fecha" class="input-label">Fecha de Nacimiento:</label>
                            <div class="mt-2">
                                <input type="date" id="nacimiento_fecha" class="form-input" name="nacimiento_fecha"
                                    value="{{ old('nacimiento_fecha', $user->fecha_nacimiento) }}" required>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="ingreso_fecha" class="input-label">Fecha de Ingreso:</label>
                            <div class="mt-2">

                                <input type="date" id="ingreso_fecha" class="form-input" name="ingreso_fecha"
                                    value="{{ old('ingreso_fecha', $user->fecha_ingreso) }}"
                                    required>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="domicilio" class="input-label">Domicilio:</label>
                            <div class="mt-2">
                                <input type="text" id="domicilio" class="form-input" name="domicilio"
                                    value="{{ old('domicilio', $user->domicilio) }}">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="cargo_id" class="input-label">Cargo:</label>
                            <div class="mt-2">
                                <select id="cargo_id" class="form-select" name="cargo_id" required>
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}">
                                            {{ $cargo->nombre }} - DTO: {{$cargo->departamento->nombre}}
                                        </option>
                                    @endforeach
                                </select>
                                @can('cargo crear')
                                    <a class="text-blue-500 hover:text-blue-700 text-sm"
                                        href="">Crear cargo</a>
                                @endcan
                            </div>
                        </div>





                    </div>

                </div>

                <div class="mt-4">
                    <button class="p-2 bg-blue-500 font-medium text-white rounded" type="submit">Actualizar</button>
                </div>

            </div>


        </form>

    </div>

@endsection
