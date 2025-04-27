@extends('layouts.admin-layout')

@section('title', 'Editar concepto')

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold uppercase">Editar Concepto</h1>

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li class="text-sm text-red-500">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('conceptos.update', $concepto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombre" class="input-label">Nombre del concepto</label>
                <div class="mt-2">
                    <input type="text" id="nombre" class="form-input" name="nombre" value="{{ old('nombre', $concepto->nombre) }}" required>
                </div>
            </div>

            <div class="sm:col-span-3"></div>

            <div class="sm:col-span-3">
                <label for="ips_incluye" class="input-label">Incluye IPS</label>
                <div class="mt-2">
                    <select id="ips_incluye" name="ips_incluye" required class="block rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm">
                        <option value="1" {{ old('ips_incluye', $concepto->ips_incluye) == '1' ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('ips_incluye', $concepto->ips_incluye) == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <button class="p-2 bg-blue-500 font-medium text-white rounded cursor-pointer hover:shadow-md hover:bg-blue-700" type="submit">
                Actualizar concepto
            </button>
        </div>
    </form>
</div>

@endsection