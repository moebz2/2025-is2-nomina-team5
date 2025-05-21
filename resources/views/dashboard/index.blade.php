@extends('layouts.admin-layout')

@section('title', 'Panel')

@push('pushjs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@endpush

@section('content')

    <div class="container mx-auto p-10 bg-gray-100">

        <h3 class="text-4xl font-medium">Panel de nomina</h3>


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-10">


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">

                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Usuarios</h3>
                    <h2 class="mt-4 font-bold text-4xl">{{ $usuarios->count() }}</h2>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Vacaciones</h3>
                    <h2 class="mt-4 font-bold text-4xl">{{ $vacaciones->count() }}</h2>
                </div>
                <div class="bg-white rounded shadow p-4">
                    <h3 class="font-medium text-lg">Despedidos</h3>
                    <h2 class="mt-4 font-bold text-4xl">{{ $despedidos->count() }}</h2>
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

        </div>

        <div class="mt-10 grid grid-cols-1 lg:grid-cols-2 gap-4">

            <div class="">

                {{-- Agui puede ir una torta de usuarios por departamentos --}}

                <div id="chart_columna" class="w-full">

                </div>


            </div>


            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">


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

            //this.drawChart1();
            this.drawChart2();

        }

        function drawChart1() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Mushrooms', 3],
                ['Onions', 1],
                ['Olives', 1],
                ['Zucchini', 1],
                ['Pepperoni', 2]
            ]);

            // Set chart options
            var options = {
                'title': 'How Much Pizza I Ate Last Night',
                'width': 400,
                'height': 300
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }

        function drawChart2() {
            var data = new google.visualization.DataTable();
            data.addColumn('timeofday', 'Time of Day');
            data.addColumn('number', 'Motivation Level');

            data.addRows([
                [{
                    v: [8, 0, 0],
                    f: '8 am'
                }, 1],
                [{
                    v: [9, 0, 0],
                    f: '9 am'
                }, 5],
                [{
                    v: [10, 0, 0],
                    f: '10 am'
                }, 3],
                [{
                    v: [11, 0, 0],
                    f: '11 am'
                }, 0],
                [{
                    v: [12, 0, 0],
                    f: '12 pm'
                }, 1],
                [{
                    v: [13, 0, 0],
                    f: '1 pm'
                }, 6],
                [{
                    v: [14, 0, 0],
                    f: '2 pm'
                }, 7],
                [{
                    v: [15, 0, 0],
                    f: '3 pm'
                }, 8],
                [{
                    v: [16, 0, 0],
                    f: '4 pm'
                }, 9],
                [{
                    v: [17, 0, 0],
                    f: '5 pm'
                }, 10],
            ]);

            var options = {
                title: 'Motivation Level Throughout the Day',
                hAxis: {
                    title: 'Time of Day',
                    format: 'h:mm a',
                    viewWindow: {
                        min: [7, 30, 0],
                        max: [17, 30, 0]
                    }
                },
                vAxis: {
                    title: 'Rating (scale of 1-10)'
                }
            };

            var materialChart = new google.charts.Bar(document.getElementById('chart_columna'));
            materialChart.draw(data, options);

            /* var chart = new google.visualization.ColumnChart(
                document.getElementById('chart_columna'));

            chart.draw(data, options); */
        }
    </script>
@endpush
