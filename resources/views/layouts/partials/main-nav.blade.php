<a class="shrink-0" aria-label="Home" href="/">
    <h2 class="font-bold uppercase">Nomina IS2</h2>
</a>
@if(empty($isExport))
<div class="@container flex flex-1 justify-start pl-8 gap-5">
    @can('empleado ver')

    <a class="text-sm/6 text-gray-950" href="#">Empleados</a>
    @endcan
    @can('liquidacion ver')

    <a class="text-sm/6 text-gray-950" href="#">Liquidaciones</a>
    @endcan





    @can('departamento ver')

    <a class="text-sm/6 text-gray-950" href="{{route('departamentos.index')}}">Departamentos</a>
    @endcan


    <a class="text-sm/6 aria-[current]:font-semibold aria-[current]:text-gray-950 text-gray-950" @if (request()->is('admin/conceptos/*')) aria-current="true" @endif href="{{route('conceptos.index')}}">Conceptos</a>

    <a class="text-sm/6 text-gray-950" href="{{route('liquidacion.index')}}">Liquidaciones</a>

</div>
<div class="flex items-center gap-5 max-md:hidden lg:gap-6">

    <a class="text-sm/6 text-gray-950" href="{{route('configuracion.index')}}">Configuración</a>

    @can('usuario ver')

    <a  @if (request()->is('admin/users/*'))
        aria-current="true"
    @endif class="text-sm/6 aria-[current]:font-semibold aria-[current]:text-gray-950 text-gray-950" href="{{route('users.index')}}">Usuarios</a>
    @endcan
    @can('rol ver')

    <a @if (request()->is('admin/roles/*'))
        aria-current="true"
    @endif class="text-sm/6 aria-[current]:font-semibold aria-[current]:text-gray-950 text-gray-950" href="{{route('roles.index')}}">Roles</a>
    @endcan

    {{-- SEPARADOR VERTICAL --}}
    <div class="h-6 w-px bg-gray-950/10"></div>
    <a class="text-sm/6 text-gray-950" href="/plus/login">Mi perfil</a>

    <form action="{{route('logout')}}" method="POST">

        @csrf

        <button type="submit" class="rounded-full cursor-pointer bg-gray-950 px-2.5 py-0.5 text-sm/6 font-medium text-white focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-950">
            Cerrar sesión
        </button>
    </form>
</div>
{{-- MENU PANTALLAS PEQUEÑAS --}}
<div class="flex items-center gap-2.5 md:hidden">

        <button type="button"
        class="relative inline-grid size-7 place-items-center rounded-md text-gray-950 hover:bg-gray-950/5"
        aria-label="Navigation"><span
            class="absolute top-1/2 left-1/2 size-11 -translate-1/2 [@media(pointer:fine)]:hidden"></span><svg
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"
            data-slot="icon" class="size-4">
            <path
                d="M8 2a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM8 6.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM9.5 12.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z">
            </path>
        </svg></button>
</div>
@endif