<nav class="w-full flex items-center justify-between px-4 sm:px-8 py-1.5 bg-white/70 backdrop-blur-[8px] shadow-[0_2px_16px_0_rgba(30,64,175,0.07)] border-b border-blue-100/40 rounded-b-2xl">
    <a class="shrink-0 flex items-center gap-2" aria-label="Home" href="/">
        <h2 class="font-bold uppercase text-xl sm:text-2xl bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent tracking-wide drop-shadow-sm select-none">Nomina IS2</h2>
    </a>
    @if(empty($isExport))
    <div class="flex flex-1 justify-start pl-4 sm:pl-8 gap-2 sm:gap-4">
        @can('concepto ver')
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/conceptos*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('conceptos.index')}}">Conceptos</a>
        @endcan
        @can('liquidacion ver')
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/liquidacion*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('liquidacion.index')}}">Liquidaciones</a>
        @endcan
        @can('cargo ver')
        <a href="#" class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 text-blue-900">Cargos</a>
        @endcan
        @can('departamento ver')
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/departamentos*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('departamentos.index')}}">Departamentos</a>
        @endcan
    </div>
    <div class="flex items-center gap-2 sm:gap-4 max-md:hidden">
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/configuracion*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('configuracion.index')}}">Configuración</a>
        @can('usuario ver')
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/users*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('users.index')}}">Usuarios</a>
        @endcan
        @can('rol ver')
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 {{ request()->is('admin/roles*') ? 'bg-blue-100/80 text-blue-800 font-semibold' : 'text-blue-900' }}" href="{{route('roles.index')}}">Roles</a>
        @endcan
        <div class="h-6 w-px bg-blue-100/60 mx-1"></div>
        <a class="px-3 py-1 rounded-lg text-base font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-blue-200/60 hover:bg-blue-100/60 hover:text-blue-800 text-blue-900" href="/plus/login">Mi perfil</a>
        <form action="{{route('logout')}}" method="POST" class="ml-1">
            @csrf
            <button type="submit" class="rounded-full cursor-pointer bg-gradient-to-r from-blue-600 to-blue-400 px-4 py-1.5 text-base font-semibold text-white shadow hover:from-blue-700 hover:to-blue-500 transition focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                Cerrar sesión
            </button>
        </form>
    </div>
    <!-- Menú móvil -->
    <div class="flex items-center gap-2.5 md:hidden">
        <button type="button"
            class="relative inline-grid size-8 place-items-center rounded-xl text-blue-900 hover:bg-blue-100/60 transition"
            aria-label="Navigation">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path fill-rule="evenodd" d="M4 6h16M4 12h16M4 18h16" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
    @endif
</nav>