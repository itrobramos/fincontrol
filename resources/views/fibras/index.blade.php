@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mis fibras</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Mis fibras</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <div class="row d-flex flex-row-reverse margin">
                <a href="{{ url('fibras/add') }}"><button type="button" class="btn btn-success">Agregar</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        
                        @foreach ($myStocks as $stock)

                            <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                                <div class="card card-primary card-outline" style="height: 400px;">
                                    <button type="button" class="btn btn-default btn-block  dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <button type="submit" class="btn btn-block">
                                            <a class="dropdown-item" href="fibras/{{ $stock['Id']}}/editsimple"> 
                                                <span class="btn-inner-icon">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </span> Editar
                                            </a>
                                        </button>
                                     
                                            <form method='post' action="{{ url('/fibras/' . $stock['Id']) }}">
                                                {{ csrf_field()}}
                                                {{ method_field('DELETE')}}

                                                <button type="submit" class="btn btn-block" onclick="return confirm('¿Está seguro?');">
                                                    <a class="dropdown-item"> 
                                                        <span class="btn-inner-icon">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </span> Borrar
                                                    </a>
                                                </button>

                                                
                                            </form>
                                        </a>

                                    </div>
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="img-fluid"
                                            src="{{ env('DEPLOY_URL') }}/{{ $stock['Imagen'] }}" style="height: 60px;" alt="Logo">
                                        </div>
                                        <h4 class="profile-username text-center">{{ $stock['Nombre'] }}</h4>
                                        <br>
                                        <ul class="list-group list-group-unbordered mb-3">
                                            <li class="list-group-item">
                                                <b>Acciones</b> <a class="float-right">{{  floatval($stock['Acciones']) }}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Monto Invertido</b> <a class="float-right">
                                                    ${{ $stock['Inversion']}}</a>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Portafolio Fibras</b> <a class="float-right">
                                                    {{ $stock['Porcentaje'] }} %</a>
                                            </li>
                                        </ul>
                                        <br>
                                    </div>
                                    <a href="fibras/{{ $stock['Id'] }}"
                                        class="btn btn-primary btn-block sticky-top"><b>Ver más</b>
                                    </a>
                                </div>
                            </div>
                        @endforeach



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
