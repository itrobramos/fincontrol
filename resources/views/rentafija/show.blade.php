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
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('rentafija')}}">Renta Fija</a></li>
                            <li class="breadcrumb-item active">{{$platform->name}}</li>

                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3">
                            <img class="card-img-top" src="{{env('DEPLOY_URL')}}/images/{{$platform->imageUrl}}" alt="Logo">
                    </div>
                    
                    <div class="col-lg-3 col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{$investments->count()}}</h3>
                            <p>Cantidad Inversiones</p>
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
                            <h3><sup style="font-size: 20px">$ </sup>{{$investments->sum(('amount'))}}</h3>
                            <p>Monto Inversión</p>
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
                            <h3><sup style="font-size: 20px">$</sup>{{$diario}}</h3>
                            <p>Diario</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>

                <br>

                <div class="row d-flex flex-row-reverse margin">
                    <a href="{{url('rentafija/' . $platform->id . '/add')}}"><button type="button" class="btn btn-success">Registrar</button></a>
                </div>

                <br>
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Plazo</th>
                            <th>Tasa</th>
                            <th>Inversión</th>
                            <th>Avance</th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach($investments as $inv)
                            <tr>
                                <td>{{$inv->initialDate}}</td>
                                <td>{{$inv->term}}</td>
                                <td>{{$inv->rate}} %</td>
                                <td>$ {{$inv->amount}}</td>
                                <td>{{ round(round((time() - strtotime($inv->initialDate)) / (60 * 60 * 24)) / $inv->term * 100,2) }}%
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{ round(round((time() - strtotime($inv->initialDate)) / (60 * 60 * 24)) / $inv->term * 100,2) }}%"></div>
                                    </div>   
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>


    </div>

@endsection
