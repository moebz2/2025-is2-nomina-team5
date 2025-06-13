<div class="container mx-auto mt-6">

    <h2 class="text-2xl font-bold mb-6">Reporte de Descuentos por Concepto</h2>

    {{-- Filtros --}}
    <div class="bg-white rounded shadow p-6 mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            {{-- Empleado --}}
            <div class="col-span-1 md:col-span-2">
                <label for="empleado_id" class="block text-sm font-medium text-gray-700 mb-1">Empleado</label>
                <select name="empleado_id" id="empleado_id" class="form-select w-full rounded border-gray-300">
                    <option value="">-- Todos --</option>
                    @foreach ($empleados as $empleado)
                        <option value="{{ $empleado->id }}"
                            {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                            {{ $empleado->nombre ?? 'Sin nombre' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Concepto --}}
            <div class="col-span-1 md:col-span-2">
                <label for="concepto_id" class="block text-sm font-medium text-gray-700 mb-1">Concepto</label>
                <select name="concepto_id" id="concepto_id" class="form-select w-full rounded border-gray-300">
                    <option value="">-- Todos --</option>
                    @foreach ($conceptos as $concepto)
                        <option value="{{ $concepto->id }}"
                            {{ request('concepto_id') == $concepto->id ? 'selected' : '' }}>
                            {{ $concepto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Fechas (en una fila) --}}
            <div class="col-span-1 md:col-span-2 grid grid-cols-2 gap-4">
                <div>
                    <label for="fecha_desde" class="block text-sm font-medium text-gray-700 mb-1">Desde</label>
                    <input type="date" name="fecha_desde" id="fecha_desde" value="{{ request('fecha_desde') }}"
                        class="form-input w-full rounded border-gray-300">
                </div>

                <div>
                    <label for="fecha_hasta" class="block text-sm font-medium text-gray-700 mb-1">Hasta</label>
                    <input type="date" name="fecha_hasta" id="fecha_hasta" value="{{ request('fecha_hasta') }}"
                        class="form-input w-full rounded border-gray-300">
                </div>
            </div>

            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    {{-- Resultados --}}
    <div class="bg-white rounded shadow p-6">
        @if ($resultados->count())
            <div class="overflow-x-auto">
                <table id="reporte" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">Fecha</th>
                            <th class="px-4 py-2 text-left">Empleado</th>
                            <th class="px-4 py-2 text-left">Concepto</th>
                            <th class="px-4 py-2 text-right">Monto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($resultados as $item)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->movimiento->validez_fecha)->format('d/m/Y') }}</td>
                                <td class="px-4 py-2">{{ $item->movimiento->empleado->nombre ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $item->movimiento->concepto->nombre ?? '-' }}</td>
                                <td class="px-4 py-2 text-right">
                                    {{ number_format($item->movimiento->monto, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (empty($isExport))
                <div class="mt-4">
                    <button type="button" onclick="exportToExcel('reporte', 'reporte_descuento')"
                        class=" bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded">
                        Exportar Excel
                    </button>
                </div>
            @endif
        @else
            <div class="text-gray-600 text-center py-4">
                No se encontraron resultados para los filtros seleccionados.
            </div>
        @endif
    </div>
</div>
