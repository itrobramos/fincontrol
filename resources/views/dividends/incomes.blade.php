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
                            <li class="breadcrumb-item active"><a href="{{ url('dividends') }}">Dividendos</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <br>
            <div class="row d-flex flex-row-reverse margin">
                <a href="{{ url('dividends/add') }}"><button type="button" class="btn btn-success">Agregar</button></a>
            </div>



            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">

                    <div class="col-lg-4 col-md-4">
                        <!-- small card -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup> {{ $indicadores['month'] }}</h3>

                                <p>Mes Actual</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-md-4">
                        <!-- small card -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup> {{ $indicadores['year'] }}</h3>

                                <p>Año Actual</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-md-4">
                        <!-- small card -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3><sup style="font-size: 20px">$</sup> {{ $indicadores['history'] }}</h3>

                                <p>Histórico</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                    <!-- ./col -->

                </div>

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Pagos</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                    class="fas fa-times"></i></button>
                        </div>
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
                    <!-- /.card-body -->
                </div>


                <br><br>

                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="stocktable" class="table table-bordered table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th></th>
                                        <th style="vertical-align: middle; text-align:center;">Fecha</th>
                                        <th style="vertical-align: middle; text-align:center;">Fintech</th>
                                        <th style="vertical-align: middle; text-align:center;">Nombre</th>
                                        <th style="vertical-align: middle; text-align:center;">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($incomes as $income)

                                        <tr role="row" class="odd">
                                            <td style="width:150px;">
                                                <center><img class="img-fluid"
                                                        src="{{ env('DEPLOY_URL') }}/images/{{ $income->logoFintech }}"
                                                        style="display: block; margin-left: auto; margin-right: auto; height:50px;"
                                                        alt="Logo"></center>
                                            </td>
                                            <td style="vertical-align: middle; text-align:center;">
                                                {{ $income->efectiveDate }}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{ $income->fintech }}
                                            </td>
                                            <td style="vertical-align: middle; text-align:center;">{{ $income->name }}</td>
                                            <td style="vertical-align: middle; text-align:center;">$ {{ $income->amount }}
                                            </td>
                                        </tr>

                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>




    <!-- ChartJS -->
    <script src="../dist/Chart.min.js"></script>
    <script>
        $(function() {

            var areaChartData = {
                labels: [
                    @foreach ($paymentGraph as $income)
                        '{{ $income->year }}-{{ $income->month }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Pagos por mes',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        @foreach ($paymentGraph as $income)
                            '{{ $income->amount }}',
                        @endforeach
                    ]
                }]
            }

            var barChartCanvas = $('#barChart').get(0).getContext('2d')
            var barChartData = jQuery.extend(true, {}, areaChartData)
            var temp0 = areaChartData.datasets[0]
            barChartData.datasets[0] = temp0

            var barChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                datasetFill: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            min: 0
                        }
                    }]
                }
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })



        })

        $(document).ready(function() {
            $('#stocktable').DataTable();
        });
    </script>



@endsection
