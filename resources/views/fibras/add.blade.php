@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mis Fibras</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Mis Fibras</li>
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
                        <h3 class="card-title">Agregar fibras</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/fibras') }}">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Clave">Símbolo</label>
                                <input type="text" name="symbol" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Cantidad">Cantidad</label>
                                <input type="number" name="quantity" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Costo">Costo Promedio</label>
                                <input type="number" name="average" step="any" class="form-control">
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
                                <label for="Broker">Broker</label>
                                <select class="form-control" name="broker">
                                    @foreach($brokers as $broker)
                                        <option value="{{$broker->id}}">{{$broker->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('fibras')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
