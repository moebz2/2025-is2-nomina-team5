@extends('layouts.admin-layout')

@section('title', 'Empleados incluidos en Liquidación')

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-medium uppercase">Empleados incluidos en liquidación</h1>
    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <div class="mt-10 not-prose overflow-auto rounded-lg bg-gray-100 outline outline-white/5">
        <div class="my-8 overflow-x-auto">
            <table class="min-w-full table-auto border-collapse text-sm">
                <thead>
                    <tr>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">ID</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Empleado</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Estado</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Periodo</th>
                        <th class="border-b border-gray-200 p-4 pt-0 pb-3 text-left font-medium text-gray-400">Verificación Fecha</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($liquidacionEmpleados as $liquidacionEmpleado)
                    <tr>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacionEmpleado->id }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacionEmpleado->empleado->nombre }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacionEmpleado->estado }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacionEmpleado->periodo->format('Y-m') }}</td>
                        <td class="border-b border-gray-100 p-4 text-gray-500">{{ $liquidacionEmpleado->verificacion_fecha ? $liquidacionEmpleado->verificacion_fecha->format('Y-m-d') : 'N/A' }}</td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection