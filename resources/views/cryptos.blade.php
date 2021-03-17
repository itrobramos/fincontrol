@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mis Cryptomonedas</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active">Cryptomonedas</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap4">

                    <div class="row">
                        <div class="col-sm-12">
                            <table id="stocktable" class="table table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th></th>
                                        <th>Exchange</th>
                                        <th>Nombre</th>
                                        <th>Clave</th>
                                        <th>Unidades</th>
                                        <th>Costo Promedio</th>
                                        <th>Inversión</th>
                                        <th>G/P(%)</th>
                                        <th>G/P($)</th>
                                        <th>Valor</th>
                                        <th>Actual</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- <tr role="row" class="odd">
                                        <td><img style="height:25px;"src="https://s2.coinmarketcap.com/static/img/coins/200x200/1.png">
                                        </td>
                                        <td>Bitso</td>
                                        <td>Bitcoin</td>
                                        <td>BTN</td>
                                        <td>0.0008277</td>
                                        <td>703628.29</td>
                                        <td>600</td>
                                        <td>15%</td>
                                        <td>$ 90.00</td>
                                        <td>$ 690.00</td>
                                        <td>$ 703699.99</td>
                                    </tr> --}}

                                  

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
