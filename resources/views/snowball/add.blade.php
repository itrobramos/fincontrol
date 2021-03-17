@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Proyecto Snowball</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/snowball">Snowball</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="d-flex justify-content-center">
            <!-- /.card-header -->

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Agregar acciones</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/snowball') }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Proyecto">Proyecto</label>
                                <select class="form-control" name="projectId">
                                    @foreach($projects as $project)
                                        <option value="{{$project->id}}">{{$project->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Precio">Precio ODI</label>
                                <input type="number" step="any" name="price" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Shares">Cantidad de acciones</label>
                                <input type="number" step="any" name="shares" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="FechaTransaccion">Fecha Transacción</label>
                                <input type="date" name="transactiondate" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="FechaEfectiva">Fecha Efectiva</label>
                                <input type="date" name="efectivedate" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Documento</label>
                                <input type='file' name="pdf" id="pdfURL" class='form-control-file'>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('snowball')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
