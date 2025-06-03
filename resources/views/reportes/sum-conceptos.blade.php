{{-- filepath: /home/userubu/universidad/is2/nomina_project/nomina/resources/views/reportes/sum-conceptos.blade.php --}}

<div class="container mx-auto mt-6">
    <div class="flex items-center justify-between mb-4">

        <h2 class="text-2xl font-bold mb-6">Reporte de Sumatoria de Conceptos</h2>

        @if (empty($isExport))
            <a href="{{ route('reportes.sum-conceptos.export') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Exportar a PDF
            </a>
        @endif
    </div>


    @if (empty($isExport))
        <div class="bg-white rounded shadow p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="sumatoria_limite_inferior" class="block text-sm font-medium text-gray-700 mb-1">Sumatoria
                        mayor a</label>
                    <input type="number" name="sumatoria_limite_inferior" id="sumatoria_limite_inferior"
                        value="{{ request('sumatoria_limite_inferior') }}"
                        class="form-input w-full rounded border-gray-300">
                </div>
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
                <div>
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
                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded">
                        Buscar
                    </button>
                </div>
            </form>
        </div>
    @endif


    {{-- Resultados --}}
    <div class="bg-white rounded shadow p-6">
        @if (count($empleados))
            @php
                $totalSum = collect($empleados)->sum('total');
            @endphp
            <div class="overflow-x-auto">
                <table id="reporte" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">Empleado</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($empleados as $empleado)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $empleado->empleado_nombre }}</td>
                                <td class="px-4 py-2 text-right">Gs. {{ number_format($empleado->total, 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td class="px-4 py-2 text-left">Total</td>
                            <td class="px-4 py-2 text-right">Gs. {{ number_format($totalSum, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="mt-4">
                <button type="button" onclick="exportToExcel('reporte', 'reporte_conceptos')"
                    class=" bg-green-600 hover:bg-green-500 text-white font-medium py-2 px-4 rounded">
                    Exportar Excel
                </button>
            </div>
        @else
            <div class="text-gray-600 text-center py-4">
                No se encontraron resultados para los filtros seleccionados.
            </div>
        @endif
    </div>
</div>
