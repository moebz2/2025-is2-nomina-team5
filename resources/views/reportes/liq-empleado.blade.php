@extends('layouts.admin-layout')

@section('content')

<div class="container mx-auto mt-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Reporte de Liquidaciones de Empleados</h2>
        @if (empty($isExport))
            <a href="{{ route('reportes.liq-empleado.export', request()->query()) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Exportar a PDF
            </a>
        @endif
    </div>

    @if (empty($isExport))
        <div class="bg-white rounded shadow p-6 mb-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">

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
                    <label for="net_sum_min" class="block text-sm font-medium text-gray-700 mb-1">Neto Mínimo</label>
                    <input type="number" name="net_sum_min" id="net_sum_min" value="{{ request('net_sum_min') }}"
                        class="form-input w-full rounded border-gray-300">
                </div>

                <div>
                    <label for="net_sum_max" class="block text-sm font-medium text-gray-700 mb-1">Neto Máximo</label>
                    <input type="number" name="net_sum_max" id="net_sum_max" value="{{ request('net_sum_max') }}"
                        class="form-input w-full rounded border-gray-300">
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-medium py-2 px-4 rounded">
                        Filtrar
                    </button>
                </div>
            </form>
        </div>
    @endif

    <div class="bg-white rounded shadow p-6">
        @if ($report->count())
            <div class="overflow-x-auto">
                <table id="reporte" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">Periodo</th>
                            <th class="px-4 py-2 text-left">Empleado</th>
                            <th class="px-4 py-2 text-right">Neto</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($report as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $row['periodo'] }}</td>
                                <td class="px-4 py-2">{{ $row['empleado_nombre'] }}</td>
                                <td class="px-4 py-2 text-right">Gs. {{ number_format($row['net_sum'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if (empty($isExport))
                <div class="mt-4">
                    <button type="button" onclick="exportToExcel('reporte', 'reporte_liquidacion')"
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

@endsection