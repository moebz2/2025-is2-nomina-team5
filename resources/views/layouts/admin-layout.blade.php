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

    {{-- TIPOGRAFIA --}}
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    {{-- ICONOS --}}

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,300,0,-25" />

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


    {{-- Para incluir otras librerias desde cada vista se debe incluir mediante @push('nombre_seccion') --}}

    {{-- OTROS ESTILOS CSS --}}
    @stack('pushcss')

    {{-- OTRAS LIBRERIAS JS --}}
    @stack('pushjs')


    <title>IS2 G5 - @yield('title', 'Administrativo')</title>
</head>

<body>

    <div id="app">

        <header
            class="line-b fixed inset-x-0 top-0 z-20 flex h-14 items-center justify-between bg-white px-4 after:-bottom-px border-b border-gray-200 sm:px-6">

            @include('layouts.partials.main-nav')

        </header>


        <main class="flex min-h-dvh flex-col pt-14">
            <div
            class="isolate grid flex-1 grid-rows-[1fr_auto] overflow-clip
            [--gutter-width:theme('spacing.6')] 2xl:[--gutter-width:theme('spacing.10')]
            @hasSection('sidebar')
                grid-cols-[var(--sidebar-width)_var(--gutter-width)_auto_var(--gutter-width)] [--sidebar-width:theme('spacing.0')] 2xl:[--sidebar-width:theme('spacing.72')]
            @else
                grid-cols-[auto_var(--gutter-width)] [--sidebar-width:theme('spacing.0')]
            @endif ">
                {{-- SIDEBAR --}}

                @hasSection ('sidebar') 
                    
                    <div class="col-start-1 row-span-2 row-start-1 max-2xl:hidden">
                        @section('sidebar')
                        @show
                        
                    </div>
                @endif
                {{-- MAIN CONTENT --}}
                <div class="@hasSection('sidebar') col-start-3 @endif  row-start-1 max-sm:col-span-full max-sm:col-start-1">
                    @section('content')
                    @show
                </div>
                <footer
                class="@hasSection('sidebar') col-start-3 @else col-start-1 @endif
                row-start-2 max-sm:col-span-full max-sm:col-start-1 @container mb-16 grid w-full px-4 sm:px-2">
                    @section('footer')
                    @show
                </footer>
            </div>
        </main>


    </div>

    @stack('scripts')

</body>

</html>
