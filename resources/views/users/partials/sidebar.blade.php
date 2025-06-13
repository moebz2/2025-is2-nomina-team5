<div
    class="sticky border-r border-gray-950/5 top-14 z-10 flex h-full max-h-[calc(100dvh---spacing(14))] flex-col bg-white">
    <div class="flex-1 overflow-y-auto p-6" data-autoscroll="true">
        <ul class="flex flex-col gap-8" role="list">
            <li>
                <ul class="flex flex-col gap-2" role="list">
                    <li>
                        <a @if (request()->is('admin/users')) aria-current="true" @endif
                            class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{ route('users.index') }}">
                            {{-- Agregar icono con span o i --}}
                            <i class="material-symbols-outlined">list</i>
                            Lista de usuarios
                        </a>
                    </li>
                    <li>
                        <a @if (request()->is('admin/users/create')) aria-current="true" @endif
                            class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                            href="{{ route('users.create') }}">
                            <i class="material-symbols-outlined">add</i>
                            Crear usuario
                        </a>
                    </li>

                    @if (isset($user))
                        <li>
                            <a aria-current="true"
                                class="inline-flex items-center gap-3 text-base/8 text-gray-600 hover:text-gray-950 sm:text-sm/7 **:text-gray-400 **:data-highlight:fill-white **:[svg]:size-5 **:[svg]:sm:size-4 aria-[current]:font-semibold aria-[current]:text-gray-950 aria-[current]:**:text-gray-950 aria-[current]:**:data-highlight:fill-gray-300 hover:**:text-gray-950 hover:**:data-highlight:fill-gray-300"
                                href="">
                                <i class="material-symbols-outlined">badge</i>
                                {{ $user->nombre }}
                            </a>
                        </li>
                    @endif


                </ul>
            </li>
        </ul>
    </div>
    <div class="border-t border-gray-950/5 px-3 py-2">
        <h4 class="font-medium text-sm">Recomendaciones</h4>



        @if (request()->is('admin/users'))
            <p class="text-sm text-gray-500">
                Las acciones en la lista de empleados permiten editar, dar de baja o ver los datos del empleado
            </p>
            <p class="text-sm text-gray-500">

            </p>
        @elseif (request()->is('admin/users/create'))
            <p class="text-sm text-gray-500">
                Al crear un usuario es importante asignarle el rol correcto para proteger los recursos a los que puede
                acceder
            </p>
            <p class="text-sm text-gray-500">
                No olvides de rellenar todos los campos requeridos
            </p>
        @else
            <p class="text-sm text-gray-500">
                Puedes agregar movimientos, conceptos, préstamos e hijos directamente en el perfil del usuario. También
                modificar el salario o el estado actual del empleado.
            </p>
            <p class="text-sm text-gray-500">

            </p>
        @endif
    </div>
</div>
