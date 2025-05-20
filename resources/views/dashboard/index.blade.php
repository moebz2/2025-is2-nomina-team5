@extends('layouts.admin-layout')

@section('title', 'Panel')

@push('pushjs')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@endpush

@section('content')

<div class="container mx-auto p-10 bg-gray-100">

    <h3 class="text-3xl font-bold mb-4 ">Panel de nomina</h3>


    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">


        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 items-start">


            <div class="bg-white rounded shadow p-4">
                <h3 class="font-medium text-lg">Usuarios</h3>
                <h2 class="mt-4 font-bold text-4xl">{{$usuarios->count()}}</h2>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-medium text-lg">Departamentos</h3>
                <h2 class="mt-4 font-bold text-4xl">{{$departamentos->count()}}</h2>
            </div>

        </div>

        <div class="">

            {{-- Agui puede ir una torta de usuarios por departamentos --}}

            <div id="chart_div" class="w-full">

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
                <h2 class="mt-4 font-bold text-4xl">10 Total</h2>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-medium text-lg">Pago de nomina - Mayo</h3>
                <h2 class="mt-4 font-bold text-4xl">
                    52.365.120 Gs
                </h2>
            </div>
            <div class="bg-white rounded shadow p-4">
                <h3 class="font-medium text-lg">Pago de nomina - Año</h3>
                <h2 class="mt-4 font-bold text-4xl">
                    152.365.120 Gs
                </h2>
            </div>

        </div>


    </div>



</div>


@endsection


@push('scripts')
    <script type="text/javascript">

        let usuarios= {!! json_encode($departamentos) !!}

        console.log(usuarios);

      // Load the Visualization API and the corechart package.
      google.charts.load('current', {'packages':['corechart']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.charts.setOnLoadCallback(drawChart);

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
        function drawChart() {

            this.drawChart1();
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
        var options = {'title':'How Much Pizza I Ate Last Night',
                       'width':400,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      function drawChart2() {
        var data = new google.visualization.DataTable();
      data.addColumn('timeofday', 'Time of Day');
      data.addColumn('number', 'Motivation Level');

      data.addRows([
        [{v: [8, 0, 0], f: '8 am'}, 1],
        [{v: [9, 0, 0], f: '9 am'}, 2],
        [{v: [10, 0, 0], f:'10 am'}, 3],
        [{v: [11, 0, 0], f: '11 am'}, 4],
        [{v: [12, 0, 0], f: '12 pm'}, 5],
        [{v: [13, 0, 0], f: '1 pm'}, 6],
        [{v: [14, 0, 0], f: '2 pm'}, 7],
        [{v: [15, 0, 0], f: '3 pm'}, 8],
        [{v: [16, 0, 0], f: '4 pm'}, 9],
        [{v: [17, 0, 0], f: '5 pm'}, 10],
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

      var chart = new google.visualization.ColumnChart(
        document.getElementById('chart_columna'));

      chart.draw(data, options);
      }
    </script>

@endpush
