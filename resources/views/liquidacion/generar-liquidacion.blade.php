@extends('layouts.admin-layout')

@section('title', 'Generar Liquidación')

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold uppercase">Generar Liquidación</h1>
    <p class="mt-1 text-sm text-gray-600">Seleccione el período para generar la liquidación.</p>

    @if ($errors->any())
    <div class="mt-4">
        <ul class="list-disc list-inside text-red-500">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('liquidacion.generar') }}" method="POST" class="mt-8 space-y-6">
        @csrf

        <div>
            <label for="periodo" class="block text-sm font-medium text-gray-700">Mes</label>
            <input type="date" name="periodo" class="form-input" id="periodo" required
                >
        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Generar
            </button>
        </div>


    </form>

    <form action="{{ route('liquidacion.eliminarGenerados') }}" method="POST" class="mt-8 space-y-6">
        @csrf
        @method('DELETE')
        <div>
            <label for="periodo" class="block text-sm font-medium text-gray-700">Mes</label>
            <input type="date" name="periodo" id="periodo" required
                class="form-input">
        </div>

        <div class="mt-6">
            <button type="submit"
                class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Demo: Eliminar Generados
            </button>
        </div>
    </form>
</div>

@endsection
