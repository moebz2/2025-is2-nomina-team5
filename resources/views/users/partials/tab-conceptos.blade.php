<div x-show="tab == 'conceptos'">




    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        ID</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Nombre
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Valor
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Calculos</th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Vigencia
                    </th>
                    <th class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Acciones</th>
                </thead>

                @foreach ($user->conceptos as $concepto)
                    <tr>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $concepto->id }}</td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-black">{{ $concepto->nombre }}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">

                            Gs. {{ number_format($concepto->pivot->valor, 0, ',', '.') }}

                        </td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            @if ($concepto->ips_incluye)
                                <span
                                    class="rounded-lg bg-purple-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-purple-700 ">IPS</span>
                            @endif
                            @if ($concepto->aguinaldo_incluye)
                                <span
                                    class="rounded-lg bg-indigo-100 px-2 py-0.5 text-xs/6 font-semibold whitespace-nowrap text-indigo-700 ">Aguinaldo</span>
                            @endif
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">

                            Desde {{ \Carbon\Carbon::parse($concepto->pivot->fecha_inicio)->format('d-m-Y') }} @if ($concepto->pivot->fecha_fin)
                                al {{ \Carbon\Carbon::parse($concepto->pivot->fecha_fin)->format('d-m-Y') }}
                            @endif



                        </td>

                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-700">

                            @if ($concepto->es_modificable)
                                @can('concepto editar')
                                    <a href="" class="hover:text-gray-700 cursor-pointer">
                                        <i class="material-symbols-outlined">edit</i>
                                    </a>
                                @endcan

                                @can('concepto eliminar')
                                    <form
                                        action="{{ route('users.eliminarConcepto', ['user' => $user->id, 'concepto' => $concepto->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Está seguro de que desea dar de baja este concepto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button title="Eliminar" type="submit"
                                            class="hover:text-red-500 block text-left cursor-pointer">
                                            <i class="material-symbols-outlined">delete</i>
                                        </button>
                                    </form>
                                @endcan
                            @endif



                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="flex jusitfy-end mt-4">
        <button x-show="!conceptoForm" x-on:click="conceptoForm = true"
            class="px-2 py-1 flex items-center bg-blue-500 rounded text-medium hover:bg-blue-700 text-white">
            <span class="material-symbols-outlined">add</span>
            Agregar concepto
        </button>

    </div>

    <div x-show="conceptoForm" class="p-4 bg-gray-100 rounded" style="display: none">

        <h3 class="text-xl font-medium">Asignar nuevo concepto</h3>

        <form action="{{ route('users.asignarConcepto', $user->id) }}" method="POST">
            @csrf


            <div x-data="{ ips: '0', aguinaldo: '0' }" class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <input type="text" value="{{ $user->id }}" name="empleado_id" hidden>

                <div class="sm:col-span-3">
                    <label for="concepto_id" class="block text-sm font-medium text-gray-700">Concepto</label>


                    <div class="mt-2 grid grid-cols-1">
                        <select id="concepto_id" name="concepto_id" autocomplete="concepto_id" class="form-select"
                            required>
                            <option value="" disabled selected>-- SELECCIONE EL CONCEPTO --</option>
                            @foreach ($conceptos as $concepto)
                                <option value="{{ $concepto->id }}">{{ $concepto->nombre }}</option>
                            @endforeach
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="mt-1 text-sm/6 text-gray-600">Seleccione el concepto a asignar</p>

                </div>

                <div class="sm:col-span-3">
                    <label for="valor" class="block text-sm font-medium text-gray-700">Valor imputable</label>
                    <div class="mt-2">
                        <input type="number" name="valor" id="valor" value="{{ old('valor') }}" required
                            class="form-input">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="fecha_inicio" class="block text-sm font-medium text-gray-700">Fecha de inicio</label>
                    <div class="mt-2">
                        <input type="date" name="fecha_inicio" id="fecha_inicio" value="{{ old('fecha_inicio') }}"
                            required class="form-input">
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label for="fecha_fin" class="block text-sm font-medium text-gray-700">Fecha fin</label>
                    <div class="mt-2">
                        <input type="date" name="fecha_fin" id="fecha_fin" value="{{ old('fecha_fin') }}"
                            class="form-input">
                    </div>
                    <p class="mt-1 text-sm/6 text-gray-600">Deje sin fecha de finalizar para calcular mensualmente el
                        concepto</p>
                </div>
            </div>
            <div class="mt-10 flex gap-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar concepto
                </button>
                <button x-show="conceptoForm" x-on:click="conceptoForm = false"
                    class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">

                    Cancelar
                </button>
            </div>
        </form>
    </div>




</div>
