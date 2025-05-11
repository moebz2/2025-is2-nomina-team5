@extends('layouts.admin-layout')

@section('title', 'Crear conceptos')


@section('content')
    <div class="min-h-screen flex items-center justify-center py-8">
        <div class="w-full max-w-3xl bg-white/80 backdrop-blur-lg rounded-3xl shadow-2xl p-10 border border-white/20">
            <h1 class="text-3xl font-bold uppercase text-center mb-8 bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">Crear concepto</h1>
            @if ($errors->any())
                <div class="rounded-xl bg-blue-50/80 backdrop-blur-sm p-4 border border-blue-100 mb-6">
                    <ul class="list-disc pl-5 space-y-1 text-blue-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('conceptos.store') }}" method="POST">
                @csrf
                <div x-data="{ ips: '0', aguinaldo: '0' }" class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="nombre" class="block text-sm font-medium text-blue-700">Nombre del concepto</label>
                        <div class="mt-2">
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 placeholder:text-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                        </div>
                    </div>
                    <div class="sm:col-span-3"></div>
                    <div class="sm:col-span-3">
                        <label for="ips_incluye" class="block text-sm font-medium text-blue-700">Incluir IPS</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="ips_incluye" name="ips_incluye" x-bind="ips" autocomplete="ips_incluye" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                <option value="1" {{ old('ips_incluye') == '1' ? 'selected' : '' }}>Incluye</option>
                                <option value="0" {{ old('ips_incluye') == '0' ? 'selected' : '' }}>No incluye</option>
                            </select>
                        </div>
                        <p class="mt-1 text-sm text-blue-400">Indique si se incluye el cálculo de la liquidación</p>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="aguinaldo_incluye" class="block text-sm font-medium text-blue-700">Incluír en aguinaldo</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="aguinaldo_incluye" name="aguinaldo_incluye" x-model="aguinaldo" autocomplete="aguinaldo_incluye" class="block w-full rounded-xl border border-blue-200 bg-white/60 px-3 py-2 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
                                <option value="1" {{ old('aguinaldo_incluye') == '1' ? 'selected' : '' }}>Incluir</option>
                                <option value="0" {{ old('aguinaldo_incluye') == '0' ? 'selected' : '' }}>No incluir</option>
                            </select>
                        </div>
                        <p class="mt-1 text-sm text-blue-400">El concepto incluido en el aguinaldo será calculado al momento de hacer la liquidación correspondiente</p>
                    </div>
                    <fieldset class="sm:col-span-3">
                        <legend class="text-sm font-semibold text-blue-700">Tipo de cálculo</legend>
                        <p class="mt-1 text-sm text-blue-400">Indique si el concepto será de débito o crédito.</p>
                        <div class="mt-6 space-y-6">
                            <div class="flex items-center gap-x-3">
                                <input id="es_debito" name="es_debito" value="1" type="radio" class="form-radio focus:ring-blue-500" :disabled="aguinaldo == '1'">
                                <label for="es_debito" class="block text-sm font-medium text-blue-700">Débito</label>
                            </div>
                            <div class="flex items-center gap-x-3">
                                <input id="es_credito" name="es_debito" type="radio" value="0" class="form-radio focus:ring-blue-500" checked>
                                <label for="es_credito" class="block text-sm font-medium text-blue-700">Crédito</label>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="mt-10">
                    <button type="submit" class="w-full py-3 rounded-xl bg-gradient-to-r from-blue-600 to-blue-400 text-white font-semibold shadow-lg hover:from-blue-700 hover:to-blue-500 transition">Guardar concepto</button>
                </div>
            </form>
        </div>
    </div>

    {{-- <script>
        const checkbox = document.querySelector('input[name="aplica_bonificacion_familiar"]');
        const hijosSection = document.getElementById('hijos-section');
        let hijoIndex = 0;

        checkbox?.addEventListener('change', function() {
            hijosSection.style.display = this.checked ? 'block' : 'none';
        });

        function agregarHijo() {
            const wrapper = document.getElementById('hijos-wrapper');
            const div = document.createElement('div');
            div.classList.add('mb-2');
            div.innerHTML = `
            <div class="form-row">
                <div class="col">
                    <input type="text" class="form-control" name="hijos[${hijoIndex}][nombre]" placeholder="Nombre del hijo" required>
                </div>
                <div class="col">
                    <input type="date" class="form-control" name="hijos[${hijoIndex}][fecha_nacimiento]" required>
                </div>
            </div>
        `;
            wrapper.appendChild(div);
            hijoIndex++;
        }
    </script> --}}



@endsection
