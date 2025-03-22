<!DOCTYPE html>
<html>

<head>
    <title>User List</title>
</head>

<body>
    <h1>User List</h1>
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
        </tr>
        @foreach ($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->nombre }}</td>
            <td>{{ $user->cedula }}</td>
            <td>{{ $user->sexo }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->nacimiento_fecha }}</td>
            <td>{{ $user->ingreso_fecha }}</td>
            <td>{{ $user->salida_fecha }}</td>
            <td>{{ $user->estado }}</td>
            <td>{{ $user->domicilio }}</td>
        </tr>
        @endforeach
    </table>
    <a href="{{ route('users.create') }}">Create New User</a>
</body>

</html>