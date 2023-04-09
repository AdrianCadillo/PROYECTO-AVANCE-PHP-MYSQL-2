<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{$this->asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{$this->asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{$this->asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="../../index2.html" class="h1"><b>Acceso al </b>Sistema</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

  @if($this->existSession("errores_login"))
      <div class="alert alert-danger">
        @foreach ($this->getSession("errores_login") as $error)
        <li>{{$error}}</li>
        @endforeach
      </div>
      {{$this->deleteSession("errores_login")}}
      @endif
      
      @if($this->existSession("mensaje_login"))
      <div class="alert alert-danger">
         <strong>{{$this->getSession("mensaje_login")}} </strong>
      </div>
      {{$this->deleteSession("mensaje_login")}}
      @endif

      <form action="{{URL_BASE}}login/login" method="post">

        <div class="form-group">
          <label for="rol" class="form-label"><b>Seleccione perfíl</b></label>
          <select name="rol" id="rol" class="form-control"> 
            <option  selected disabled> --- Perfíl --- </option>

            @if (isset($Roles))
                @foreach ($Roles as $role)
                    <option value="{{$role->id_rol}}" {{ $this->old('rol') == $role->id_rol? "selected" : "" }}>{{$role->name_rol}}</option>
                @endforeach
            @endif
          </select>
        </div>
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Email" name="email" 
          value="{{$this->old("email")}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="pasword"
          value="{{$this->old("pasword")}}">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              <input type="checkbox" id="remember">
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
 
     
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{$this->asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{$this->asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{$this->asset('dist/js/adminlte.min.js')}}"></script>

<script>
  $(document).ready(function(){
     
    $('input[name=email]').keypress(function(evt){
      if(evt.which == 13)
      {
        evt.preventDefault();
        
        if($(this).val().trim().length ==0)
        {
          $(this).focus()
        }else{
          $('input[name=pasword]').focus()
        }
      }
    })

    $('#rol').change(function(){
      $('input[name=email]').focus()
    })
  })
</script>
</body>
</html>
