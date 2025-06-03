<div x-show="tab == 'movimientos'">


    <div class="flex gap-4 mt-4 p-4">

        @foreach ($monthMap as $month => $value)
            <a href="{{route('users.show',[$user->id, 'pestana' => 'movimientos', 'periodo' => $month])}}" class="font-semibold hover:text-blue-500 @if(strcmp($month, $periodoNombreMes)==0) text-blue-500 @else text-gray-700 @endif  capitalize text-sm">{{$month}}</a>

        @endforeach


    </div>


    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">


        <div class="my-8 overflow-hidden">
            <table class="w-full table-auto border-collapse text-sm">
                <thead>
                    {{-- <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-400 ">
                        ID</th> --}}
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Concepto
                    </th>
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Valor
                    </th>
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Fecha validez</th>
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Fecha creacion
                    </th>
                    <th
                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-medium text-gray-500 ">
                        Acciones</th>
                </thead>

                @foreach ($movimientos as $movimiento)
                    <tr>
                        {{-- <td class="border-b border-gray-100 p-4 pl-8 text-gray-500">{{ $concepto->id }}</td> --}}
                        <td class="border-b border-gray-100 p-4 pl-8 text-black">{{ $movimiento->concepto->nombre }}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            {{ number_format($movimiento->monto, 0, ',', '.') }}
                        </td>

                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                           {{$movimiento->validez_fecha->format('Y-m')}}
                        </td>
                        <td class="border-b border-gray-100 p-4 pl-8 text-gray-700">
                            {{$movimiento->generacion_fecha->format('Y-m-d')}}
                        </td>

                        <td class="border-b flex gap-2 border-gray-100 p-4 pl-8 text-gray-700">

                            @can('movmiento editar')
                                    <a href=""
                                        class="hover:text-gray-700 cursor-pointer">
                                        <i class="material-symbols-outlined">edit</i>
                                    </a>
                            @endcan

                            @can('movimiento eliminar')
                                <form action=""
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

                        </td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="flex jusitfy-end mt-4">
        <button x-show="!movimientoForm" x-on:click="movimientoForm = true" class="px-2 py-1 flex items-center bg-blue-500 rounded text-medium hover:bg-blue-700 text-white">
            <span class="material-symbols-outlined">add</span>
            Nuevo movimiento
        </button>

    </div>

    <div x-show="movimientoForm" class="p-4 bg-gray-100 rounded" style="display: none">

        <h3 class="text-xl font-medium">Registrar movimiento</h3>

        <form action="{{route('users.registrarMovimiento', $user->id)}}" method="POST">
            @csrf


            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

                <input type="text" value="{{ $user->id }}" name="empleado_id" hidden>

                <div class="sm:col-span-3">
                    <label for="concepto_id"
                        class="block text-sm font-medium text-gray-700">Concepto</label>


                    <div class="mt-2 grid grid-cols-1">
                        <select id="concepto_id" name="concepto_id" autocomplete="concepto_id"
                            class="form-select" required>
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
                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto del movimiento</label>
                    <div class="mt-2">
                        <input type="number" name="monto" id="monto" value="{{ old('monto') }}" required
                            class="form-input">
                    </div>
                </div>

                <div class="sm:col-span-3">
                    <label for="validez_fecha" class="block text-sm font-medium text-gray-700">Fecha de validez</label>
                    <div class="mt-2">
                        <input type="date" name="validez_fecha" id="validez_fecha" value="{{ old('validez_fecha') }}" required
                            class="form-input">
                    </div>
                </div>





            </div>
            <div class="mt-10 flex gap-4">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar movimiento
                </button>
                <button x-show="movimientoForm" x-on:click="movimientoForm = false" class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">

                    Cancelar
                </button>
            </div>
        </form>
    </div>




</div>
