@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Editar criptomonedas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Mis Criptomonedas</li>
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
                        <h3 class="card-title">Editar {{$stock->stock->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/criptossimple/' .$stock->id) }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        {{ method_field('PATCH')}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Cantidad">Cantidad</label>
                                <input type="number" name="quantity" step="any" class="form-control" value="{{$stock->quantity}}">
                            </div>

                            <div class="form-group">
                                <label for="Costo">Costo Promedio</label>
                                <input type="number" name="average" step="any" class="form-control" value="{{$stock->averagePrice}}">
                            </div>

                            <div class="form-group">
                                <label for="Currency">Moneda</label>
                                <select class="form-control" name="currency">
                                    <option value="1" @if($stock->currency->Symbol === "MXN") selected @endif>MXN</option>
                                    <option value="2" @if($stock->currency->Symbol === "USD") selected @endif>USD</option>
                                    <option value="3" @if($stock->currency->Symbol === "EUR") selected @endif>EUR</option>
                                </select>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('criptos')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
                            <button type="submit" class="btn btn-success ml-auto p-2">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>


            <!-- /.card-body -->
        </div>



    </div>



@endsection
