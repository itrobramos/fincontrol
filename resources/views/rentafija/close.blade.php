@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Cerrar inversión</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('rentafija')}}">Renta Fija</a></li>
                            <li class="breadcrumb-item"><a href="{{url('rentafija/' . $Investment->FixedRentPlatform->id)}}">{{$Investment->FixedRentPlatform->name}}</a></li>
                            <li class="breadcrumb-item active">Cerrar Inversión</li>
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
                        <h3 class="card-title">Cerrar inversión</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->

                    <form role="form" method="POST" action="{{ url('/rentafija/close') }}" enctype="multipart/form-data">
                        {{ csrf_field()}}
                        <div class="card-body">


                            <div class="form-group">
                                <label for="Plataforma">Plataforma</label>
                                <input type="text" name="platform" value="{{$Investment->FixedRentPlatform->name}}" readonly class="form-control">
                                <input type="hidden" name="platformId" value="{{$Investment->FixedRentPlatform->id}}" class="form-control"> 
                                <input type="hidden" name="id" value={{$Investment->id}}>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Monto">Monto</label>
                                        <input type="number" step="any" name="amount" class="form-control" id="amount"  value={{$Investment->amount + $Investment->totalEarnings}}>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="Retirar a">Plataforma a Retirar:</label>
                                        <select class="form-control" name="account">
                                            @foreach($accounts as $account)
                                                <option value="{{$account->accountId}}">{{$account->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer d-flex">
                            <a href="{{url('rentafija/' . $Investment->FixedRentPlatform->id)}}"><button type="button" class="btn btn-danger p-2">Regresar</button></a>
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
            calculateEarnings();
        });

        $("#amount").change(function() {
            calculateEarnings();
        });

        $("#rate").change(function() {
            calculateEarnings();
        });

        $("#term").change(function() {
            calculateEarnings();
        });

        $(".termType").change(function() {
            calculateEarnings();
        });

        $("#fechaInicio").change(function() {
            calculateEndDate();
        });



        function calculateEarnings(){
            var amount = $("#amount").val();
            var term = $("#term").val();
            var rate = $("#rate").val() / 100;
            var termType = $('input[name="termType"]:checked').val();

            if(amount != null && term != null && rate != null && termType != null){
                
                if(termType == "days"){
                    earnings = ((amount * rate) / 360) * term;
                }
                else if(termType == "months"){
                    earnings = ((amount * rate) / 12) * term;
                }
                else if(termType == "years"){
                    earnings = ((amount * rate)) * term;
                }
             
                $("#earnings").val(earnings);
            }
            
        }

        function calculateEndDate(){

            
            var initialDate = $("#fechaInicio").val();
            var term = $("#term").val();
            var termType = $('input[name="termType"]:checked').val();

            if(termType == "days"){
                var date = new Date(); 
                var initialDate = $("#fechaInicio").val();
                date.setDate(initialDate + term);
                $("#fechaFin").val(date); 
            }
            else if(termType == "months"){
                earnings = ((amount * rate) / 12) * term;
            }
            else if(termType == "years"){
                earnings = ((amount * rate)) * term;
            }
        }
    </script>

@endsection
