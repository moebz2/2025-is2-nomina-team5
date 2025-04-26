@extends('layouts.admin-layout')

@section('title', 'Crear conceptos')


@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold uppercase">Crear concepto</h1>
    <p class="mt-1 text-sm/6 text-gray-600"></p>


    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('conceptos.store') }}" method="POST">
        @csrf

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del concepto</label>
                <div class="mt-2">
                    <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required class="form-input">
                </div>
            </div>

            <div class="sm:col-span-3"></div>

            <div class="sm:col-span-3">
                <label for="ips_incluye" class="block text-sm font-medium text-gray-700">Incluído en IPS</label>
                <div class="mt-2">
                    <select name="ips_incluye" id="ips_incluye" required
                        class="block rounded-md border-gray-300 px-3 py-2 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm">
                        <option value="1" {{ old('ips_incluye') == '1' ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('ips_incluye') == '0' ? 'selected' : '' }}>No</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="mt-10">
            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Guardar Concepto
            </button>
        </div>
    </form>
</div>

@endsection