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
                            <li class="breadcrumb-item active">Fintech</li>
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
                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/snowball.png" alt="Logo">
                                </div>
                              </div>
                              <a href="snowball" class="btn btn-primary btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>
    
                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-warning card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/redgirasol.png" alt="Logo">
                                </div>
                              </div>
                              <a href="redgirasol" class="btn btn-warning btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-dark card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/expansive.png" alt="Logo">
                                </div>
                              </div>
                              <a href="expansive" class="btn btn-dark btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-danger card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/100ladrillos.png" alt="Logo">
                                </div>
                              </div>
                              <a href="100ladrillos" class="btn btn-danger btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/monific.png" alt="Logo">
                                </div>
                              </div>
                              <a href="monific" class="btn btn-primary btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>
    
                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-danger card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" style="height: 100px;" src="{{env('DEPLOY_URL')}}/images/lendera.png" alt="Logo">
                                </div>
                              </div>
                              <a href="lendera" class="btn btn-danger btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>


                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-success card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" src="{{env('DEPLOY_URL')}}/images/cumplo.png" alt="Logo">
                                </div>
                              </div>
                              <a href="cumplo" class="btn btn-success btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-success card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" style="height:120px;" src="{{env('DEPLOY_URL')}}/images/yotepresto.png" alt="Logo">
                                </div>
                              </div>
                              <a href="yotepresto" class="btn btn-success btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>


                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-success card-outline" style="height: 200px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="img-fluid" style="height:120px;" src="{{env('DEPLOY_URL')}}/images/prestadero.png" alt="Logo">
                                </div>
                              </div>
                              <a href="prestadero" class="btn btn-success btn-block sticky-top"><b>Entrar</b></a>
                            </div>
                        </div>



                    </div>

                    

                   


                </div>
            <!-- /.card-body -->
        </div>
    </div>


    </div>

@endsection
