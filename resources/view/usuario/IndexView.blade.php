@extends($this->getComponents('layout.app'))

@section('titulo_', 'sistema-usuarios')

@section('contenido')
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h4 class="float-left">Usuarios existentes</h4>

                <span class="float-right">
                    <button class="btn btn-primary btn-sm"
                        onclick="location.href='{{ URL_BASE }}usuario/create'"><b>nuevo usuario <i
                                class="fas fa-plus"></i></b></button>
                </span>
            </div>

            <div class="card-body">
                @if ($this->existSession('mensaje'))
                    @if ($this->getSession('mensaje') === 'success')
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-success" role="alert">
                                    Usuario registrado correctamente
                                </div>
                            </div>
                        </div>
                    @else
                        @if ($this->getSession('mensaje') === 'existe')
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-warning" role="alert">
                                        Error al registrar usuario, ya que no se permite la duplicidad
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-danger" role="alert">
                                        Error al registrar usuario
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                    {{ $this->deleteSession('mensaje') }}
                @endif

                {{----modificar -----}}
                @if ($this->existSession('mensaje_update'))
                @if ($this->getSession('mensaje_update') === 'success')
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-success" role="alert">
                                Usuario modificado correctamente
                            </div>
                        </div>
                    </div>
              
                    @else
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-danger" role="alert">
                                    Error al modificar usuario
                                </div>
                            </div>
                        </div>
                    @endif
                {{ $this->deleteSession('mensaje_update') }}
            @endif
                <table id="tabla-usuarios" class="table table-bordered table-hover dt-responsive nowrap" style="width:100%">

                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Foto</th>
                            <th>Gestionar</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (isset($Usuarios))
                            @if (count($Usuarios) > 0)
                                @foreach ($Usuarios as $user)
                                    <tr>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @if (count($this->roles($user->id_usuario)) > 0)
                                                @foreach ($this->roles($user->id_usuario) as $role)
                                                    <span class="badge badge-primary">
                                                        <b>{{ $role->name_rol }}</b>
                                                    </span>
                                                @endforeach
                                            @else
                                                <span class="badge badge-danger">
                                                    <b>No hay roles asignados ):</b>
                                                </span>
                                            @endif
                                        </td>
                                        <td>

                                            {{-- - validamos la foto del usuario -- --}}

                                            @if ($user->foto === null)
                                                @php $Foto = $this->asset('img/anonimo.png'); @endphp
                                            @else
                                                @php $Foto = $this->asset('fotos/'.$user->foto); @endphp
                                            @endif

                                            <img src="{{ $Foto }}" class="img-fluid rounded" alt=""
                                                width="50px" height="50px">
                                        </td>

                                        <td>
                                            <div class="row">
                                                @if($this->autorizado("Usuario.editar"))
                                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 m-1">
                                                    <a href="{{URL_BASE}}usuario/editar/{{$user->id_usuario}}" class="btn btn-outline-warning btn-sm">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                                @endif
                                               
                                                @if ($this->autorizado("Usuario.delete"))
                                                <div class="col-xl-5 col-lg-5 col-md-6 col-sm-6 col-12 m-1">
                                                    <button class="btn btn-outline-danger btn-sm" onclick="ConfirmDelete(`{{$user->id_usuario}}`,`{{$user->username}}`)">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach


                            @endif
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script_js')
    <script>
        var URL_ = "{{URL_BASE}}";
        $(document).ready(function() {

            var TablaUsuario = $('#tabla-usuarios').DataTable({})
        })

        /*método para confirmar antes de eliminar*/

     var ConfirmDelete = function(id,usuario)
        {
        Swal.fire({
        title: 'Desea eliminar al usuario : '+usuario,
        text: "Al dar aceptar, se eliminará al usuario y sus roles asignados!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
        if (result.isConfirmed) {
          deleteUser(id)
        }
        })
        }

        /*eliminar al usuario por petición ajax ****/

        function deleteUser(id_user)
        {
             
            $.ajax({
                url:URL_+"usuario/delete/"+id_user,
                method:"POST",
                data:{delete:''},
                success:function(response){

                    if(response == 1)
                    {
                    Swal.fire({
                        title:"Mensaje del sistema",
                        text:"Usuario eliminado correctamente",
                        icon:"success"
                    }).then(function(){
                      location.href= URL_+"usuario";
                    });
                    }else
                    {
                     Swal.fire({
                        title:"Mensaje del sistema",
                        text:"Error al eliminar usuario",
                        icon:"error"
                    })
                    }
                }
            })
        }
    </script>
@endsection
