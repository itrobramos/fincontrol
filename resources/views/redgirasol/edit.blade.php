@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Editar Proyecto</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Red Girasol</li>
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
                        <h3 class="card-title">Editar {{$project->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/redgirasol/' .$project->id) }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        {{ method_field('PATCH')}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Clave">ID</label>
                                <input type="text" name="id" value="{{$project->id}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" value="{{$project->name}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Tipo</label>
                                <input type="text" name="type" value="{{$project->type}}"  class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Costo">Calificacion</label>
                                <input type="text" name="qualification" value="{{$project->qualification}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Estatus</label>
                                <input type="text" name="status" value="{{$project->status}}"  class="form-control">
                            </div>

                            
                            <div class="form-group">
                                <label for="Type">Monto</label>
                                <input type="number" name="investment" value="{{$project->investment}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Estimado mensual</label>
                                <input type="number" name="monthly_estimated" value="{{$project->monthly_estimated}}" step="any" class="form-control">
                            </div>

                            
                            <div class="form-group">
                                <label for="Type">Tasa</label>
                                <input type="number" name="rate" value="{{$project->rate}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Mensualidades</label>
                                <input type="number" name="months" value="{{$project->months}}"  class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Currency">Moneda</label>
                                <select class="form-control" name="currency" value="{{$project->currency}}">
                                    <option value="1">MXN</option>
                                    <option value="2">USD</option>
                                    <option value="3">EUR</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Costo">Fecha Compra</label>
                                <input type="date" name="date" value="{{$project->transactionDate}}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Imagen</label>
                                <input type='file' name="image" value="{{$project->image}}" id="imageUrl" class='form-control-file'>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('redgirasol')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
            $('#stocktable').DataTable();
        });

    </script>

@endsection
