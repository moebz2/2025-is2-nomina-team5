<div>




    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Periodo
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Estado
                    </th>
                    {{--  <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Calculos</th> --}}
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Acciones</th>
                </thead>

                @foreach ($user->liquidaciones as $liquidacion)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $liquidacion->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-black">
                            {{ \Illuminate\Support\Str::ucfirst(\Carbon\Carbon::parse($liquidacion->periodo)->locale('es')->translatedFormat('F/Y')) }}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            @if (strcmp($liquidacion->estado, 'pendiente') == 0)
                                <span
                                    class="rounded-lg bg-gray-200 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-gray-700 ">Pendiente</span>
                            @else
                                <span
                                    class="rounded-lg bg-green-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-green-700 ">Aceptado</span>
                            @endif
                        </td>

                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-700">

                            @can('liquidacion editar')
                                <a href="" class="hover:text-gray-700 cursor-pointer">
                                    <i class="material-symbols-outlined">edit</i>
                                </a>
                            @endcan

                            @can('liquidacion eliminar')
                                <button title="Eliminar" type="submit"
                                    class="hover:text-red-500 block text-left cursor-pointer">
                                    <i class="material-symbols-outlined">delete</i>
                                </button>
                            @endcan



                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    {{-- <div class="flex jusitfy-end mt-4">
        <button x-show="!conceptoForm" x-on:click="conceptoForm = true"
            class="px-2 py-1 flex items-center bg-blue-500 rounded text-medium hover:bg-blue-700 text-white">
            <span class="material-symbols-outlined">add</span>
            Agregar liquidacion
        </button>

    </div> --}}






</div>
