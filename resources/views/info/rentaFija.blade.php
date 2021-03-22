    @extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Información Portafolio</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <section class="col-lg-4 connectedSortable">

                      <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Montos graficados</h3>
                        </div>
                        <div class="card-body" style="display: block;">
                            <div class="chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="barChart"
                                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 604px;"
                                    width="604" height="250" class="chartjs-render-monitor"></canvas>
                            </div>
                        </div>
                    </section>

                    <section class="col-lg-4 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    Diversificación
                                </h3>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <div class="chart tab-pane active" id="sales-chart"
                                        style="position: relative; height: 300px;">
                                        <canvas id="sales-chart-canvas" height="300" style="height: 300px;"></canvas>
                                    </div>
                                </div>
                            </div><!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                    </section>

                    <section class="col-lg-4 connectedSortable">
                      <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Concentrado
                            </h3>
                        </div><!-- /.card-header -->
                        <div class="card-body">

                            <table class="table table-hover" id="table">
                                <thead>
                                    <tr>
                                        <th>Descripción</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Portafolio as $P)
                                        <tr>
                                            <td>{{ $P[0] }}</td>
                                            <td>{{ $P[1] }}</td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                    </div>

                    </section>
                </div>



                <!-- /.card-body -->
            </div>
        </div>

    </div>

    

    <script src="../dist/Chart.min.js"></script>
    <script>
      $(function () {
    
      var pieChartCanvas = $('#sales-chart-canvas').get(0).getContext('2d')
      var pieData        = {
        labels: [
            @foreach($Portafolio as $P)
            '{{$P[0]}}',
            @endforeach
        ],
        datasets: [
          {
            data: [
              @foreach($Portafolio as $P)
              '{{$P[1]}}',
              @endforeach
            ],
            backgroundColor : [
              @foreach($Portafolio as $P)
              '{{$P[2]}}',
              @endforeach
            ],
          }
        ]
      }
      var pieOptions = {
        legend: {
          display: true
        },
        maintainAspectRatio : false,
        responsive : true,
      }
      //Create pie or douhnut chart
      // You can switch between pie and douhnut using the method below.
      var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions      
      });
    })

    $(document).ready(function() {
        $('.table').DataTable();
    });

    $(function () {

var areaChartData = {
  labels  : [
      @foreach($Portafolio as $P)
      '{{$P[0]}}',
      @endforeach
  ],
  datasets: [
    {
      label               : 'Distribución del portafolio',
      backgroundColor     : 'rgba(12,31,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius          : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : [
        @foreach($Portafolio as $P)
            '{{$P[1]}}',
        @endforeach
      ]
    }
  ]
}

var barChartCanvas = $('#barChart').get(0).getContext('2d')
var barChartData = jQuery.extend(true, {}, areaChartData)
var temp0 = areaChartData.datasets[0]
barChartData.datasets[0] = temp0

var barChartOptions = {
  responsive              : true,
  maintainAspectRatio     : false,
  datasetFill             : false
}

var barChart = new Chart(barChartCanvas, {
  type: 'bar', 
  data: barChartData,
  options: barChartOptions
})


})


    
  </script>
  
@endsection
