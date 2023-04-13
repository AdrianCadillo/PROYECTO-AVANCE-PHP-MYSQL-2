@extends($this->getComponents('layout.app'))

@section('titulo_', 'sistema-usuarios')

@section('contenido')
    <div class="col-xl-7 col-lg-7 col-md-9 col-sm-10 col-12">
        <div class="card card-primary card-outline">
           <form action="" method="post">
            <div class="card-body box-profile">
                <div class="text-center">
  
                  
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{$this->asset($this->getFoto())}}"
                       alt="User profile picture" >
                 </div>
  
                 <div class="form-group">
                    <label for="username_" class="form-label">Username</label>
                    <input type="text" name="username_" id="username_" class="form-control"
                    value="{{$this->existSession("username_") ? $this->getSession("username_"):''}}">
                 </div>
  
                 <div class="form-group">
                  <label for="email_" class="form-label">Email</label>
                  <input type="email" name="email_" id="email_" class="form-control"
                  value="{{$this->existSession("email_") ? $this->getSession("email_"):''}}">
                 </div>
                
              </div>

              <div class="card-footer text-center">
                <button class="btn btn-success" name="save_perfil"> <i class="fas fa-save"></i> Guadar cambios</button>

                <button class="btn btn-primary" id="cambio_pasword"> <i class="fas fa-key"></i> Cambiar contraseña</button>
            </div>
              </div>
           </form>
            <!-- /.card-body -->
          </div>
     {{--- MODAL PARA CAMBIAR CONTRASEÑA -----}}

     <div class="modal fade" id="modal-pasword" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header badge badge-info">
                    <h4>Cambiar contraseña</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="validationServer01" class="form-label">Password actual</label>
                        <input type="text" class="form-control is-invalid" id="password_actual" placeholder="Password actual">
                       
                      </div>
                      <div class="form-group">
                        <label for="validationServer02" class="form-label">Nuevo Password</label>
                        <input type="text" class="form-control is-invalid" id="password_nuevo"  placeholder="Nuevo password..." >
                         
                      </div>
                      <div class="form-group">
                        <label for="validationServer03" class="form-label">Confirmar Password</label>
                        <input type="text" class="form-control is-invalid" id="password_confirm" aria-describedby="validationServer03Feedback" 
                        placeholder="Confirmar password...">
                         
                      </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button class="btn btn-success" id="save_pasword"> <b>Guardar cambios <i class="fas fa-save"></i></b></button>
                </div>
            </div>
        </div>
     </div>
@endsection

@section('script_js')

<script src="{{URL_BASE}}public/js/control.js"></script>
    <script>

      var PasswordActual = $('#password_actual');

      var PasswordNuevo = $('#password_nuevo');

      var PasswordConfirm = $('#password_confirm');

      var BotonPassword = $('#save_pasword');


        $(document).ready(function(){

          focusInputModal("modal-pasword","password_actual");

          PasswordNuevo.prop("disabled",true);

          PasswordConfirm.prop("disabled",true)

          BotonPassword.prop("disabled",true)

            $('#cambio_pasword').click(function(evt){
                evt.preventDefault();
                
                $('#modal-pasword').modal("show");
            })

            BotonPassword.click(function(){

              updatePassword(PasswordNuevo.val())
            })
        })



        PasswordActual.keyup(function(){
           
          let response = showData("{{URL_BASE}}usuario/getPasswordActual",{pasword:$(this).val()});

          if(response.resultado)
          {
             $(this).removeClass("is-invalid")

             $(this).addClass("is-valid")

             PasswordNuevo.prop("disabled",false)

             PasswordNuevo.focus()

          }else{
            
            $(this).removeClass("is-valid")

            $(this).addClass("is-invalid")

            BotonPassword.prop("disabled",true);

            PasswordConfirm.prop("disabled",true);

            PasswordNuevo.prop("disabled",true);

            PasswordConfirm.removeClass("is-valid");

            PasswordNuevo.removeClass("is-valid");

            PasswordConfirm.addClass("is-invalid")

            PasswordNuevo.addClass("is-invalid")

            PasswordConfirm.val("");

            PasswordNuevo.val("")
            
          }

        })

        PasswordNuevo.keyup(function(){
          
          if($(this).val().trim().length >=8)
          {
            $(this).removeClass("is-invalid")

            $(this).addClass("is-valid")

            PasswordConfirm.prop("disabled",false)

          }
          else
          {
            $(this).removeClass("is-valid")

            $(this).addClass("is-invalid")

            PasswordConfirm.prop("disabled",true)

          } 
        });

        PasswordNuevo.keypress(function(evento){
           
          if(evento.which == 13)
          {
             if($(this).val().trim().length >= 8)
             {
              PasswordConfirm.focus();
             }

          }

        })

        PasswordConfirm.keyup(function(){

          if($(this).val().trim() === PasswordNuevo.val().trim())
          {
            $(this).removeClass("is-invalid");  $(this).addClass("is-valid");

            BotonPassword.prop("disabled",false);
          }else{
            $(this).removeClass("is-valid");  $(this).addClass("is-invalid");

            BotonPassword.prop("disabled",true);
          }
        })

        /** metodo para actualizar contraseña del usuario logueado al sistema*/ 

        function updatePassword(pasword_)
        {
          let response = crud("{{URL_BASE}}usuario/update_password",{pasword:pasword_});

           if(response == 1)
           {
            Swal.fire({
              title:"Mensaje del sistema",
              text:"Tu password a sido modificado correctamente (:",
              icon:"success"
            }).then(function(){
              reset()

              $('#modal-pasword').modal("hide")
            })
           }else{
            Swal.fire({
              title:"Mensaje del sistema",
              text:"Error al modificar password ):",
              icon:"error"
            })
           } 
        }

        function reset()
        {

            BotonPassword.prop("disabled",true);

            PasswordConfirm.prop("disabled",true);

            PasswordNuevo.prop("disabled",true);

            PasswordConfirm.removeClass("is-valid");

            PasswordNuevo.removeClass("is-valid");

            PasswordConfirm.addClass("is-invalid")

            PasswordNuevo.addClass("is-invalid")

            PasswordActual.removeClass("is-valid")

            PasswordActual.addClass("is-invalid")

            PasswordActual.val("")

            PasswordConfirm.val("");

            PasswordNuevo.val("")
        }
    </script>
@endsection

 