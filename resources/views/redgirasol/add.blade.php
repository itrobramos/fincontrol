@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Red Girasol</h1>
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

            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Agregar proyecto</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/redgirasol') }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Clave">ID</label>
                                <input type="text" name="id" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Tipo</label>
                                <input type="text" name="type"  class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Costo">Calificacion</label>
                                <input type="text" name="qualification" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Estatus</label>
                                <input type="text" name="status"  class="form-control">
                            </div>

                            
                            <div class="form-group">
                                <label for="Type">Monto</label>
                                <input type="number" name="investment" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Estimado mensual</label>
                                <input type="number" name="monthly_estimated" step="any" class="form-control">
                            </div>

                            
                            <div class="form-group">
                                <label for="Type">Tasa</label>
                                <input type="number" name="rate" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Type">Mensualidades</label>
                                <input type="number" name="months"  class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Currency">Moneda</label>
                                <select class="form-control" name="currency">
                                    <option value="1">MXN</option>
                                    <option value="2">USD</option>
                                    <option value="3">EUR</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Costo">Fecha Compra</label>
                                <input type="date" name="date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Imagen</label>
                                <input type='file' name="image" id="imageUrl" class='form-control-file'>
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
