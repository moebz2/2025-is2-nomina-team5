@extends('layouts.admin-layout')

@section('title', 'Panel')

@push('pushjs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')

    <div class="container mx-auto p-10">

        <h3 class="text-4xl font-medium">Panel de nomina</h3>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-10">


            <div class="grid grid-cols-2 lg:grid-cols-4 col-span-2 gap-4 items-start bg-gradient-to-r from-teal-400 to-yellow-200 rounded-xl p-4">

                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Usuarios</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $usuarios->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">groups</i>

                    </div>
                </div>
                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Vacaciones</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $vacaciones->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">weekend</i>

                    </div>
                </div>
                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Despedidos</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $despedidos->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">no_accounts</i>

                    </div>
                </div>
                <div class="bg-white rounded  p-4">

                    <h3 class="font-medium text-lg">Departamentos</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $departamentos->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">workspaces</i>

                    </div>
                </div>

            </div>

            <div class="p-5 border border-gray-200 rounded-xl">

                {{-- Agui puede ir una torta de usuarios por departamentos --}}

                <div id="" class="w-full bg-white rounded p-4">

                    <h3 class="text-lg font-medium">Ultimos usuarios contratados</h3>

                    <ul role="list" class="divide-y divide-gray-100 mt-2">
                        @foreach ($usuarios->take(3) as $usuario)
                            <li class="flex justify-between gap-x-6 py-5">
                                <div class="flex min-w-0 gap-x-4">

                                    <div class="min-w-0 flex-auto">
                                        <p class="text-sm/6 font-semibold text-gray-900">{{ $usuario->nombre }}</p>
                                        <p class="mt-1 truncate text-xs/5 text-gray-500">{{ $usuario->email }}</p>
                                    </div>
                                </div>
                                <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                                    <p class="text-sm/6 text-gray-900">
                                        {{ $usuario->currentCargo() ? $usuario->currentCargo()->nombre : 'Sin cargo' }}</p>
                                    <p class="mt-1 text-xs/5 text-gray-500">{{ $usuario->created_at->format('Y-m-d') }}</p>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>


            </div>

            <div id="departamentos_chart" class="p-5 border border-gray-200 rounded-xl">
                <div class="flex items-center justify-center"><button type="button"
                        class="inline-flex cursor-not-allowed items-center rounded-md bg-indigo-500 px-4 py-2 text-sm leading-6 font-semibold text-white transition duration-150 ease-in-out hover:bg-indigo-400"
                        disabled=""><svg class="mr-3 -ml-1 size-5 animate-spin text-white"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>Processing…</button></div>
            </div>

        </div>

        <div class="mt-5 grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 col-span-2 items-start bg-gradient-to-r from-violet-200 to-pink-200 p-4 rounded-xl">


                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Liquidaciones</h3>
                    <h2 class="mt-4 font-bold text-4xl">{{ $liquidaciones->count() }} Total</h2>
                </div>
                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Pago de nomina - Este mes</h3>
                    <h2 class="mt-4 font-bold text-4xl">
                        {{ number_format($liquidacion_monto_mes, 0, ',', '.') }} Gs
                    </h2>
                </div>
                <div class="bg-white rounded  p-4">
                    <h3 class="font-medium text-lg">Pago de nomina - Año</h3>
                    <h2 class="mt-4 font-bold text-4xl">
                        {{ number_format($liquidacion_monto_ano, 0, ',', '.') }} Gs
                    </h2>
                </div>

            </div>


            <div class="p-5 border border-gray-200 rounded-xl">

                <div class="flex items-center">
                    <div class="flex-auto">
                        <h3 class="text-xl font-medium">Liquidaciones</h3>
                    </div>
                    <div class="flex items-center gap-4">
                        {{-- <label for="country" class="block text-sm/6 font-medium text-gray-900">Año</label> --}}
                        <div class="mt-2 grid grid-cols-1">
                            <select id="country" name="country" autocomplete="country-name" onchange="actualizarPeriodoLiquidacion(this)"
                                class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option value="2025">2025</option>
                                <option value="2024">2024</option>
                               
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>


                </div>

                <div id="grafico_liquidacion" class="w-full mt-4">
                    <div id="concepto_carga"
                        class="flex items-center justify-center min-h-96 rounded border-5 border-dashed border-gray-400">
                        <div
                            class="inline-flex cursor-not-allowed items-center rounded-md bg-gray-300 px-4 py-2 text-sm leading-6 font-semibold text-indigo-500 transition duration-150 ease-in-out">
                            <svg class="mr-3 -ml-1 size-5 animate-spin text-indigo-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>Cargando...
                        </div>
                    </div>
                </div>



            </div>

            <div  class="p-5 border border-gray-200 rounded-xl">
                <div class="flex items-center">
                    <div class="flex-auto">
                        <h3 class="text-xl font-medium">Conceptos</h3>
                    </div>
                    <div class="flex items-center gap-4">
                        {{-- <label for="country" class="block text-sm/6 font-medium text-gray-900">Comparar con</label> --}}
                        <div class="mt-2 grid grid-cols-1">
                            <select id="country" name="country" autocomplete="country-name" onchange="actualizarPeriodoConcepto(this)"
                                class="col-start-1 row-start-1 w-full appearance-none capitalize rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                @foreach ($periodos_conceptos as $periodo => $mes)
                                    <option value="{{$periodo}}">{{$mes}}</option>
                                @endforeach
                            </select>
                            <svg class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
                                <path fill-rule="evenodd"
                                    d="M4.22 6.22a.75.75 0 0 1 1.06 0L8 8.94l2.72-2.72a.75.75 0 1 1 1.06 1.06l-3.25 3.25a.75.75 0 0 1-1.06 0L4.22 7.28a.75.75 0 0 1 0-1.06Z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>

                </div>
                <div id="grafico_conceptos" class="mt-2">
                    <div class="flex items-center justify-center min-h-96">
                        <div
                            class="inline-flex cursor-not-allowed items-center rounded-md px-4 py-2 leading-6 font-semibold transition duration-150 ease-in-out">
                            <svg class="mr-3 -ml-1 size-5 animate-spin text-blue-700" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>Cargando...
                        </div>
                    </div>
                </div>

            </div>



        </div>



    </div>


