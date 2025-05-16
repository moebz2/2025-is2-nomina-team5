
@section('title', 'Crear departamentos')



<div class="container mx-auto p-10">

    <h1 class="text-3xl font-bold uppercase">Crear departamento</h1>
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

    <form action="{{ route('departamentos.store') }}" method="POST">
        @csrf

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-3">
                <label for="nombre" class="input-label">Nombre del departamento</label>
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
        </div>
        <div class="mt-10">
            <button class="p-2 bg-blue-500 font-medium text-white rounded cursor-pointer hover:shadow-md hover:bg-blue-700" type="submit">Crear
                departamento</button>
        </div>
    </form>
</div>


