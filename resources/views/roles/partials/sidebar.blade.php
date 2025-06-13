<div class="sticky border-r border-gray-950/5 top-14 z-10 flex h-full max-h-[calc(100dvh---spacing(14))] flex-col bg-white">
    <div class="flex-1 overflow-y-auto p-6" data-autoscroll="true">
        <ul class="flex flex-col gap-8" role="list">
            <li>
                <ul class="flex flex-col gap-2" role="list">
                    <li>
                        <a @if(Route::currentRouteName() == 'roles.index') aria-current="true" @endif
                            class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{route('roles.index')}}">
                            {{-- Agregar icono con span o i --}}
                            Administrar roles
                        </a>
                    </li>
                    <li>
                        <a @if(Route::currentRouteName() == 'roles.create') aria-current="true" @endif class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{route('roles.create')}}">
                            Crear rol
                        </a>
                    </li>
                    <li>
                        <a class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="#">
                            Otras opciones
                        </a>
                    </li>

                </ul>
            </li>
        </ul>
    </div>
    <div class="border-t border-gray-950/5 px-3 py-2">
        <h4 class="font-medium text-sm">Recomendaciones</h4>
        <p class="text-sm text-gray-500">
            Los roles permiten limitar las acciones de los usuarios.
        </p>
        <p class="text-sm text-gray-500">
            Administre los permisos de cada rol y asigne un rol al usuario
        </p>
    </div>
</div>
