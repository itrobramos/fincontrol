@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Gastos</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Mis Gastos</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">

            <div class="row d-flex flex-row-reverse margin">
                <a href="{{ url('expenses/Add') }}"><button type="button" class="btn btn-success">Agregar</button></a>
            </div>

            <!-- /.card-header -->
            <div class="card-body">
               
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="tableExpenses" class="table table-bordered table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th style="vertical-align: middle; text-align:center;">Fecha</th>
                                        <th style="vertical-align: middle; text-align:center;">Categoría</th>
                                        <th style="vertical-align: middle; text-align:center;">Nombre</th>
                                        <th style="vertical-align: middle; text-align:center;">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach($expenses as $expense)

                                        <tr role="row" class="odd">
                                            <td style="vertical-align: middle; text-align:center;">{{$expense->date}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$expense->category['name']}}</td>
                                            <td style="vertical-align: middle; text-align:center;">{{$expense->name}}</td>
                                            <td style="vertical-align: middle; text-align:center;">$ {{$expense->amount}}</td>

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
    $('#tableExpenses').DataTable();
});

</script>

@endsection