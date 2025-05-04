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
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="form-input">
                    </div>
                </div>

                <div class="form-group mt-3">
                    <label>
                        <input type="checkbox" name="aplica_bonificacion_familiar" value="1">
                            ¿Aplica Bonificación Familiar?
                    </label>
                </div>
                <div id="hijos-section" class="mt-4" style="display: none;">
                    <h5>Hijos</h5>
                        <button type="button" class="btn btn-sm btn-secondary mb-2" onclick="agregarHijo()">Agregar hijo</button>

                <div id="hijos-wrapper"></div>
            </div>


                <div class="sm:col-span-3"></div>

                <div class="sm:col-span-2">
                    <label for="ips_incluye" class="block text-sm font-medium text-gray-700">Incluído en IPS</label>
                    <p class="mt-1 text-sm/6 text-gray-600">Si el IPS esta incluido se hará el descuento correspondiente al
                        realizar la liquidación</p>

                    <div class="mt-2 grid grid-cols-1">
                        <select id="ips_incluye" name="ips_incluye" required autocomplete="ips_incluye" class="form-select">
                            <option value="1" {{ old('ips_incluye') == '1' ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ old('ips_incluye') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="sm:col-span-2">
                    <label for="aguinaldo_incluye" class="block text-sm font-medium text-gray-700">Incluído en
                        aguinaldo</label>
                    <p class="mt-1 text-sm/6 text-gray-600">El concepto incluido en el aguinaldo será caclulado al momento
                        de hacer la liquidación correspondiente</p>

                    <div class="mt-2 grid grid-cols-1">
                        <select id="aguinaldo_incluye" name="aguinaldo_incluye" required autocomplete="aguinaldo_incluye"
                            class="form-select">
                            <option value="1" {{ old('aguinaldo_incluye') == '1' ? 'selected' : '' }}>Sí</option>
                            <option value="0" {{ old('aguinaldo_incluye') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <fieldset class="sm:col-span-3">
                    <legend class="text-sm/6 font-semibold text-gray-900">Tipo de cálculo</legend>
                    <p class="mt-1 text-sm/6 text-gray-600">Indique si el concepto sera de débito o crédito.</p>
                    <div class="mt-6 space-y-6">
                        <div class="flex items-center gap-x-3">
                            <input id="push-everything" name="es_debito" value="true" type="radio" class="form-radio">
                            <label for="push-everything" class="block text-sm/6 font-medium text-gray-900">Débito</label>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <input id="push-email" name="es_debito" type="radio" value="false" class="form-radio"
                                checked>
                            <label for="push-email" class="block text-sm/6 font-medium text-gray-900">Crédito</label>
                        </div>

                    </div>
                </fieldset>



            </div>
            <div class="mt-10">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Guardar concepto
                </button>
            </div>
        </form>
    </div>

    <script>
    const checkbox = document.querySelector('input[name="aplica_bonificacion_familiar"]');
    const hijosSection = document.getElementById('hijos-section');
    let hijoIndex = 0;

    checkbox?.addEventListener('change', function () {
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
</script>



@endsection
