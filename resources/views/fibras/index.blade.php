@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mis fibras</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Mis fibras</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <div class="row d-flex flex-row-reverse margin">
                    <a href="{{url('fibras/add')}}"><button type="button" class="btn btn-success">Agregar</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="stocktable" class="table table-bordered table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th></th>
                                      
                                        <th>Símbolo</th>
                                        <th>Nombre</th>
                                        <th>Unidades</th>
                                        <th>Costo Promedio</th>
                                        <th>Inversión</th>
                                        <th>Moneda</th>
                                        <th>Broker</th>
                                        <th>G/P(%)</th>
                                        <th>G/P($)</th>
                                        <th>Valor</th>
                                        <th>Actual</th>
                                        <th>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($myStocks as $stock)

                                        <tr role="row" class="odd">
                                            <td style="vertical-align: middle; text-align:center;"><img style="width:60px;"src="{{$stock->imageUrl}}"></td>                                        
                                            <td style="vertical-align: middle; text-align:center;">{{$stock->symbol}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$stock->name}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$stock->quantity}}</td>
                                            <td style="vertical-align: middle; text-align:center;">$ {{$stock->averagePrice}}</td>
                                            <td style="vertical-align: middle; text-align:center;">$ {{$stock->averagePrice * $stock->quantity}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$stock->currency}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$stock->broker}}</td>
                                            <td style="vertical-align: middle; text-align:center;"></td>
                                            <td style="vertical-align: middle; text-align:center;"></td>
                                            <td style="vertical-align: middle; text-align:center;"></td>
                                            <td style="vertical-align: middle; text-align:center;"></td>
                                            <td style="vertical-align: middle; text-align:center;">
                                                <a href="{{url('fibras/'.$stock->iduserstock.'/edit')}}" class="btn btn-app">
                                                    <i class="fas fa-edit"></i>
                                                  </a>
                                                  
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
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
