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


            <div x-data="{ ips: '0', aguinaldo: '0'}" class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del concepto</label>
                    <div class="mt-2">
                        <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                            class="form-input">
                    </div>
                </div>

                <div class="sm:col-span-3"></div>

                <div class="sm:col-span-3">
                    <label for="ips_incluye" class="block text-sm font-medium text-gray-700">Incluir IPS</label>
                    <p class="mt-1 text-sm/6 text-gray-600">Indique si se incluye el calculo de la liquidación</p>

                    <div class="mt-2 grid grid-cols-1">
                        <select id="ips_incluye" name="ips_incluye" x-bind="ips" autocomplete="ips_incluye"
                            class="form-select">
                            <option value="1" {{ old('ips_incluye') == '1' ? 'selected' : '' }}>Incluye</option>
                            <option value="0" {{ old('ips_incluye') == '0' ? 'selected' : '' }}>No incluye</option>
                        </select>
                        <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                            <path fill-rule="evenodd"
                                d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>


                   {{--  <fieldset>
                        <legend class="text-sm/6 font-semibold text-gray-900">Calculos especiales</legend>
                        <p class="mt-1 text-sm/6 text-gray-600">Indique que tipo de calculos deben realizarse al incluir el concepto en la liquidación</p>
                        <div class="mt-6 space-y-6">
                            <div class="flex gap-3">
                                <div class="flex h-6 shrink-0 items-center">
                                    <div class="group grid size-4 grid-cols-1">
                                        <input id="ips_incluye" aria-describedby="ips_incluye-description" name="ips_incluye"
                                            type="checkbox" x-model="ips" value="1" checked
                                            class="form-checkbox">
                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                            viewBox="0 0 14 14" fill="none">
                                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-sm/6">
                                    <label for="ips_incluye" class="font-medium text-gray-900">IPS</label>
                                    <p id="ips_incluye-description" class="text-gray-500">Se caculará el debito correspondiente al aporte de IPS</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 space-y-6">
                            <div class="flex gap-3">
                                <div class="flex h-6 shrink-0 items-center">
                                    <div class="group grid size-4 grid-cols-1">
                                        <input id="aguinaldo_incluye" aria-describedby="aguinaldo_incluye-description" name="aguinaldo_incluye"
                                            type="checkbox" x-model="aguinaldo" value="1" checked
                                            class="form-checkbox">
                                        <svg class="pointer-events-none col-start-1 row-start-1 size-3.5 self-center justify-self-center stroke-white group-has-disabled:stroke-gray-950/25"
                                            viewBox="0 0 14 14" fill="none">
                                            <path class="opacity-0 group-has-checked:opacity-100" d="M3 8L6 11L11 3.5"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            <path class="opacity-0 group-has-indeterminate:opacity-100" d="M3 7H11"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="text-sm/6">
                                    <label for="aguinaldo_incluye" class="font-medium text-gray-900">Aguinaldo</label>
                                    <p id="aguinaldo_incluye-description" class="text-gray-500">Se caculará el credito correspondiente al aguinaldo</p>
                                </div>
                            </div>
                        </div>
                    </fieldset> --}}


                </div>

                <div class="sm:col-span-2">
                    <label for="aguinaldo_incluye" class="block text-sm font-medium text-gray-700">Incluír en
                        aguinaldo</label>
                    <p class="mt-1 text-sm/6 text-gray-600">El concepto incluido en el aguinaldo será caclulado
                        al momento
                        de hacer la liquidación correspondiente</p>

                    <div class="mt-2 grid grid-cols-1">
                        <select id="aguinaldo_incluye" name="aguinaldo_incluye" x-model="aguinaldo" autocomplete="aguinaldo_incluye"
                            class="form-select">
                            <option value="1" {{ old('aguinaldo_incluye') == '1' ? 'selected' : '' }}>Incluir
                            </option>
                            <option value="0" {{ old('aguinaldo_incluye') == '0' ? 'selected' : '' }}>No incluir
                            </option>
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
                            <input id="es_debito" name="es_debito" value="1" type="radio" class="form-radio" :disabled="aguinaldo == '1'">
                            <label for="es_debito" class="block text-sm/6 font-medium text-gray-900">Débito</label>
                        </div>
                        <div class="flex items-center gap-x-3">
                            <input id="es_credito" name="es_debito" type="radio" value="0" class="form-radio" checked>
                            <label for="es_credito" class="block text-sm/6 font-medium text-gray-900">Crédito</label>
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

@endsection
