@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Mis acciones</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Mis Acciones</li>
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
                            <table id="stocktable" class="table table-bordered table-striped dataTable dtr-inline"
                                role="grid" aria-describedby="example1_info">
                                <thead>
                                    <tr role="row">
                                        <th></th>
                                        <th>Broker</th>
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

                                    <tr role="row" class="odd">
                                        <td><img style="width:30px; height:30px;"src="https://etoro-cdn.etorostatic.com/market-avatars/pypl/150x150.png">
                                        </td>
                                        <td>eToro</td>
                                        <td>Paypal Holdings</td>
                                        <td>PYPL</td>
                                        <td>1</td>
                                        <td>$ 175.09</td>
                                        <td>$ 175.09</td>
                                        <td>41.24%</td>
                                        <td>$ 72.21</td>
                                        <td>$ 41.24</td>
                                        <td>$ 247.30</td>
                                    </tr>

                                    <tr role="row" class="odd">
                                      <td><img style="width:30px; height:30px;"src="https://etoro-cdn.etorostatic.com/market-avatars/amzn/150x150.png">
                                      </td>
                                      <td>GBM+</td>
                                      <td>Amazon</td>
                                      <td>AMZN</td>
                                      <td>2</td>
                                      <td>$ 2645.60</td>
                                      <td>$ 5291.20</td>
                                      <td>5%</td>
                                      <td>$ 264.56</td>
                                      <td>$ 5555.76</td>
                                      <td>$ 2777.88</td>
                                  </tr>

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
