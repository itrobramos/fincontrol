@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">{{$account->name}}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('accounts')}}">Cuentas</a></li>
                            <li class="breadcrumb-item"><a href="{{url('accounts/' .$account->id)}}">{{$account->name}}</a></li>
                            <li class="breadcrumb-item active">Registrar movimiento</li>
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
                        <h3 class="card-title">Agregar movimiento {{$account->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/accounts/register') }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Tipo">Tipo</label>
                                <select class="form-control" name="type" id="cmbTipo">
                                    <option value="1">Ingreso</option>
                                    <option value="2">Egreso</option>
                                </select>
                            </div>

                            
                            <div class="form-group">
                                <label for="Concepto">Concepto</label>
                                <input type="hidden" name="accountId" value="{{$account->id}}" class="form-control">
                                <input type="text" name="concept" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Monto">Monto</label>
                                <input type="number" step="any"  name="amount" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Fecha">Fecha</label>
                                <input type='date' name="transactionDate" id="fecha" class='form-control'>
                            </div>

                            <div class="form-group" style="display: none;" id="plataformaTransferir">
                                <label for="Retirar a">Plataforma a Transferir:</label>
                                <select class="form-control" name="account">
                                        <option value="0">Ninguna</option>
                                    @foreach($accountsList as $account)
                                        <option value="{{$account->accountId}}">{{$account->name}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Imagen</label>
                                <input type='file' name="image" id="imageUrl" class='form-control-file'>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('accounts')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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

        $("#cmbTipo").change(function(){
            var selectedValue = $("#cmbTipo").val()
            if(selectedValue == 2)
                $("#plataformaTransferir").fadeIn("slow");
            else
                $("#plataformaTransferir").fadeOut("slow");
                        
        });

    </script>

@endsection
