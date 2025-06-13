@extends('layouts.admin-layout')

@section('title', 'Crear usuario')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')

    <div class="container p-10 mx-auto">

        <h1 class="text-3xl font-bold uppercase">Crear Usuario</h1>


        @include('layouts.partials.banner-message')

        @include('layouts.partials.validation-message')
        <div class="h-10"></div>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf


            <div class="space-y-12">
                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Datos de acceso</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">Estos son las credenciales de acceso a la plataforma.</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">


                        <div class="sm:col-span-3">
                            <label for="email" class="input-label">Email:</label>
                            <div class="mt-2">
                                <input type="email" id="email" class="form-input" name="email"
                                    value="{{ old('email') }}" required>
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

                            <div class="mt-2">


                                <select id="role" class="form-select" name="role" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @can('rol crear')
                                    <a class="text-blue-500 hover:text-blue-700 text-sm"
                                        href="{{ route('roles.create') }}">Crear
                                        rol</a>
                                @endcan
                            </div>

                        </div>
                    </div>

                </div>

                <div class="border-b border-gray-900/10 pb-12">
                    <h2 class="text-base/7 font-semibold text-gray-900">Datos del empleado</h2>
                    <p class="mt-1 text-sm/6 text-gray-600">Información del empleado</p>

                    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                        <div class="sm:col-span-3">
                            <label for="nombre" class="input-label">Nombre</label>
                            <div class="mt-2">
                                <input type="text" class="form-input" id="nombre" name="nombre"
                                    value="{{ old('nombre') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="cedula" class="input-label">Cédula:</label>
                            <div class="mt-2">
                                <input type="text" class="form-input" id="cedula" name="cedula"
                                    value="{{ old('cedula') }}" required>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="sexo" class="input-label">Sexo:</label>
                            <div class="mt-2">
                                <select id="sexo" class="form-select" name="sexo" required>
                                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino
                                    </option>
                                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label for="nacimiento_fecha" class="input-label">Fecha de Nacimiento:</label>
                            <div class="mt-2">
                                <input type="date" id="nacimiento_fecha" class="form-input" name="nacimiento_fecha"
                                    value="{{ old('nacimiento_fecha') }}" required>
                            </div>
                        </div>

                        <div class="sm:col-span-6">
                            <label for="domicilio" class="input-label">Domicilio:</label>
                            <div class="mt-2">
                                <input type="text" id="domicilio" class="form-input" name="domicilio"
                                    value="{{ old('domicilio') }}">
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="cargo_id" class="input-label">Cargo:</label>
                            <div class="mt-2">
                                <select id="cargo_id" class="form-select" name="cargo_id">
                                    <option value="0" disabled selected>-- SELECCIONE UN CARGO -- </option>
                                    @foreach ($cargos as $cargo)
                                        <option value="{{ $cargo->id }}" {{ old('cargo_id') }}>
                                            {{ $cargo->nombre }} - DPTO: {{ $cargo->departamento->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @can('cargo crear')
                                <p class="mt-1 text-sm/6 text-gray-600">
                                    Si no aparece en la lista, puedes
                                    <a class="text-blue-500 hover:text-blue-700" href="{{ route('cargos.create') }}">crear cargo aquí</a>
                                </p>
                                @endcan
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="ingreso_fecha" class="input-label">Fecha de Ingreso:</label>
                            <div class="mt-2">
                                <input type="date" id="ingreso_fecha" class="form-input" name="ingreso_fecha"
                                    value="{{ old('ingreso_fecha') }}">
                            </div>
                        </div>


                    </div>

                </div>

                <button type="button" id="fill-test-data" class="p-2 bg-gray-500 font-medium text-white rounded">
                    Rellenar datos de prueba
                </button>

                <div class="mt-4">
                    <button class="p-2 bg-blue-500 font-medium text-white rounded" type="submit">Crear usuario</button>
                </div>

            </div>


        </form>

    </div>




@endsection
