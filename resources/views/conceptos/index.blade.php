<div class="container mx-auto p-10">

    @include('layouts.partials.banner-message')

    <h1 class="text-3xl font-medium uppercase">Lista de Conceptos</h1>

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Nombre
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Tipo
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">IPS
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        Aguinaldo</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">Estado
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        Acciones</th>
                </thead>
                @foreach ($conceptos as $concepto)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $concepto->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $concepto->nombre }}</td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            @if ($concepto->es_debito)
                                <span
                                    class="rounded-lg bg-red-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-red-900">Débito</span>
                            @else
                                <span
                                    class="rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-900">Crédito</span>
                            @endif
                        </td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            @if ($concepto->ips_incluye)
                                <span
                                    class="rounded-lg bg-purple-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-purple-700 ">Sí</span>
                            @else
                                <span
                                    class="rounded-lg bg-yellow-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-yellow-700 ">No</span>
                            @endif
                        </td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            @if ($concepto->aguinaldo_incluye)
                                <span
                                    class="rounded-lg bg-indigo-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-indigo-700 ">Sí</span>
                            @else
                                <span
                                    class="rounded-lg bg-amber-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-amber-700 ">No</span>
                            @endif
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">
                            @if ($concepto->estado)
                                <span
                                    class="rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-700 ">Activo</span>
                            @else
                                <span
                                    class="rounded-lg bg-red-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-red-700 ">Inactivo</span>
                            @endif
                        </td>

                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-500">
                            @if ($concepto->es_modificable)
                                @can('concepto editar')
                                    <a href="{{ route('conceptos.edit', $concepto->id) }}"
                                        class="hover:text-gray-700 cursor-pointer">
                                        <i class="material-symbols-outlined">edit</i>
                                    </a>
                                @endcan

                                @can('concepto eliminar')
                                    <form action="{{ route('conceptos.destroy', $concepto->id) }}" method="POST"
                                        onsubmit="return confirm('¿Está seguro de que desea dar de baja este concepto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar" type="submit"
                                            class="hover:text-red-500 block text-left cursor-pointer">
                                            <i class="material-symbols-outlined">delete</i>
                                        </button>
                                    </form>
                                @endcan
                            @else
                                Estaticos
                            @endif


                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    <div class="mt-4">
        <a href="{{ route('conceptos.create') }}" class="bg-blue-500 p-2 rounded text-white font-medium">Crear nuevo
            concepto</a>
    </div>
</div>