@endsection


@push('scripts')
    <script type="text/javascript">
        let liquidacionesChartData = null;
        let conceptosChartData = null;
        let departamentosChartData = null;
        let chartApiLoaded = false;


        document.addEventListener('DOMContentLoaded', function() {

            console.log('Contenido DOM cargada');


            dashboard.getDepartamentoChartData().then((res) => {

                departamentosChartData = res.data.datos;

                departamentosChart(departamentosChartData);

            });

            dashboard.getLiquidacionesChartData().then((res) => {

                liquidacionesChartData = res.data.datos;

                liquidacionesChart(liquidacionesChartData);


            });

            dashboard.getConceptosChartData().then((res) => {

                conceptosChartData = res.data.datos;

                conceptosChart(conceptosChartData);


            });

        });

        function actualizarPeriodoConcepto(event){

            dashboard.getConceptosChartData(event.value).then((res) => {

                conceptosChart(res.data.datos);

            });


        }
        function actualizarPeriodoLiquidacion(event){
            dashboard.getLiquidacionesChartData(event.value).then((res)=> {

                liquidacionesChart(res.data.datos);

            });
        }


        // Load the Visualization API and the corechart package.
        google.charts.load('current', {
            'packages': ['corechart']
        });

        // Set a callback to run when the Google Visualization API is loaded.
        google.charts.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            this.chartApiLoaded = true;

            console.log('API de graficas cargada');


        }

        function departamentosChart(data) {


            var data = google.visualization.arrayToDataTable(data);



            var options = {
                height: '300',
                title: 'Empleados por Departamento',
                pieHole: 0.4,

            };

            var chart = new google.visualization.PieChart(document.getElementById('departamentos_chart'));
            chart.draw(data, options);
        }


        function liquidacionesChart(data) {


            var data = google.visualization.arrayToDataTable(data);




            var options = {
                height: '400',

                title: 'Monto de Liquidación por Mes',

                hAxis: {
                    title: 'Mes',
                    titleTextStyle: {
                        color: '#333'
                    }

                },
                vAxis: {
                    minValue: 0
                },
                legend: {
                    position: 'none'
                }

            };


            var chart = new google.visualization.ColumnChart(document.getElementById('grafico_liquidacion'));
            chart.draw(data, options);
        }

        function conceptosChart(data) {

            var data = google.visualization.arrayToDataTable(data);

            var options = {
                //title: 'Top 10 Conceptos de Débito',
                height: '400',
                //subtitle: 'Comparativa de montos entre el mes actual y el mes anterior',
                bars: 'horizontal',
                hAxis: {
                    format: 'decimal',
                    title: 'Monto'
                },
                vAxis: {
                    title: 'Concepto'
                },
                colors: ['#1A73E8', '#E67B25'],
                series: {
                    0: {
                        targetAxisIndex: 0
                    },
                    1: {
                        targetAxisIndex: 0
                    }
                },
                legend: {
                    position: 'top'
                },
            };

            var chart = new google.visualization.BarChart(document.getElementById('grafico_conceptos'));
            chart.draw(data, options);

        }
    </script>
@endpush
