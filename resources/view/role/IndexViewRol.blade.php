@extends($this->getComponents('layout.app'))

@section('titulo_', 'sistema-módulos')

@section('contenido')
<div class="col">
    <div class="card">
        <div class="card-header">
            <h4 class="float-left">Crear roles</h4>
            <span class="float-right">

               @if($this->autorizado("Rol.create"))
               <button class="btn btn-primary btn-sm" onclick="createRole()"><b>Nuevo <i class="fas fa-plus"></i></b></button>
               @endif
            </span>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="tabla-roles" class="table table-bordered table-hover dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Permisos</th>
                                <th>Gestionar</th>
                            </tr>
                        </thead>
                    </table>
            </div>
        </div>
    </div>
</div>


 {{--- Modal para crear roles y asignarle permisos---}}

 <div class="modal fade" id="modal-role" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Crear role</h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="rolename" class="col-sm-2 col-form-label"><b>Nombre rol (*)</b></label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="rolename">
                    </div>
                </div>

                <div class="row permisos">
                     
                </div>
            </div>

            <div class="modal-footer form-inline">
            <button class="btn btn-primary btn-sm form-control" onclick="openPermission()"><i class="fas fa-plus"></i> permiso</button>

            <button class="btn btn-success btn-sm form-control" id="save_role"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>
</div>

{{--- Modal para editar roles y asignarle permisos---}}

<div class="modal fade" id="modal-role-editar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
    <div class="modal-content">
        <div class="modal-header">
            <h4>Editar roles</h4>
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">X</span>
            </button>
        </div>

        <div class="modal-body">
            <div class="mb-3 row">
                <label for="rolename_editar" class="col-sm-2 col-form-label"><b>Nombre rol (*)</b></label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="rolename_editar">
                </div>
            </div>

            <div class="row permisos_editar">
                 
            </div>
        </div>

        <div class="modal-footer form-inline">

        <button class="btn btn-success btn-sm form-control" id="update_role"><i class="fas fa-save"></i> Guardar cambios</button>
        </div>
    </div>
</div>
</div>

 {{---- modal para crear nuevos permisos---}}

 <div class="modal fade" id="modal-permiso-create" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
 aria-labelledby="staticBackdropLabel" aria-hidden="true">
     <div class="modal-dialog modal-md modal-dialog-scrollable">
       <div class="modal-content">
           <div class="modal-header">
               <h4>Crear permiso</h4>
               <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                 <span aria-hidden="true">X</span>
             </button>
           </div>
   
           <div class="modal-body">
               <div class="row">
                   <div class="col-12">
                       <div class="form-group">
                           <label for="name_permiso">Nombre permiso (*)</label>
                           <input type="text" id="name_permiso" class="form-control"
                           placeholder="Nombre del permiso - ejm (Rol.index - Rol.create)">
                       </div>
                   </div>
   
                   <div class="col-12">
                       <div class="form-group">
                           <label for="descripcion">Descripción (*)</label>
                            <textarea  id="descripcion" cols="30" rows="10" class="form-control"
                            placeholder="Descripción"></textarea>
                       </div>
                   </div>
 
                   <div class="col-12">
                     <div class="form-group">
                         <label for="modulo">Seleccione Módulo (*)</label>
                          <select name="modulo" id="modulo" class="form-control">
                           
                          </select>
                     </div>
                 </div>
               </div>
           </div>
 
           <div class="modal-footer">
             <button class="btn btn-success" id="save_permiso">Guardar <b><i class="fas fa-save"></i></b></button>
           </div>
       </div>
     </div>
   </div>
@endsection

@section('script_js')

<script src="{{URL_BASE}}public/js/control.js"></script>
<script src="{{URL_BASE}}public/js/roles.js"></script>
    <script>

        var URL_BASE_ = "{{URL_BASE}}"

        var NamePermio = $('#name_permiso');

        var Descripcion = $('#descripcion');

        var Modulo = $('#modulo');

        var NombreRol = $('#rolename')

        var NameRol_editar = $('#rolename_editar')

        var Editar = "{{$this->autorizado('Rol.editar')}}";

        var Eliminar = "{{$this->autorizado('Rol.delete')}}";
        

        var PERFIL = "{{$this->existSession('rol_perfil')?$this->getSession('rol_perfil'):''}}";

        var IdRol ;
        $(document).ready(function(){

            focusInputModal('modal-permiso-create','name_permiso');

            focusInputModal('modal-role','rolename');
             
            //// mostrar todos los roles en el Datatable
            showDataTable()

            /// visualizar los permisos

            showPermisos()

           // 

            ///mostrar los modulos

            modules() 

            $('#save_permiso').click(function () {
                savePermission(NamePermio,Descripcion,Modulo)
            })
 
            $('#save_role').click(function(){
                save_Role(NombreRol)
            })

            $('#update_role').click(function(){
                update_Role(NameRol_editar,IdRol)
            })

             
        })
    </script>
@endsection