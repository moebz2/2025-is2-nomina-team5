<div x-show="salarioForm == true" class="rounded border-5 border-dashed border-gray-300 mt-4 p-10 w-1/2 mx-auto">

    <h3 class="text-base font-semibold text-gray-900" id="modal-title">Agregar o actualizar salario</h3>

    <form action="{{route('users.asignarSalario', $user->id)}}" method="POST">
        @csrf


        <div class="mt-10">

            <input type="text" value="{{ $user->id }}" name="empleado_id" hidden>



            <div class="sm:col-span-2">
                <label for="valor" class="block text-sm font-medium text-gray-700">Monto del salario</label>
                <div class="mt-2">
                    <input type="number" min="0" step="100000" name="valor" id="valor" value="{{ old('valor') }}" required
                        class="form-input">
                </div>
                <p class="mt-1 text-sm/6 text-gray-600">Salario minimo vigente actualmente: @if (isset($salario_minimo)) {{$salario_minimo->valor}}

                @endif Gs</p>
            </div>




        </div>
        <div class="mt-10 flex gap-4">
            <button type="submit"
                class="bg-indigo-500 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Guardar
            </button>
            <button x-on:click="salarioForm = false" type="button"
                class="px-2 py-1 flex items-center bg-red-500 rounded text-medium hover:bg-red-700 text-white">

                Cancelar
            </button>
        </div>
    </form>


</div>
