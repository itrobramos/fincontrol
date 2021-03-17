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
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('accounts')}}">Cuentas</a></li>
                            <li class="breadcrumb-item active">{{$account->name}}</li>

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
                        <img class="card-img-top" src="{{env('DEPLOY_URL')}}/{{$account->imageUrl}}" alt="Logo">
                    </div>
                    
                    <div class="col-lg-6 col-md-6">
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-md-3">
                        <!-- small card -->
                        <div class="small-box bg-success">
                        <div class="inner">
                            <h3><sup style="font-size: 20px">$ {{$account->amount}} </sup></h3>
                            <p>Disponible</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row d-flex flex-row-reverse margin">
                    <a href="{{url('accounts/' . $account->accountId . '/register')}}"><button type="button" class="btn btn-success">Registrar</button></a>
                </div>

                <br>
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Cantidad</th>
                            <th>Descripción</th>
                            <th>Saldo</th>
                          </tr>
                        </thead>
                        <tbody>

                            @foreach($movements as $movement)

                                <tr>
                                    <td>{{$movement->transactionDate}}</td>
                                    <td>@if($movement->type == 1) Ingreso @else Egreso @endif</td>
                                    <td>{{$movement->amount}}</td>
                                    <td>{{$movement->concept}}</td>
                                    <td>{{$movement->resultAmount}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                      </table>
                </div>
            </div>
        </div>


    </div>

@endsection
