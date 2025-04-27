@extends('layouts.admin-layout')

@section('title', 'Detalles de Liquidación del Empleado')

@section('content')

    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-medium uppercase">Detalles de Liquidación del Empleado</h1>

        <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
            <div class="my-8 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Movimiento</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Monto</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Fecha</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Tipo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalDebito = 0;
                            $totalCredito = 0;
                        @endphp
                        @foreach ($detalles as $detalle)
                            @php
                                $isDebito = $detalle->movimiento->concepto->es_debito;
                                $formattedMonto = number_format($detalle->movimiento->monto, 0, ',', '.');
                                if ($isDebito) {
                                    $totalDebito += $detalle->movimiento->monto;
                                } else {
                                    $totalCredito += $detalle->movimiento->monto;
                                }
                            @endphp
                            <tr>
                                <td class="border-b border-gray-100 p-4 text-gray-500">{{ $detalle->id }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">{{ $detalle->movimiento->concepto->nombre }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">Gs. {{ $formattedMonto }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">{{ $detalle->movimiento->generacion_fecha->format('Y-m-d') }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">
                                    {{ $isDebito ? 'Débito' : 'Crédito' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-6">
            <p class="text-lg font-medium text-gray-700">Total Débito: Gs. {{ number_format($totalDebito, 0, ',', '.') }}</p>
            <p class="text-lg font-medium text-gray-700">Total Crédito: Gs. {{ number_format($totalCredito, 0, ',', '.') }}</p>
            <p class="text-lg font-medium text-gray-700">Neto a acreditar: Gs. {{ number_format($totalCredito - $totalDebito, 0, ',', '.') }}</p>
        </div>
    </div>

@endsection