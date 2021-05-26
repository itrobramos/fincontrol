@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Editar proyecto</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="/snowball">Snowball</a></li>
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
                        <h3 class="card-title">{{$ODI->snowballproject->name}}</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="Post" action="{{ url('/snowball/' .$ODI->id) }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        {{ method_field('PATCH')}}
                        <div class="card-body">

                            <div class="form-group">
                                <label for="Estimado">Cantidad ODIS</label>
                                <input type="number" name="quantity" value="{{$ODI->quantity}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Estimado">Precio Individual</label>
                                <input type="number" name="price" value="{{$ODI->ODIPrice}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Estimado">Dividendo</label>
                                <input type="number" name="dividend" value="{{$ODI->dividend}}" step="any" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="Bono">Bono</label>
                                <input type="number" name="bono" value="{{$ODI->bono}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Bono">Frecuencia (Meses)</label>
                                <input type="number" name="frequency" value="{{$ODI->frequency}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Bono">Fecha Efectiva</label>
                                <input type="date" name="efectiveDate" value="{{$ODI->efectiveDate}}" step="any" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="Imagen">Documento</label>
                                <input type='file' name="pdf" id="pdfURL" class='form-control-file'>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('snowballprojects')}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
            $('#projecttable').DataTable();
        });

    </script>

@endsection
