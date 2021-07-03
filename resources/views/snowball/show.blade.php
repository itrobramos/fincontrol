@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{ $odi->Name }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('home') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/snowball">Snowball</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-xl-3">
                            <div class="card mb-2 bg-gradient-dark">
                                <img class="card-img-top" src="{{ env('DEPLOY_URL') }}/{{ $odi->imageUrl }}" alt="Logo">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3">
                            <!-- small card -->
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>{{ $odi->quantity }}</h3>

                                    <p>Acciones</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-shopping-cart"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-3">
                            <!-- small card -->
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup>{{ $odi->investment }}</h3>
                                    <p>Inversión</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-dollar-sign"></i>
                                </div>
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-3">
                            <!-- small card -->
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3><sup style="font-size: 20px">$</sup>{{ $dividends->sum('amount') }}</h3>
                                    <p>Dividendos</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            Recuperación {{ $recovery }} %
                            <div class="progress">
                                <div class="progress-bar" style="width: {{ $recovery }}%"></div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" href="#shares"
                                                data-toggle="tab">Acciones</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#dividends"
                                                data-toggle="tab">Dividendos</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#info"
                                                data-toggle="tab">Información</a></li>

                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane" id="info">
                                            info
                                        </div>

                                        <div class="tab-pane active" id="shares">

                                            <div class="card">
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Cantidad</th>
                                                                <th>Total</th>
                                                                <th></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($shares as $share)
                                                                <tr>
                                                                    <td>{{ $share->efectiveDate }}</td>
                                                                    <td>{{ $share->quantity }}</td>
                                                                    <td>$ {{ $share->quantity * $share->ODIPrice }}</td>
                                                                    <td><a target="n_blank"
                                                                            href="{{ env('DEPLOY_URL') }}/{{ $share->pdfUrl }}"><button
                                                                                class="btn btn-md btn-info fas fa-eye"></button></a>
                                                                    </td>
                                                                    <td> <a class="btn btn-md btn-dark"
                                                                            href="{{ $share->id }}/edit">
                                                                            <span class="btn-inner-icon">
                                                                                <i class="fas fa-pencil-alt"></i>
                                                                            </span> Editar
                                                                        </a>
                                                                    </td>
                                                                </tr>

                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>


                                        </div>
                                        <div class="tab-pane" id="dividends">


                                            <div class="card card-primary">
                                                <div class="card-header">
                                                    <h3 class="card-title">Dividendos</h3>

                                                    <div class="card-tools">
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="collapse"><i class="fas fa-minus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-tool"
                                                            data-card-widget="remove"><i class="fas fa-times"></i></button>
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
                                                            width="604" height="250"
                                                            class="chartjs-render-monitor"></canvas>
                                                    </div>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>


                                            <div class="card">
                                                <!-- /.card-header -->
                                                <div class="card-body p-0">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Fecha</th>
                                                                <th>Recibido</th>
                                                                <th>Acciones</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($dividends as $dividend)
                                                                <tr>
                                                                    <td>{{ $dividend->efectiveDate }}</td>
                                                                    <td>$ {{ $dividend->amount }}</td>
                                                                    <td>{{ $dividend->stocksCount }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
            </div>

        </div>
    </div>



    <!-- ChartJS -->
    <script src="../dist/Chart.min.js"></script>
    <script>
        $(function() {

            var areaChartData = {
                labels: [
                    @foreach ($dividendGraph as $dividend)
                        '{{ $dividend['year'] }}-{{ $dividend['month'] }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Dividendos por mes',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
                        @foreach ($dividendGraph as $dividend)
                            '{{ $dividend['amount'] }}',
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
                datasetFill: false
            }

            var barChart = new Chart(barChartCanvas, {
                type: 'bar',
                data: barChartData,
                options: barChartOptions
            })


        });
    </script>

@endsection
