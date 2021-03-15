@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$odi->Name}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
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
                                <img class="card-img-top" src="{{env('DEPLOY_URL')}}/{{$odi->imageUrl}}" alt="Logo">
                            </div>
                        </div>
                        
                        <div class="col-lg-3 col-md-3">
                            <!-- small card -->
                            <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$odi->quantity}}</h3>
                
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
                                <h3><sup style="font-size: 20px">$</sup>{{$odi->investment}}</h3>
                
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
                                <h3><sup style="font-size: 20px">$</sup>{{$dividends->sum('amount')}}</h3>                
                                <p>Dividendos</p>                               
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            </div>
                        </div>

                        <div class="col-lg-3">
                            Recuperación {{$recovery }} %
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
                                    <li class="nav-item"><a class="nav-link active" href="#shares" data-toggle="tab">Acciones</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#dividends" data-toggle="tab">Dividendos</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#info" data-toggle="tab">Información</a></li>

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
                                                    <th style="width: 40px">Documento</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($shares as $share)
                                                    <tr>
                                                        <td>{{$share->efectiveDate}}</td>
                                                        <td>{{$share->quantity}}</td>
                                                        <td>$ {{$share->quantity * $share->ODIPrice}}</td>
                                                        <td><a target="n_blank" href="{{env('DEPLOY_URL')}}/{{$share->pdfUrl}}"><button class="btn btn-md btn-info fas fa-eye"></button></a></td>
                                                      </tr>
    
                                                    @endforeach
                                                </tbody>
                                              </table>
                                            </div>
                                            <!-- /.card-body -->
                                        </div>


                                  </div>
                                  <div class="tab-pane" id="dividends">  
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
                                                @foreach($dividends as $dividend)
                                                <tr>
                                                    <td>{{$dividend->efectiveDate}}</td>
                                                    <td>$ {{$dividend->amount}}</td>
                                                    <td>{{$dividend->stocksCount}}</td>
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



    <script>
        // $(document).ready(function() {
        //     $('.table').DataTable();
        // });

    </script>

@endsection
