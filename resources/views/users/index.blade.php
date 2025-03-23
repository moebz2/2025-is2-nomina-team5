<!DOCTYPE html>
<html>

<head>
    <title>Lista de Usuarios</title>
</head>

<body>
    <h1>Lista de Usuarios</h1>
    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Cédula</th>
            <th>Sexo</th>
            <th>Email</th>
            <th>Nacimiento Fecha</th>
            <th>Ingreso Fecha</th>
            <th>Salida Fecha</th>
            <th>Estado</th>
            <th>Domicilio</th>
            <th>Departamento</th>
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->nombre }}</td>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->sexo }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->nacimiento_fecha }}</td>
            <td>{{ $user->empleado->fecha_ingreso ?? 'NA' }}</td>
            <td>{{ $user->empleado->fecha_egreso ?? 'NA' }}</td>
            <td>{{ $user->estado }}</td>
            <td>{{ $user->domicilio }}</td>
            <td>{{ $user->empleado->departamento->nombre ?? 'NA' }}</td>
        </tr>
        @endforeach
    </table>
    <a href="{{ route('users.create') }}">Registrar nuevo usuario</a>
</body>

</html>