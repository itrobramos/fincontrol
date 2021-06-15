@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Nuevo gasto</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Nuevo gasto</li>
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
                        <h3 class="card-title">Agregar nuevo gasto</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/expenses/Add') }}">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Fecha">Fecha</label>
                                <input type="date" name="date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Nombre">Nombre</label>
                                <input type="text" name="name" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Tienda">Tienda</label>
                                <input type="text" name="store" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Descripción">Descripción</label>
                                <textarea class="form-control" name="description"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="category">Categoría</label>
                                <select class="form-control" name="category">
                                    <option value="0">-Sin categoría padre-</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Monto">Monto</label>
                                <input type="number" name="amount" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="category">Cuenta</label>
                                <select class="form-control" name="account">
                                    <option value="0">-Sin Cuenta-</option>
                                    @foreach($accounts as $account)
                                        <option value="{{$account->id}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('expenses/categories')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
