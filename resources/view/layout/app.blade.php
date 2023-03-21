<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('titulo_')</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  
  <link rel="stylesheet" href="{{$this->asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- IonIcons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{$this->asset('dist/css/adminlte.min.css')}}">
  <!--- DataTable ---->
  <link rel="stylesheet" href="{{$this->asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{$this->asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{$this->asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
  
  <!--- CSS PARA SWETTALERT 2 --->

  <link rel="stylesheet" href="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.css')}}">
  <link rel="stylesheet" href="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.min.css')}}">
  
</head>
<!--
`body` tag options:

  Apply one or more of the following classes to to the body tag
  to get the desired effect

  * sidebar-collapse
  * sidebar-mini
-->
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  {{--- INCLUIR EL COMPONENTE NAV ------}}

  @include($this->getComponents("components.nav"))

  {{--- INCLUIR EL COMPONENTE SIDEBAR ------}}

  @include($this->getComponents("components.Sidebar"))

   {{--- INCLUIR EL COMPONENTE Wrapper------}}

   @include($this->getComponents("components.Wrapper"))

     <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>

    {{--- INCLUIR EL COMPONENTE Wrapper------}}


  @include($this->getComponents("components.Footer"))


   
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{$this->asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{$this->asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE -->
<script src="{{$this->asset('dist/js/adminlte.js')}}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{$this->asset('plugins/chart.js/Chart.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{$this->asset('dist/js/demo.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{$this->asset('dist/js/pages/dashboard3.js')}}"></script>

{{-- DataTable js ----}}

<script src="{{$this->asset('plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{$this->asset('plugins/jszip/jszip.min.js')}}"></script>
<script src="{{$this->asset('plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{$this->asset('plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{$this->asset('plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<!-- SCRIPT PARA SWEETALERT2--->
<script src="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.all.js')}}"></script>
<script src="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.all.min.js')}}"></script>
<script src="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.js')}}"></script>
<script src="{{$this->asset('node_modules/sweetalert2/dist/sweetalert2.min.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
@yield('script_js')
</body>
</html>
