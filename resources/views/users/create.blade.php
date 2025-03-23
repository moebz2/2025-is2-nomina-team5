<!DOCTYPE html>
<html>

<head>
    <title>Crear Usuario</title>
</head>

<body>
    <h1>Crear Usuario</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label for="cedula">Cédula:</label>
            <input type="text" id="cedula" name="cedula" value="{{ old('cedula') }}" required>
        </div>
        <div>
            <label for="sexo">Sexo:</label>
            <select id="sexo" name="sexo" required>
                <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
            </select>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirmar Contraseña:</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>
        <div>
            <label for="nacimiento_fecha">Fecha de Nacimiento:</label>
            <input type="date" id="nacimiento_fecha" name="nacimiento_fecha" value="{{ old('nacimiento_fecha') }}" required>
        </div>
        <div>
            <label for="ingreso_fecha">Fecha de Ingreso:</label>
            <input type="date" id="ingreso_fecha" name="ingreso_fecha" value="{{ old('ingreso_fecha') }}" required>
        </div>
        <div>
            <label for="domicilio">Domicilio:</label>
            <input type="text" id="domicilio" name="domicilio" value="{{ old('domicilio') }}">
        </div>
        <div>
            <label for="departamento_id">Departamento:</label>
            <select id="departamento_id" name="departamento_id" required>
                @foreach ($departamentos as $departamento)
                <option value="{{ $departamento->id }}" {{ old('departamento_id') == $departamento->id ? 'selected' : '' }}>
                    {{ $departamento->nombre }}
                </option>
                @endforeach
            </select>
        </div>
        <div>
            <button type="submit">Crear</button>
        </div>
    </form>
</body>

</html>