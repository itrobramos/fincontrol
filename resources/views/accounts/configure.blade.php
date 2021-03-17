@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Cuentas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('accounts')}}">Cuentas</a></li>
                            <li class="breadcrumb-item active">Selección de Cuentas</li>
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
                        <h3 class="card-title">Selección de cuentas</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/accounts/configure') }}" >
                        {{ csrf_field()}}
                        <div class="card-body">

                            <div class="card-body">
                                <div class="row">
                                  <div class="col-sm-6">


                                    @foreach($accounts as $account)

                                        <div class="form-group clearfix">
                                            <div class="icheck-primary d-inline">
                                                <input type="checkbox" name="account[]" value="{{$account->id}}" @if($account->selected) checked @endif  id="chk{{$account->id}}">
                                                <label for="chk{{$account->id}}">
                                                </label>
                                            </div>

                                            <label for="checkboxPrimary3">
                                                 {{$account->name}}
                                            </label>
                                        </div>
                                  
                                    @endforeach
                                    
                                
                                </div>
                                </div>
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

    </script>

@endsection
