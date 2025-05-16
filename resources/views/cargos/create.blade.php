
@section('title', 'Crear cargo')



<div class="container mx-auto p-10">

    <h1 class="text-3xl font-bold uppercase">Crear cargo</h1>
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

    <form action="{{ route('cargos.store') }}" method="POST">
        @csrf

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombre" class="input-label">Nombre del cargo</label>
                <div class="mt-2">
                    <input type="text" id="nombre" class="form-input" name="nombre" value="{{ old('nombre') }}"
                        required>
                </div>
            </div>
            <div class="sm:col-span-3"></div>
            <div class="sm:col-span-3">
                <label for="descripcion" class="input-label">Descripción</label>
                <div class="mt-2">
                    <textarea id="descripcion" class="form-input" name="descripcion">{{ old('descripcion') }}</textarea>
                </div>
            </div>
            <div class="sm:col-span-3"></div>
            <div class="sm:col-span-3">
                    <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamentos</label>


                    <div class="mt-2 grid grid-cols-1">
                        <select id="departamento_id" required name="departamento_id" autocomplete="departamento_id"
                            class="form-select">

                            <option value="" selected disabled>-- SELECCIONE UN DEPARTAMENTO -- </option>
                           @foreach ($departamentos as $departamento)
                            <option value="{{ $departamento->id }}">{{ $departamento->nombre }}</option>

                           @endforeach
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <p class="mt-1 text-sm/6 text-gray-600">Si no esta en la lista, puedes <a href="{{route('departamentos.create')}}" class="text-blue-500 hover:text-blue-700">crear nuevo departamento</a></p>



                </div>
        </div>
        <div class="mt-10">
            <button class="p-2 bg-blue-500 font-medium text-white rounded cursor-pointer hover:shadow-md hover:bg-blue-700" type="submit">Crear
                cargo</button>
        </div>
    </form>
</div>


