@extends('layouts.business')


@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark"></h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Perfil</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>

        <div class="card">
            <!-- /.card-header -->
            <div class="card-body">
               
                <section class="content">
                    <div class="container-fluid">
                      <div class="row">
                        <div class="col-md-3">
              
                          <!-- Profile Image -->
                          <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                              <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{env('DEPLOY_URL')}}/{{Auth::user()->imageUrl}}" alt="User profile picture">
                              </div>
              
                              <br>
                              <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>
                              <br>
                             
                            </div>
                            <!-- /.card-body -->
                          </div>
                          <!-- /.card -->
              
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                          <div class="card card-primary card-outline">
                            <div class="card-body">
                              <div class="tab-content">
                               
                                <form role="form" method="Post" action="{{ url('/profile/') }}" enctype="multipart/form-data">
                                    {{ csrf_field()}}
                                    {{ method_field('PATCH')}}
                                      <div class="form-group row">
                                      <label for="inputName" class="col-sm-2 col-form-label">Name</label>
                                      <div class="col-sm-6">
                                        <input type="text" class="form-control" name="name" id="inputName" placeholder="Name" value="{{Auth::user()->name}}">
                                      </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-sm-2 col-form-label">Imagen</label>
                                        <div class="col-sm-6">
                                            <input type='file' name="image" id="imageUrl" class='form-control-file'>
                                          </div>
                                    </div>
        
                                    <br>
                                    <div class="form-group row">
                                      <div class="offset-sm-2 col-sm-6">
                                        <button type="submit" class="btn btn-block btn-success">Guardar</button>
                                      </div>
                                    </div>
                                  </form>
                                <!-- /.tab-pane -->
                              </div>
                              <!-- /.tab-content -->
                            </div><!-- /.card-body -->
                          </div>
                          <!-- /.card -->
                        </div>
                        <!-- /.col -->
                      </div>
                      <!-- /.row -->
                    </div><!-- /.container-fluid -->
                  </section>


            <!-- /.card-body -->
        </div>
    </div>


    </div>

@endsection
