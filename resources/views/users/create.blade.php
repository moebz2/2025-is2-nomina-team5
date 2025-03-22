<!DOCTYPE html>
<html>

<head>
    <title>Create User</title>
</head>

<body>
    <h1>Create User</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required><br>

        <label for="cedula">Cédula:</label>
        <input type="text" name="cedula" id="cedula" value="{{ old('cedula') }}" required><br>

        <label for="sexo">Sexo:</label>
        <select name="sexo" id="sexo" required>
            <option value="">Select</option>
            <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
            <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
        </select><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="password_confirmation">Confirmar contraseña:</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required><br>

        <label for="nacimiento_fecha">Fecha de nacimiento:</label>
        <input type="date" name="nacimiento_fecha" id="nacimiento_fecha" value="{{ old('nacimiento_fecha') }}" required><br>

        <label for="ingreso_fecha">Fecha de ingreso:</label>
        <input type="date" name="ingreso_fecha" id="ingreso_fecha" value="{{ old('ingreso_fecha') }}" required><br>

        <label for="salida_fecha">Fecha de salida:</label>
        <input type="date" name="salida_fecha" id="salida_fecha" value="{{ old('salida_fecha') }}"><br>

        <label for="domicilio">Domicilio:</label>
        <input type="text" name="domicilio" id="domicilio" value="{{ old('domicilio') }}"><br>

        <button type="submit">Crear usuario</button>
    </form>

    <a href="{{ route('users.index') }}">Back to User List</a>
</body>

</html>