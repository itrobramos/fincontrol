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
                            <li class="breadcrumb-item active">Cuentas</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <br>
            <div class="row d-flex flex-row-reverse margin">
                <a href="{{url('accounts/configure')}}"><button type="button" class="btn btn-primary">Selección de Cuentas</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                           
                        @foreach($accounts as $account)
                            <div class="col-xlg-3 col-lg-3 col-md-4 col-sm-6">
                                <div class="card card-{{$account->tag}} card-outline" style="height: 200px;">
                                    <div class="card-body box-profile">
                                        <div class="text-center">
                                            <img class="img-fluid" src="{{env('DEPLOY_URL')}}/{{$account->imageUrl}}" alt="Logo">
                                        </div>
                                        <h3 class="profile-username text-center"></h3>
                                    </div>
                                    <a href="{{url('accounts/' . $account->accountId)}}" class="btn btn-{{$account->tag}} btn-block sticky-top"><b>Entrar</b></a>
                                </div>
                            </div>
                        @endforeach

                    </div>
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
