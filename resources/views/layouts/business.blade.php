<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>FinControl | Dashboard</title>
  
  <link rel="apple-touch-icon" sizes="180x180" href="{{env('DEPLOY_URL')}}/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="{{env('DEPLOY_URL')}}/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="{{env('DEPLOY_URL')}}/favicon-16x16.png">
  <link rel="manifest" href="{{env('DEPLOY_URL')}}/site.webmanifest">


  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bbootstrap 4 -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/dist/css/adminlte.min.css">
   <!-- Own style -->
   <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/dist/css/app.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="{{env('DEPLOY_URL')}}/plugins/summernote/summernote-bs4.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link href="//cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
  
  
  <!-- jQuery -->
  <script src="{{env('DEPLOY_URL')}}/plugins/jquery/jquery.min.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{url('home')}}" class="brand-link">
      <img src="{{env('DEPLOY_URL')}}/favicon-32x32.png" alt="admin" class="brand-image">
      <span class="brand-text font-weight-light">FinControl</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{env('DEPLOY_URL')}}/{{Auth::user()->imageUrl}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{url('profile')}}" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{url('home')}}" class="nav-link">
              <i class="nav-icon fas fa-chart-line"></i>
              <p>
                Dashboard
                <i class="right"></i>
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('stocks')}}" class="nav-link">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Mis Acciones
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('fintech')}}" class="nav-link">
              <i class="nav-icon fas fa-laptop"></i>
              <p>
                Fintech
              </p>
            </a>
          </li>
         
          <li class="nav-item">
            <a href="{{url('rentafija')}}" class="nav-link">
              <i class="nav-icon fas fa-calendar-alt"></i>
              <p>
                Renta Fija
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('dividends')}}" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Dividendos
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('incomes')}}" class="nav-link">
              <i class="nav-icon fas fa-hand-holding-usd"></i>
              <p>
                Entradas
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('accounts')}}" class="nav-link">
              <i class="nav-icon fas fa-dollar-sign"></i>
              <p>
                Cuentas Efectivo
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('fibras')}}" class="nav-link">
              <i class="nav-icon fas fa-building"></i>
              <p>
                Fibras
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('criptos')}}" class="nav-link">
              <i class="nav-icon fab fa-bitcoin"></i>
              <p>
                Criptomonedas
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-edit"></i>
              <p>
                Registro de Gastos
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">

              <li class="nav-item">
                <a href="{{url('expenses/categories')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Categorías</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('expenses/index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Presupuesto</p>
                </a>
              </li>

              <li class="nav-item">
                <a href="{{url('expenses/index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gastos</p>
                </a>
              </li>


            </ul>
          </li>
 
          <li class="nav-item">
            <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
              <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
              <p class="text">Cerrar sesión</p>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
          </form>
          </li>
       
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
     </ul>

   

  </nav>

  @yield('content')

  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="http://miyodelfuturo.com.mx">Mi yo del futuro</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="{{env('DEPLOY_URL')}}/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{env('DEPLOY_URL')}}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="{{env('DEPLOY_URL')}}/plugins/chart.js/Chart.min.js"></script>
<!-- Sparkline -->
<script src="{{env('DEPLOY_URL')}}/plugins/sparklines/sparkline.js"></script>
<!-- JQVMap -->
<script src="{{env('DEPLOY_URL')}}/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="{{env('DEPLOY_URL')}}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{env('DEPLOY_URL')}}/plugins/jquery-knob/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{env('DEPLOY_URL')}}/plugins/moment/moment.min.js"></script>
<script src="{{env('DEPLOY_URL')}}/plugins/daterangepicker/daterangepicker.js"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{env('DEPLOY_URL')}}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
<!-- Summernote -->
<script src="{{env('DEPLOY_URL')}}/plugins/summernote/summernote-bs4.min.js"></script>
<!-- overlayScrollbars -->
<script src="{{env('DEPLOY_URL')}}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="{{env('DEPLOY_URL')}}/dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{env('DEPLOY_URL')}}/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{env('DEPLOY_URL')}}/dist/js/demo.js"></script>
<script src="//cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>

{{-- <script>
$(document).ready(function() {
  $( ".nav-link" ).bind( "click", function(event) {
      var clickedItem = $( this );
      $( ".nav-link" ).each( function() {
          $( this ).removeClass( "active" );
      });
      clickedItem.addClass( "active" );
  });
});
</script> --}}

</body>
</html>

                 
           