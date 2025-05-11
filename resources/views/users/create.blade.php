@extends('layouts.admin-layout')

@section('title', 'Crear usuario')

@section('sidebar')
    @include('users.partials.sidebar')
@endsection

@section('content')
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-4xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
            <h1 class="text-3xl font-bold uppercase text-center mb-8 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Crear Usuario</h1>

            @if ($errors->any())
                <div class="rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100 mb-6">
                    <ul class="list-disc pl-5 space-y-1 text-blue-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div class="space-y-12">
                    <div class="border-b border-blue-200 pb-12">
                        <h2 class="text-lg font-semibold text-blue-700">Datos de acceso</h2>
                        <p class="mt-1 text-sm text-blue-500">Estos son las credenciales de acceso a la plataforma.</p>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="email" class="block text-sm font-medium text-blue-700">Email:</label>
                                <div class="mt-2">
                                    <input type="email" id="email" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="email" value="{{ old('email') }}" required>
                                </div>
                            </div>
                            <div class="sm:col-span-3"></div>
                            <div class="sm:col-span-3">
                                <label for="password" class="block text-sm font-medium text-blue-700">Contraseña:</label>
                                <div class="mt-2">
                                    <input type="password" id="password" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="password">
                                    <small class="text-blue-400">Dejar en blanco para mantener la contraseña actual</small>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="password_confirmation" class="block text-sm font-medium text-blue-700">Confirmar Contraseña:</label>
                                <div class="mt-2">
                                    <input type="password" id="password_confirmation" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="password_confirmation">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="role" class="block text-sm font-medium text-blue-700">Rol del empleado</label>
                                <div class="mt-2">
                                    <select id="role" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="role" required>
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                    @can('rol crear')
                                        <a class="text-blue-500 hover:text-blue-700 text-sm" href="{{ route('roles.create') }}">Crear rol</a>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-b border-blue-200 pb-12">
                        <h2 class="text-lg font-semibold text-blue-700">Datos del empleado</h2>
                        <p class="mt-1 text-sm text-blue-500">Información del empleado</p>
                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="nombre" class="block text-sm font-medium text-blue-700">Nombre</label>
                                <div class="mt-2">
                                    <input type="text" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="cedula" class="block text-sm font-medium text-blue-700">Cédula:</label>
                                <div class="mt-2">
                                    <input type="text" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" id="cedula" name="cedula" value="{{ old('cedula') }}" required>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="sexo" class="block text-sm font-medium text-blue-700">Sexo:</label>
                                <div class="mt-2">
                                    <select id="sexo" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="sexo" required>
                                        <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                                        <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="nacimiento_fecha" class="block text-sm font-medium text-blue-700">Fecha de Nacimiento:</label>
                                <div class="mt-2">
                                    <input type="date" id="nacimiento_fecha" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="nacimiento_fecha" value="{{ old('nacimiento_fecha') }}" required>
                                </div>
                            </div>
                            <div class="sm:col-span-6">
                                <label for="domicilio" class="block text-sm font-medium text-blue-700">Domicilio:</label>
                                <div class="mt-2">
                                    <input type="text" id="domicilio" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="domicilio" value="{{ old('domicilio') }}">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="cargo_id" class="block text-sm font-medium text-blue-700">Cargo:</label>
                                <div class="mt-2">
                                    <select id="cargo_id" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="cargo_id">
                                        <option value="0" disabled selected>-- SELECCIONE UN CARGO -- </option>
                                        @foreach ($cargos as $cargo)
                                            <option value="{{ $cargo->id }}" {{ old('cargo_id') }}>{{ $cargo->nombre }} - DPTO: {{ $cargo->departamento->nombre }}</option>
                                        @endforeach
                                    </select>
                                    @can('cargo crear')
                                        <a class="text-blue-500 hover:text-blue-700 text-sm" href="">Crear cargo</a>
                                    @endcan
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="ingreso_fecha" class="block text-sm font-medium text-blue-700">Fecha de Ingreso:</label>
                                <div class="mt-2">
                                    <input type="date" id="ingreso_fecha" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" name="ingreso_fecha" value="{{ old('ingreso_fecha') }}">
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input type="checkbox" class="form-check-input" id="aplica_bonificacion_familiar" name="aplica_bonificacion_familiar">
                                <label class="form-check-label text-blue-700" for="aplica_bonificacion_familiar">Aplica bonificación familiar</label>
                            </div>
                            <div id="hijos-section" style="display: none;" class="sm:col-span-6">
                                <h5 class="text-lg font-semibold mt-4 text-blue-700">Hijos</h5>
                                <button type="button" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2" onclick="agregarHijo()">Agregar hijo</button>
                                <div id="hijos-wrapper"></div>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="fill-test-data" class="p-2 bg-gray-500 font-medium text-white rounded mb-4">Rellenar datos de prueba</button>
                    <div class="mt-4">
                        <button class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition" type="submit">Crear usuario</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('fill-test-data').addEventListener('click', function() {

            const plus = 5;

            // Fill text inputs
            document.getElementById('email').value = `test${plus}@example.com`;
            document.getElementById('password').value = 'password123';
            document.getElementById('password_confirmation').value = 'password123';
            document.getElementById('nombre').value = 'Juan Perez';
            document.getElementById('cedula').value = 90000000 + plus;
            document.getElementById('domicilio').value = 'Asuncion, Paraguay';

            // Fill select inputs
            document.getElementById('sexo').value = 'M';
            document.getElementById('cargo_id').value = 1; // Replace with a valid cargo ID

            document.getElementById('role').value = 'asistenteRRHH';

            // Fill date inputs
            document.getElementById('nacimiento_fecha').value = '1990-01-01';
            document.getElementById('ingreso_fecha').value = '2025-01-01';
        });
    </script>
    <script>
        const bonifCheckbox = document.getElementById('aplica_bonificacion_familiar');
        const hijosSection = document.getElementById('hijos-section');
        let hijoIndex = 0;

        bonifCheckbox.addEventListener('change', function() {
            hijosSection.style.display = this.checked ? 'block' : 'none';
        });

        function agregarHijo() {
            const wrapper = document.getElementById('hijos-wrapper');
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = `
            <div class="form-row grid grid-cols-2 gap-4">
                <div>
                    <input type="text" class="form-input" name="hijos[${hijoIndex}][nombre]" placeholder="Nombre del hijo" required>
                </div>
                <div>
                    <input type="date" class="form-input" name="hijos[${hijoIndex}][fecha_nacimiento]" required>
                </div>
            </div>
        `;
            wrapper.appendChild(div);
            hijoIndex++;
        }
    </script>


@endsection
