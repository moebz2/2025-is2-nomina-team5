@extends('layouts.admin-layout')

@section('title', 'Editar departamento')

@section('content')

<div class="container mx-auto p-10">
    <h1 class="text-3xl font-bold uppercase">Editar Departamento</h1>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li class="text-sm text-red-500">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('departamentos.update', $departamento->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombre" class="input-label">Nombre del departamento</label>
                <div class="mt-2">
                    <input type="text" id="nombre" class="form-input" name="nombre" value="{{ old('nombre', $departamento->nombre) }}" required>
                </div>
            </div>

            <div class="sm:col-span-3"></div>
            <div class="sm:col-span-4">
                <label for="descripcion" class="input-label">Descripción</label>
                <div class="mt-2">
                    <textarea id="descripcion" class="form-input" name="descripcion">{{ old('descripcion', $departamento->descripcion) }}</textarea>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <button class="p-2 bg-blue-500 font-medium text-white rounded cursor-pointer hover:shadow-md hover:bg-blue-700" type="submit">
                Actualizar departamento
            </button>
        </div>
    </form>
</div>

@endsection