@extends('layouts.business')


@section('content')



    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Calendario de Pagos</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{url('rentafija')}}">Renta Fija</a></li>
                            <li class="breadcrumb-item"><a href="{{url('rentafija/'.$investment->FixedRentPlatform->id)}}">{{$investment->FixedRentPlatform->name}}</a></li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>


        <div class="car">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-widget widget-user">
                        <div class="card-footer">
                          <div class="row">
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">{{$investment->initialDate}}  <i class="fas fa-arrow-right"></i>    {{$investment->endDate}}</h5>
                                <span class="description-text">Fecha Inversión</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 border-right">
                              <div class="description-block">
                                <h5 class="description-header">$ {{$investment->amount}}</h5>
                                <span class="description-text">Monto</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4">
                              <div class="description-block">
                                <h5 class="description-header">{{round(round((time() - strtotime($investment->initialDate)) / (60 * 60 * 24)) / $investment->term * 100,2)}} %</h5>
                                <span class="description-text">Avance</span>
                              </div>
                              <!-- /.description-block -->
                            </div>
                            <!-- /.col -->
                          </div>
                          <!-- /.row -->
                        </div>
                      </div>
                </div>
            </div>
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cantidad</th>
                            <th>Estatus</th>
                            <th>Avance</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach($paids as $paid)
                            <tr class=''>
                                <td>{{$paid['number']}}</td>
                                <td>{{$paid['payDay']}}</td>
                                <td>$ {{$paid['amount']}}</td>
                                <td>
                                    @if($paid['payDay'] < date('Y-m-d'))
                                        <span class='btn badge badge-success'>Pagado</span>
                                    @elseif($paid['payDay'] == date('Y-m-d'))
                                        <span class='btn badge badge-success'>Día de Pago</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $paid['percent'] }}%
                                    <div class="progress">
                                        <div class="progress-bar" style="width: {{$paid['percent']}}%"></div>
                                    </div>   
                                </td>
                            </tr>
                            @endforeach

                        </tbody>
                      </table>
                </div>
            </div>
        </div>


    </div>

@endsection
