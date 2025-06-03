<div x-show="tab == 'hijos'">




    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Nombre
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Nacimiento
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Edad</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Menor
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Acciones</th>
                </thead>

                @foreach ($user->hijos as $hijo)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $hijo->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-black">{{ $hijo->nombre }}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">

                            {{$hijo->fecha_nacimiento}}

                        </td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            {{ $hijo->edad}}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">


                        @if ($hijo->esMenorDe18())
                        <span
                        class="rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-700 ">Si</span>
                        @else
                        <span
                        class="rounded-lg bg-yellow-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-yellow-700 ">No</span>
                        @endif


                        </td>

                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-700">


                            @can('hijos eliminar')
                                <form action="" method="POST"
                                    onsubmit="return confirm('¿Está seguro de que desea dar de baja este concepto?');">
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

    <div class="flex jusitfy-end mt-4">
        <button x-show="!hijoForm" x-on:click="hijoForm = true"
            class="px-2 py-1 flex items-center bg-blue-500 rounded text-medium hover:bg-blue-700 text-white">
            <span class="material-symbols-outlined">add</span>
            Agregar hijo
        </button>

    </div>

    <div x-show="hijoForm" class="p-4 bg-gray-100 rounded" style="display: none">

        <h3 class="text-xl font-medium">Agregar hijo</h3>

        <form action="{{route('users.agregarHijo', $user->id)}}" method="POST">
            @csrf


            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <input type="text" value="{{ $user->id }}" name="empleado_id" hidden>



                <div class="sm:col-span-3">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                    <div class="mt-2">
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="form-input">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="fecha_nacimiento" class="block text-sm font-medium text-gray-700">Fecha de nacimiento</label>
                    <div class="mt-2">
                        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}"
                            required class="form-input">
                    </div>
                </div>





            </div>
            <div class="mt-10 flex gap-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar
                </button>
                <button x-show="hijoForm" x-on:click="hijoForm = false"
                    class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">

                    Cancelar
                </button>
            </div>
        </form>
    </div>




</div>
