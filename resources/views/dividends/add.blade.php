@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Registrar Dividendo</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="{{url('dividends')}}">Dividendos</a></li>
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
                        <h3 class="card-title">Registrar Dividendo</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/dividends') }}">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Currency">Tipo</label>
                                <select class="form-control" name="type" id="cmbType">
                                    <option value="1">Acción</option>
                                    <option value="2">ETF</option>
                                    <option value="3">Fibras</option>
                                    <option value="4">Snowball</option>
                                </select>
                            </div>

                            <div class="form-group" id="cmbODIS" style="display:none;">
                                <label for="snowball">Snowball ODI</label>
                                <select class="form-control" name="odi">
                                    @foreach($odis as $odi)
                                        <option value="{{$odi->id}}">{{$odi->Name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="cmbFibras" style="display:none;">
                                <label for="fibras">Fibras</label>
                                <select class="form-control" name="fibra">
                                    @foreach($fibras as $fibra)
                                        <option value="{{$fibra->id}}">{{$fibra->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group" id="cmbAcciones" style="display:inblock;">
                                <label for="stocks">Acción</label>
                                <select class="form-control" name="stock">
                                    @foreach($stocks as $stock)
                                        <option value="{{$stock->id}}">{{$stock->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label for="Fecha">Fecha</label>
                                <input type="date" name="date" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Cantidad">$ Recibido</label>
                                <input type="number" name="amount" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="CantidadAcciones">Cantidad Acciones</label>
                                <input type="number" name="stockCount" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Currency">Moneda</label>
                                <select class="form-control" name="currency">
                                    <option value="1">MXN</option>
                                    <option value="2">USD</option>
                                    <option value="3">EUR</option>
                                </select>
                            </div>


                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('dividends')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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

        $("#cmbType").change(function(){
            var type = $("#cmbType").val();

            if(type == 1){
                $("#cmbAcciones").show();
                $("#cmbFibras").hide();
                $("#cmbODIS").hide();
            }
            else if(type == 2){
                $("#cmbAcciones").hide();
                $("#cmbFibras").hide();
                $("#cmbODIS").hide();
            }
            else if(type == 3){
                $("#cmbAcciones").hide();
                $("#cmbFibras").show();
                $("#cmbODIS").hide();
            }
            else if(type == 4){
                $("#cmbAcciones").hide();
                $("#cmbFibras").hide();
                $("#cmbODIS").show();
            }

        });
    </script>

@endsection
