<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- ESTILOS Y LIBRERIA JS COMPARTIDAS

    Para compilar los archivos se debe ejecutar
    bash > npm run build
    Cara compilar dinamicamente los archivos
    bash > npm run dev
    --}}

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    {{-- Para incluir otras librerias desde cada vista se debe incluir mediante @push('nombre_seccion') --}}

    {{-- OTROS ESTILOS CSS --}}
    @stack('pushcss')

    {{-- OTRAS LIBRERIAS JS --}}
    @stack('pushjs')


    <title>IS2 G5 - @yield('title', 'Liquidaciones')</title>
</head>

<body>

    @section('navigation')

    @show




    @section('content')
    @show


</body>

</html>
