<div x-show="tab == 'prestamos'">

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400">ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500">Monto
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500">Estado
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500">Fecha de
                        creación</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500">Acciones
                    </th>
                </thead>

                @foreach ($user->prestamos ?? [] as $prestamo)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $prestamo->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            Gs. {{ number_format($prestamo->monto, 0, ',', '.') }}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">{{ $prestamo->estado }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">{{ $prestamo->generacion_fecha }}
                        </td>
                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-700">

                            @can('prestamo eliminar')
                                <form action="{{ route('prestamos.destroy', $prestamo->id) }}" method="POST"
                                    onsubmit="return confirm('¿Está seguro de que desea cancelar este préstamo? Ya no se generarán cuotas a cobrar.');">
                                    @csrf
                                    @method('DELETE')
                                    <button title="Cancelar" type="submit"
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

    <div class="flex justify-start mt-4">
        <button x-show="!prestamoForm" x-on:click="prestamoForm = true"
            class="px-2 py-1 flex items-center bg-blue-500 rounded text-medium hover:bg-blue-700 text-white">
            <span class="material-symbols-outlined">add</span>
            Nuevo préstamo
        </button>
    </div>

    <div x-show="prestamoForm" class="p-4 bg-gray-100 rounded">
        <h3 class="text-xl font-medium">Registrar nuevo préstamo</h3>
        <form action="{{ route('prestamos.store') }}" method="POST">
            @csrf
            <input type="text" value="{{ $user->id }}" name="empleado_id" hidden>
            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                    <input type="number" name="monto" id="monto" class="form-input" required>
                </div>
            </div>
            <div class="mt-10 flex gap-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar préstamo
                </button>
                <button x-show="prestamoForm" x-on:click="prestamoForm = false"
                    class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">
                    Cancelar
                </button>
            </div>
        </form>
    </div>
</div>
