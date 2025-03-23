<!DOCTYPE html>
<html>
<head>
    <title>Crear Departamento</title>
</head>
<body>
    <h1>Crear Departamento</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departamentos.store') }}" method="POST">
        @csrf
        <div>
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
        </div>
        <div>
            <label for="descripcion">Descripción:</label>
            <textarea id="descripcion" name="descripcion">{{ old('descripcion') }}</textarea>
        </div>
        <div>
            <button type="submit">Crear</button>
        </div>
    </form>
</body>
</html>