<div class="container mx-auto mt-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-2xl font-bold">Reporte de Liquidaciones</h2>
        @if (empty($isExport))
            <a href="{{ route('reportes.total-liquidacion.export') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Exportar a PDF
            </a>
        @endif
    </div>

    <div class="bg-white rounded shadow p-6">
        @if (count($report['report']))
            <div class="overflow-x-auto">
                <table id="reporte" class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead class="bg-gray-100 text-gray-700 font-semibold">
                        <tr>
                            <th class="px-4 py-2 text-left">Periodo</th>
                            <th class="px-4 py-2 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($report['report'] as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $row['periodo'] }}</td>
                                <td class="px-4 py-2 text-right">Gs. {{ number_format($row['total'], 0, ',', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="font-bold">
                            <td class="px-4 py-2 text-left">Total General</td>
                            <td class="px-4 py-2 text-right">Gs.
                                {{ number_format($report['totalGeneral'], 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-gray-600 text-center py-4">
                No se encontraron resultados.
            </div>
        @endif
    </div>
</div>
