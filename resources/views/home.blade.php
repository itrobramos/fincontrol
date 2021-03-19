@extends('layouts.business')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h4>$ {{ $RentaFijaTotal }}</h4>
                                <p>Renta Fija</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h4>$ {{ $VariableTotal }}</h4>
                                <p>Renta Variable</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h4>$ {{ $EfectivoTotal }}</h4>

                                <p>Efectivo</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h4>$ {{ $PortafolioTotal }}</h4>

                                <p>Portafolio</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">Más información <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->
                <!-- Main row -->

                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-5 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                    <i class="fas fa-chart-pie mr-1"></i>
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
                    <!-- /.Left col -->
                    <!-- right col (We are only adding the ID to make the widgets sortable)-->
                    <section class="col-lg-7 connectedSortable">

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Próximos plazos a vencer</h3>
                            </div>
                            <div class="card-body p-0">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Descripción</th>
                                            <th>Progress</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($RentFixedInvestments as $inv)
                                            <tr>
                                                <td>{{ $inv->FixedRentPlatform->name }} - ($ {{ $inv->amount }}) -
                                                    {{ date('M', strtotime($inv->endDate)) }}
                                                    {{ date('d', strtotime($inv->endDate)) }}
                                                </td>
                                                <td>
                                                    @if( round(round((time() - strtotime($inv->initialDate)) / (60 * 60 * 24)) / $inv->term * 100,2) >= 100)
                                                        <span class="badge badge-success">Finalizado</span>
                                                        <a class="btn badge badge-warning" href="{{url('rentafija/reinvest')}}/{{$inv->id}}">
                                                            <i class="nav-icon fas fa-calendar-alt"></i> Reinvertir
                                                        </a>
                                                        <a class="btn badge badge-warning" href="{{url('rentafija/close')}}/{{$inv->id}}">
                                                            <i class="nav-icon fas fa-hand-holding-usd"></i> Liquidar
                                                        </a>
                                                    @else
                                                        {{ round(round((time() - strtotime($inv->initialDate)) / (60 * 60 * 24)) / $inv->term * 100,2) }}%
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width: {{ round(round((time() - strtotime($inv->initialDate)) / (60 * 60 * 24)) / $inv->term * 100,2) }}%"></div>
                                                        </div>   
                                                    @endif  
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Dividendos</h3>
                            </div>           
                            <div class="card-body" style="display: block;">
                                <div class="chart"><div class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand"><div class=""></div></div><div class="chartjs-size-monitor-shrink"><div class=""></div></div></div>
                                <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 604px;" width="604" height="250" class="chartjs-render-monitor"></canvas>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->

                    </section>
                    <!-- right col -->
                </div>

                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


  <!-- ChartJS -->
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

    $(function () {

var areaChartData = {
  labels  : [
      @foreach($dividendGraph as $dividend)
      '{{$dividend->year}}-{{$dividend->month}}',
      @endforeach
  ],
  datasets: [
    {
      label               : 'Dividendos por mes',
      backgroundColor     : 'rgba(60,141,188,0.9)',
      borderColor         : 'rgba(60,141,188,0.8)',
      pointRadius          : false,
      pointColor          : '#3b8bba',
      pointStrokeColor    : 'rgba(60,141,188,1)',
      pointHighlightFill  : '#fff',
      pointHighlightStroke: 'rgba(60,141,188,1)',
      data                : [
        @foreach($dividendGraph as $dividend)
            '{{$dividend->amount}}',
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
