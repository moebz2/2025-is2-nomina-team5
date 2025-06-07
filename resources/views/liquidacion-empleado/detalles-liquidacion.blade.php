@extends('layouts.admin-layout')

@section('title', 'Detalles de Liquidación del Empleado')

@section('content')

    <div class="container mx-auto ">

        @if (empty($isExport))
            <a href="{{ route('liquidacion-empleado.export', ['id' => $liquidacionEmpleadoId] + request()->query()) }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Exportar a PDF
            </a>
        @endif

        <div class="w-1/2 mt-5">
            <h3 class="text-2xl font-semibold uppercase">Comprobante de pago</h3>
            <p class="text-xl font-medium text-gray-600">{{ $periodo->format('M, Y') }}</p>
        </div>

        <div class="mt-10 grid grid-cols-3">
            <div class="col-span-2">
                <p class="text-gray-600 uppercase">Empleado</p>
                <p class="text-xl font-semibold">{{ $empleado->nombre }}</p>
                <p class="text-gray-600">{{ $empleado->domicilio }}</p>
                <p class="text-gray-600">C.I: {{ $empleado->cedula }}</p>
            </div>

            <div class="grid grid-cols-2 divide-x divide-gray-300">
                <div class="p-4 text-center">
                    <p class="text-gray-600 uppercase text-sm">Periodo</p>

                    <h3 class=" font-bold text-gray-700">{{ $cabecera->periodo->format('M, Y') }}</h3>
                </div>

                <div class="p-4 text-center">
                    <p class="text-gray-600 uppercase text-sm truncate">Nro. liquidación</p>

                    <h3 class=" font-bold text-gray-700"> #{{ $cabecera->id }}</h3>
                </div>


            </div>
        </div>

        <div class="mt-5">
            <h4 class="font-semibold border-gray-400 py-2 text-center text-xl text-gray-400 uppercase">Detalles de
                liquidación</h4>
        </div>
        <div class="mt-2 grid gap-4 grid-cols-2">
            <div>
                <div class="rounded bg-gray-100 p-2">
                    <h3 class="font-medium uppercase">Créditos</h3>
                </div>
                <div class="not-prose overflow-auto rounded-lg bg-white outline outline-white/5">
                    <div class="my-8 overflow-hidden">
                        <table class="w-full table-auto border-collapse text-sm">
                            <thead>
                                <tr>
                                    <th
                                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-semibold uppercase">
                                        Descripción</th>

                                    <th
                                        class="border-b border-gray-200 p-4 pt-0 pr-8 pb-3 text-right font-semibold uppercase">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($creditos as $credito)
                                    <tr>
                                        <td class="border-b border-gray-100 p-4 pl-8">
                                            {{ $credito->movimiento->concepto->nombre }}</td>

                                        <td class="border-b border-gray-100 p-4 pr-8 text-right">
                                            {{ number_format($credito->movimiento->monto, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td class="p-4 pl-8 font-semibold uppercase">Total</td>

                                    <td class="p-4 pr-8 font-semibold text-right">
                                        {{ number_format($totalCredito, 0, ',', '.') }}
                                    </td>
                                </tr>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div>
                <div class="rounded bg-gray-100 p-2">
                    <h3 class="font-medium uppercase">Débitos</h3>
                </div>
                <div class="not-prose overflow-auto rounded-lg bg-white outline outline-white/5">
                    <div class="my-8 overflow-hidden">
                        <table class="w-full table-auto border-collapse text-sm">
                            <thead>
                                <tr>
                                    <th
                                        class="border-b border-gray-200 p-4 pt-0 pb-3 pl-8 text-left font-semibold uppercase">
                                        Descripción</th>

                                    <th
                                        class="border-b border-gray-200 p-4 pt-0 pr-8 pb-3 text-right font-semibold uppercase">
                                        Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach ($debitos as $debito)
                                    <tr>
                                        <td class="border-b border-gray-100 p-4 pl-8">
                                            {{ $debito->movimiento->concepto->nombre }}</td>

                                        <td class="border-b border-gray-100 p-4 pr-8 text-right">
                                            {{ number_format($debito->movimiento->monto, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach

                                <tr>
                                    <td class="p-4 pl-8 font-semibold uppercase">Total</td>

                                    <td class="p-4 pr-8 font-semibold text-right">
                                        {{ number_format($totalDebito, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="w-1/2 ml-auto bg-gray-100 p-4 rounded">
                <table class="table-auto w-full text-sm">
                    <tbody>
                        <tr class="">
                            <td class="p-2">Total crédito</td>
                            <td class="p-2">Gs. {{ number_format($totalCredito, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="">
                            <td class="p-2">Total débito</td>
                            <td class="p-2">Gs. {{ number_format($totalDebito, 0, ',', '.') }}</td>
                        </tr>
                        <tr class="bg-gray-700 text-white font-bold">
                            <td class="p-2">Total neto</td>
                            <td class="p-2">Gs. {{ number_format($totalCredito - $totalDebito, 0, ',', '.') }}<br />
                                ({{ (new NumberFormatter('es-ES', NumberFormatter::SPELLOUT))->format($totalCredito - $totalDebito) }})
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
