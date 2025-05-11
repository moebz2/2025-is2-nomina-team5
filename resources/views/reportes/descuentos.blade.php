@extends('layouts.admin-layout')

@section('title', 'Generar Reporte')

@section('content')
<div class="container">
    <h2 class="mb-4">Reporte de Descuentos por Concepto</h2>

    {{-- Filtros --}}
    <form method="GET" class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="empleado_id" class="form-label">Empleado</label>
                <select name="empleado_id" id="empleado_id" class="form-select">
                    <option value="">-- Todos --</option>
                    @foreach($empleados as $empleado)
                        <option value="{{ $empleado->id }}" {{ request('empleado_id') == $empleado->id ? 'selected' : '' }}>
                            {{ $empleado->name }}
                        </option>

                    @endforeach
                </select>
            </div>

            <div class="col-md-3">
                <label for="concepto_id" class="form-label">Concepto</label>
                <select name="concepto_id" id="concepto_id" class="form-select">
                    <option value="">-- Todos --</option>
                    @foreach($conceptos as $concepto)
                        <option value="{{ $concepto->id }}" {{ request('concepto_id') == $concepto->id ? 'selected' : '' }}>
                            {{ $concepto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label for="fecha_desde" class="form-label">Desde</label>
                <input type="date" name="fecha_desde" id="fecha_desde" class="form-control" value="{{ request('fecha_desde') }}">
            </div>

            <div class="col-md-2">
                <label for="fecha_hasta" class="form-label">Hasta</label>
                <input type="date" name="fecha_hasta" id="fecha_hasta" class="form-control" value="{{ request('fecha_hasta') }}">
            </div>

            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>
        </div>
    </form>

    {{-- Resultados --}}
    @if($resultados->count())
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Fecha</th>
                        <th>Empleado</th>
                        <th>Concepto</th>
                        <th class="text-end">Monto</th>
                        <th>Observación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resultados as $item)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d/m/Y') }}</td>
                            <td>{{ $item->movimiento->empleado->name ?? '-' }}</td>
                            <td>{{ $item->movimiento->concepto->nombre ?? '-' }}</td>
                            <td class="text-end">{{ number_format($item->movimiento->monto, 0, ',', '.') }}</td>
                            <td>-</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            No se encontraron resultados para los filtros seleccionados.
        </div>
    @endif
</div>
@endsection
