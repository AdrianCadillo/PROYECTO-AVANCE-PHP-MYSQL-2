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
                <div class="modal-header">
                    <h4>Cambiar contraseña</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">X</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="validationServer01" class="form-label">Password actual</label>
                        <input type="text" class="form-control is-valid" id="validationServer01" value="Mark" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="validationServer02" class="form-label">Nuevo Password</label>
                        <input type="text" class="form-control is-valid" id="validationServer02" value="Otto" required>
                        <div class="valid-feedback">
                          Looks good!
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="validationServer03" class="form-label">Confirmar Password</label>
                        <input type="text" class="form-control is-invalid" id="validationServer03" aria-describedby="validationServer03Feedback" required>
                        <div id="validationServer03Feedback" class="invalid-feedback">
                          Please provide a valid city.
                        </div>
                      </div>
                </div>

                <div class="modal-footer justify-content-center">
                    <button class="btn btn-success"> <b>Guardar cambios <i class="fas fa-save"></i></b></button>
                </div>
            </div>
        </div>
     </div>
@endsection

@section('script_js')
    <script>
        $(document).ready(function(){
            $('#cambio_pasword').click(function(evt){
                evt.preventDefault();
                
                $('#modal-pasword').modal("show");
            })
        })
    </script>
@endsection

 