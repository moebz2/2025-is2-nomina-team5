
    <div class="container mx-auto p-10">
        @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50"
                role="alert">
                <span class="font-medium">Exito!</span> {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 " role="alert">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
        @endif
        <h1 class="text-3xl font-medium uppercase">Lista de Cargos</h1>

        <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
            <div class="my-8 overflow-hidden">
                <table class="w-full table-auto border-collapse text-sm">
                    <thead>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">ID</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Nombre
                        </th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Descripción
                        </th>

                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Estado
                        </th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                            Acciones</th>
                    </thead>
                    @foreach ($cargos as $cargo)
                        <tr>
                            <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $cargo->id }}</td>
                            <td class="border-b border-gray-100 p-4 pl-8 text-black">{{ $cargo->nombre }}</td>
                            <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                               {{ $cargo->descripcion }}
                            </td>

                            <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                                @if ($cargo->estado)
                                    <span
                                        class="rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-700 ">Activo</span>
                                @else
                                    <span
                                        class="rounded-lg bg-red-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-red-700 ">Inactivo</span>
                                @endif
                            </td>

                            <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-500">

                                    @can('cargo editar')
                                        <a href="{{ route('cargos.edit', $cargo->id) }}"
                                            class="hover:text-gray-700 cursor-pointer">
                                            <i class="material-symbols-outlined">edit</i>
                                        </a>
                                    @endcan

                                    @can('cargo eliminar')
                                        <form action="{{ route('cargos.destroy', $cargo->id) }}" method="POST"
                                            onsubmit="return confirm('¿Está seguro de que desea dar de baja este cargo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button title="Eliminar" type="submit"
                                                class="hover:text-red-500 block text-left cursor-pointer">
                                                <i class="material-symbols-outlined">delete</i>
                                            </button>
                                        </form>
                                    @endcan


                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="mt-4">
            <a href="{{ route('cargos.create') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Crear nuevo
                cargo</a>
        </div>
    </div>
