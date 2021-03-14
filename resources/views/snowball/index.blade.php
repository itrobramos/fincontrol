@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Proyectos Snowball</h1>
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

            <br>
            <div class="row d-flex flex-row-reverse margin">
                    <a href="{{url('snowball/add')}}"><button type="button" class="btn btn-success">Registrar Compras</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                       
                        @foreach($odis as $odi)

                        <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                            <div class="card card-primary card-outline" style="height: 350px;">
                              <div class="card-body box-profile">
                                <div class="text-center">
                                  <img class="profile-user-img img-fluid img-circle" src="{{env('DEPLOY_URL')}}/{{$odi->imageUrl}}" alt="Logo">
                                </div>
                                <h3 class="profile-username text-center">{{$odi->Name}}</h3>
                                <ul class="list-group list-group-unbordered mb-3">
                                  <li class="list-group-item">
                                    <b>Acciones</b> <a class="float-right">{{$odi->quantity}}</a>
                                  </li>
                                  <li class="list-group-item">
                                    <b>Monto Invertido</b> <a class="float-right">$ {{$odi->investment}}</a>
                                  </li>
                                </ul>
                                <br>
                              </div>
                              <a href="snowball/{{$odi->id}}" class="btn btn-primary btn-block sticky-top"><b>Ver más</b></a>

                            </div>

                          </div>


                    @endforeach

                       
                          

                                   
                               
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </div>



    <script>
        $(document).ready(function() {
            $('#stocktable').DataTable();
        });

    </script>

@endsection
