@extends('layouts.admin-layout')

@section('title', 'Detalles de Liquidación del Empleado')

@section('content')

    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-medium uppercase">Detalles de Liquidación del Empleado</h1>
        @if (session('success'))
            <p>{{ session('success') }}</p>
        @endif

        <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
            <div class="my-8 overflow-x-auto">
                <table class="min-w-full table-auto border-collapse text-sm">
                    <thead>
                        <tr>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Movimiento
                            </th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Monto</th>
                            <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Fecha</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detalles as $detalle)
                            <tr>
                                <td class="border-b border-gray-100 p-4 text-gray-500">{{ $detalle->id }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">
                                    {{ $detalle->movimiento->concepto->nombre }}</td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">{{ $detalle->movimiento->monto }}
                                </td>
                                <td class="border-b border-gray-100 p-4 text-gray-500">
                                    {{ $detalle->movimiento->generacion_fecha->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
