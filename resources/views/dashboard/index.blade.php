@extends('layouts.admin-layout')

@section('title', 'Panel')

@push('pushjs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush

@section('content')

    <div class="container mx-auto p-10 bg-gray-100">

        <h3 class="text-4xl font-medium">Panel de nomina</h3>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-10">


            <div class="grid grid-cols-2 lg:grid-cols-4 col-span-2 gap-4 items-start">

                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Usuarios</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $usuarios->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">groups</i>

                    </div>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Vacaciones</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $vacaciones->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">weekend</i>

                    </div>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Despedidos</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $despedidos->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">no_accounts</i>

                    </div>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Departamentos</h3>
                    <div class="flex">
                        <h2 class="mt-4 font-bold text-4xl">{{ $departamentos->count() }}</h2>
                        <i class="ml-auto material-symbols-outlined text-gray-500" style="font-size: 3rem">workspaces</i>

                    </div>
                </div>

            </div>

            <div class="">

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

            <div id="departamentos_chart"></div>

        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 col-span-2 items-start">


                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Liquidaciones</h3>
                    <h2 class="mt-4 font-bold text-4xl">{{ $liquidaciones->count() }} Total</h2>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Pago de nomina - Este mes</h3>
                    <h2 class="mt-4 font-bold text-4xl">
                        {{ number_format($liquidacion_monto_mes, 0, ',', '.') }} Gs
                    </h2>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Pago de nomina - Año</h3>
                    <h2 class="mt-4 font-bold text-4xl">
                        {{ number_format($liquidacion_monto_ano, 0, ',', '.') }} Gs
                    </h2>
                </div>

            </div>

            <div class="">

                {{-- Agui puede ir una torta de usuarios por departamentos --}}
                <div id="chart_columna" class="w-full">

                </div>


            </div>

            <div>
                <div class="mb-4 flex gap-2">
                    <input type="month" id="month1" value="{{ now()->format('Y-m') }}">
                    <input type="month" id="month2" value="{{ now()->subMonth()->format('Y-m') }}">
                    <button onclick="graficoBarras()" class="bg-blue-500 text-white px-4 py-2 rounded">Comparar</button>
                </div>
                <div id="grafico_conceptos"></div>

            </div>






        </div>



    </div>


@endsection


@push('scripts')
    <script type="text/javascript">
        let usuarios = {!! json_encode($departamentos) !!}

        console.log(usuarios);

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

            this.drawChart1();
            this.drawChart3();

            this.graficoBarras();

        }

        function drawChart1() {

            // Create the data table.
            var data = google.visualization.arrayToDataTable(@json($departamentosChart));

            // Opciones del gráfico. pieHole es lo que lo convierte en un donut chart.
            var options = {
                height: '300',
                title: 'Empleados por Departamento',
                pieHole: 0.4, // Un valor entre 0 y 1. 0.4 es un buen punto de partida para un donut.
                // legend: { position: 'labeled' } // Podrías querer esta opción para etiquetas directas en el gráfico
            };

            // Crea una instancia del PieChart (que se convierte en donut con pieHole)
            var chart = new google.visualization.PieChart(document.getElementById('departamentos_chart'));
            chart.draw(data, options);
        }


        function drawChart3() {
            // Convierte los datos de Laravel (JSON) a un DataTable de Google Charts
            var data = google.visualization.arrayToDataTable(@json($googleChartsData));

            // Opciones del gráfico
            var options = {
                height: '400',
                title: 'Monto de Liquidación por Mes ({{ $currentYear }})', // Título del gráfico
                hAxis: {
                    title: 'Mes',
                    titleTextStyle: {
                        color: '#333'
                    }
                }, // Eje horizontal
                vAxis: {
                    minValue: 0
                }, // Eje vertical, comienza en 0
                legend: {
                    position: 'none'
                } // No mostrar leyenda (ya que solo hay una serie)
            };

            // Crea una instancia del ColumnChart y lo dibuja en el div con id 'chart_div'
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_columna'));
            chart.draw(data, options);
        }

        function graficoBarras() {
            let m1 = document.getElementById('month1').value;
            let m2 = document.getElementById('month2').value;
            let url = '{{ route('dashboard.grafico-barras') }}' + '?month1=' + m1 + '&month2=' + m2;
            fetch(url).then(response => response.json())
                .then(data => {
                    var chartData = google.visualization.arrayToDataTable(data);
                    var options = {
                        title: 'Top 10 Conceptos de Débito',
                        height: '400',
                        subtitle: 'Comparativa de montos entre dos meses',
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
                        }
                    };
                    var chart = new google.visualization.BarChart(document.getElementById('grafico_conceptos'));
                    chart.draw(chartData, options);
                });
        }
    </script>
@endpush
