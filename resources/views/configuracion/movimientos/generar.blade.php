

@section('title', 'Generar movimientos')


    <div class="container mx-auto p-10">
        <h1 class="text-3xl font-bold uppercase">Configuración</h1>
        <p class="mt-2 text-sm text-gray-600">Nota: esta funcionalidad busca los conceptos asociados a los empleados (tabla
            empleado_conceptos),<br />por ej. salario y bonificacion familiar, y crea movimientos con los montos
            configurados allí.<br /> Va a ejecutarse automáticamente en el servidor de producción con un CRON, todos los
            meses. <br /> No está pensado que se ejecute manualmente con este botón. Es solamente para demostrar.</p>

        <p class="mt-1 text-sm text-gray-600">Seleccione el mes para generar los movimientos.</p>

        @if ($errors->any())
            <div class="mt-4">
                <ul class="list-disc list-inside text-red-500">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('movimientos.generar') }}" method="POST" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700">Mes</label>
                <input type="date" name="fecha" class="form-input" id="fecha" required
                    value="{{ now()->format('Y-m') }}"
                    class="mt-1 block w-45 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 sm:text-sm">
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Generar Movimientos
                </button>
            </div>
        </form>

    </div>


