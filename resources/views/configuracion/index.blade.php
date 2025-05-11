@extends('layouts.admin-layout')

@section('title', 'Configuración')

@section('content')
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-2xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
            <h1 class="text-3xl font-bold uppercase text-center mb-4 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Configuración</h1>
            <p class="mt-2 text-sm text-blue-600 text-center">Nota: esta funcionalidad busca los conceptos asociados a los empleados (tabla empleado_conceptos),<br />por ej. salario y bonificacion familiar, y crea movimientos con los montos configurados allí.<br /> Va a ejecutarse automáticamente en el servidor de producción con un CRON, todos los meses. <br /> No está pensado que se ejecute manualmente con este botón. Es solamente para demostrar.</p>
            <p class="mt-1 text-sm text-blue-500 text-center">Seleccione el mes para generar los movimientos.</p>
            @if ($errors->any())
                <div class="mt-4 rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100">
                    <ul class="list-disc list-inside text-blue-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('movimientos.generar') }}" method="POST" class="mt-8 space-y-6">
                @csrf
                <div>
                    <label for="fecha" class="block text-sm font-medium text-blue-700">Mes</label>
                    <input type="date" name="fecha" id="fecha" required value="{{ now()->format('Y-m') }}"
                        class="mt-1 block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                </div>
                <div class="mt-6">
                    <button type="submit"
                        class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">
                        Generar Movimientos
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
