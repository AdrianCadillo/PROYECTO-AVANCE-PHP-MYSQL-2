@extends($this->getComponents("layout.app"))

@section('titulo_','sistema-usuarios')

@section('contenido')
<div class="container">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Crear usuarios</h4>  
                
                <span class="float-right">
                    <button class="btn btn-primary btn-sm"><b>nuevo rol <i class="fas fa-plus"></i></b></button>
                </span>
            </div>
              
            <form action="{{URL_BASE}}usuario/store" method="post" enctype="multipart/form-data">
                <div class="card-body">
                     
                  @if ($this->existSession("error"))
                       <div class="row">
                         <div class="col">
                            <div class="alert alert-danger">
                                @foreach ($this->getSession("error") as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </div>
                         </div>
                       </div>
                       {{$this->deleteSession('error')}}
                  @endif

                 
                  <div class="row mt-1">
                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                       <div class="form-group">
                        <label for="username" class="form"><b>Username (*)</b></label>
                        <input type="text" name="username" id="username" class="form-control"
                        placeholder="Username..." autofocus value="{{$this->load("username")}}">
                       </div>
                    </div>

                    <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="form-group">
                         <label for="email" class="form"><b>Email (*)</b></label>
                         <input type="text" name="email" id="email" class="form-control"
                         placeholder="Email@gmail.com" value="{{$this->load("email")}}">
                        </div>
                     </div>

                     <div class="col-xl-6 col-lg-6 col-md-4  col-12">
                        <div class="form-group">
                         <label for="pasword" class="form"><b>Password (*)</b></label>
                         <input type="password" name="pasword" id="pasword" class="form-control"
                         placeholder="Password...."  >
                        </div>
                     </div>
                  </div>
                   <div class="row justify-content-center">
                    <img src="{{$this->asset('img/anonimo.png')}}" class="img-rounded img-fluid"  id="img" alt="" width="130px" height="130px">
                   </div>
                  <div class="row justify-content-center mt-2">
                    <button class="btn btn-primary btn-sm seleccionar"><b>Seleccione <i class="fas fa-upload"></i></b></button>
                   <input type="file" name="foto" id="foto" class="d-none">
                  </div>
                 
                  <div class="mt-2">
                    <u>Seleccione un rol</u>
                  </div>
                  <div class="row mt-2 roles">
                     
                  </div>
                </div>

                <div class="card-footer">
                    <div class="row justify-content-center">
                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12 m-1">
                            <button class="btn btn-success form-control" name="save"><i class="fas fa-save"></i> Guardar</button>
                        </div>

                        <div class="col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12 m-1">
                            <button class="btn btn-danger form-control" name="cancel"><i class="fas fa-save"></i> Cancelar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script_js')

<script src="{{URL_BASE}}public/js/Usuario.js"></script>
<script>
    var URL_BASE_ = "{{URL_BASE}}";

    var Username = $('#username');

    var Email = $('#email');

    var Password = $('#pasword');

    $(document).ready(function(){

        /** MOSTRAR LOS ROLES **/

        showRole()

        $('.seleccionar').click(function(evt){
           evt.preventDefault();
           
           $('input[name=foto]').click()
        });

        $('#foto').change(function(){

            LeerImagen(this, 'img')
        });

        /*validar los inputs*/
       Username.keypress(function(evento){
         
          if(evento.which == 13)
          {
            evento.preventDefault();
             
             if($(this).val().trim().length === 0)
             {
                $(this).focus();
             }else{

                Email.focus()
             }
          }
       })

       Email.keypress(function(evento){
         
         if(evento.which == 13)
         {
           evento.preventDefault();
            
            if($(this).val().trim().length === 0)
            {
               $(this).focus();
            }else{

               Password.focus()
            }
         }
      })

      Password.keypress(function(evento){
         
         if(evento.which == 13)
         {
           evento.preventDefault();
            
            if($(this).val().trim().length === 0)
            {
               $(this).focus();
            } 
         }
      })
        
    })
</script>
    
@endsection