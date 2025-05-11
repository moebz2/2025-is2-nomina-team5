@extends('layouts.admin-layout')

@section('title', 'Crear departamentos')

@section('content')
<div class="min-h-screen flex items-center justify-center py-8">
    <div class="w-full max-w-3xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
        <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Crear departamento</h1>
        <p class="mb-6 text-center text-blue-400">Complete los datos para registrar un nuevo departamento</p>
        @if ($errors->any())
            <div class="rounded-xl bg-red-50/80 backdrop-blur-sm p-4 border border-red-100 mb-6 text-red-700 text-center font-semibold">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('departamentos.store') }}" method="POST">
            @csrf
            <div class="mt-10 grid grid-cols-1 gap-y-8">
                <div>
                    <label for="nombre" class="block text-sm font-medium text-blue-700">Nombre del departamento</label>
                    <div class="mt-2">
                        <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required
                            class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="Ej: Recursos Humanos">
                    </div>
                </div>
                <div>
                    <label for="descripcion" class="block text-sm font-medium text-blue-700">Descripción</label>
                    <div class="mt-2">
                        <textarea id="descripcion" name="descripcion" rows="3"
                            class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition" placeholder="Breve descripción del departamento">{{ old('descripcion') }}</textarea>
                    </div>
                </div>
            </div>
            <div class="mt-10 flex justify-end">
                <button type="submit" class="py-3 px-8 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition text-lg">Crear departamento</button>
            </div>
        </form>
    </div>
</div>
@endsection