@extends($this->getComponents('layout.app'))

@section('titulo_', 'sistema-usuarios')

@section('contenido')
<div class="col">
    <div class="card">
        <div class="card-header">
            <h4>Configurar sistema</h4>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" id="tab_">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#copia"><b>Copia de seguridad</b></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#restore"><b>Restaurar sistema</b></a>
                </li>

            </ul>

            <div class="tab-content">
                <div class="tab-pane active" id="copia" role="tabpanel" aria-labelledby="home-tab">
                     
                     @if ($this->autorizado("Config.copia"))
                     <form action="{{URL_BASE}}database/copia" method="post">
                        <div class="form-group">
                            <label for="name_copia" class="form-label">Nombre de la copia (*)</label>
                            <input type="text" name="name_copia" id="name_copia" class="form-control"
                            placeholder="Escriba el nombre de la copia...">
                        </div>

                        <div class="text-center mt-2">
                            <button class="btn btn-success"><b> Crear copia  <i class="fas fa-database"></i></b> </button>
                        </div>
                    </form>
                     @else 
                     <div class="alert alert-danger"><b>Uste no esta autorizado para realizar copias de seguridad</b></div>
                     @endif

                    <div class="col mt-2">
                       @if ($this->existSession("mensaje"))
                       <div class="alert alert-danger">
                              <b>{{$this->getSession("mensaje")}}</b>
                       </div>
                       {{$this->deleteSession("mensaje")}}
                       @endif

                       @if ($this->existSession("mensaje_"))
                         
                       @if ($this->getSession("mensaje_") == 1)
                       <div class="alert alert-success">
                        <b>La restauración del sistema se ha realizado correctamente</b>
                       </div>
                       @else 

                        @if ($this->getSession("mensaje_") == 0)
                        <div class="alert alert-danger">
                            <b>Error al restaurar sistema</b>
                          </div>
                          @else 
                          <div class="alert alert-warning">
                            <b>El archivo seleccionado es incorrecto</b>
                           </div>
                        @endif
                       @endif
                       {{$this->deleteSession("mensaje_")}}
                       @endif
                    </div>
                </div>
                <div class="tab-pane" id="restore" role="tabpanel" aria-labelledby="profile-tab">
                    @if ($this->autorizado("Config.restaurar"))
                    <form action="{{URL_BASE}}database/restoreBD" method="post" enctype="multipart/form-data">
                        <div class="input-group mt-2">
                            <label class="input-group-text" for="file_copia">Upload</label>
                            <input type="file" class="form-control" id="file_copia" name="file_copia">
                        </div>
    
                           <div class="text-center mt-2">
                             <button class="btn btn-primary">Restaurar sistema <i class="fas fa-database"></i></button>
                           </div>
                    </form>
                    @else 
                    <div class="alert alert-danger"><b>Uste no esta autorizado para rstaurar el sistema</b></div>
                    @endif
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('script_js')
    <script>
        $(document).ready(function(){
             $('#tab_ a').on('click',function(evt){

                   evt.preventDefault();
                   
                   $(this).tab("show")
             });
        });
    </script>
@endsection