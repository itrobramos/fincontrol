@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Editar proyecto</h1>
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

        <div class="d-flex justify-content-center">
            <!-- /.card-header -->

            <div class="col-md-10 col-lg-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">{{$project->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/snowballprojects/' .$project->id) }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        {{ method_field('PATCH')}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" class="form-control" value="{{$project->name}}">
                            </div>

                            <div class="form-group">
                                <label for="Precio">Precio ODI</label>
                                <input type="number" step="any" name="price" value="{{$project->ODIPrice}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Estimado">Dividendo Estimado</label>
                                <input type="text" name="estimatedDividend" value="{{$project->estimatedDividend}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Periodo">Frecuencia Dividendo</label>
                                <input type="text" name="dividendPeriod" value="{{$project->dividendPeriod}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Shares">Cantidad de acciones</label>
                                <input type="number" step="any" name="shares" value="{{$project->shares}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Oferta">Oferta</label>
                                <input type="number" step="any" name="offering" value="{{$project->offering}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Imagen</label>
                                <input type='file' name="image" value="{{$project->image}}" id="imageUrl" class='form-control-file'>
                            </div>



                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('snowballprojects')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
                            <button type="submit" class="btn btn-success ml-auto p-2">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- /.card-body -->
        </div>



    </div>



    <script>
        $(document).ready(function() {
            $('#projecttable').DataTable();
        });

    </script>

@endsection
