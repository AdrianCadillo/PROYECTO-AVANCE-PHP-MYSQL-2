@extends($this->getComponents('layout.app'))

@section('titulo_', 'sistema-módulos')

@section('contenido')
    <div class="container">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <span class="float-left">
                        <h4>Módulos existentes</h4>
                    </span>

                    <span class="float-right"><button class="btn btn-primary" id="new_modulo"> <b>Nuevo +</b></button></span>

                </div>

                <div class="card-body">
                    <table id="tabla-modulos" class="table table-bordered table-hover dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>

                                <th>Nombre</th>
                                <th>Key Módulo</th>
                                <th>Gestionar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- -- MODAL PARA REGISTRAR  | EDITAR --- --}}

    <div class="modal" tabindex="-1" id="modal-modulos" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><span id="title_modal"></span></h5>
                    <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"
                        aria-label="Close">X</button>
                </div>
                <div class="modal-body">
                    <div class="col">
                        <label for="name_modulo" class="form-label"><b>Nombre Módulo (*)</b></label>
                        <input type="text" name="name_modulo" id="name_modulo" class="form-control"
                            placeholder="Nombre módulo....">

                        <label for="key_modulo" class="form-label"><b>Clave(Key) Módulo (*)</b></label>
                        <input type="text" name="key_modulo" id="key_modulo" class="form-control"
                            placeholder="Key módulo....">
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="button" class="btn btn-success" id="save_modulo">Guardar <i
                            class="fas fa-save"></i></button>

                    <button type="button" class="btn btn-success" id="update_modulo">Guardar cambios <i
                            class="fas fa-save"></i></button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_js')

    <script src="{{ URL_BASE }}public/js/Modulo.js"></script>

    <script>
        var NombreModulo = $('#name_modulo');

        var KeyModulo = $('#key_modulo');


        var Module = new Modulo("{{ URL_BASE }}")

        var IdModulo;

        $(document).ready(function() {

            Module.showModule('tabla-modulos', 'module/show')

            $('#new_modulo').click(function() {

                $('#title_modal').text('Registro de módulos')
                $('#update_modulo').hide()
                $('#save_modulo').show()
                $('#modal-modulos').modal('show')
            })

            $('.close').click(() => {
                $('#modal-modulos').modal('hide')

                NombreModulo.val("")

                KeyModulo.val("")
            })

            $('#save_modulo').click(function() {

                let respuesta = Module.saveModulo("module/store", NombreModulo.val(), KeyModulo.val())

                // verificamos la respuesta

                if (respuesta === 'existe') {
                    Swal.fire({
                        title: "Mensaje del sistema",
                        text: "El módulo que quiere registrar ya existe",
                        icon: "warning"
                    })
                } else {

                    if (respuesta == 1) {
                        Swal.fire({
                            title: "Mensaje del sistema",
                            text: "El módulo se a registrado correctamente",
                            icon: "success"
                        })

                    } else {
                        Swal.fire({
                            title: "Mensaje del sistema",
                            text: "Acaba de ocurrir un error al registrar nuevo módulo",
                            icon: "error"
                        })
                    }
                }
            })

            /// modificar los módulos

            $('#update_modulo').click(function() {
                let respuesta = Module.UpdateModulo("module/update/" + IdModulo, NombreModulo.val(),
                    KeyModulo.val())

                if (respuesta == 1) {
                    Swal.fire({
                        title: "Mensaje del sistema",
                        text: "Módulo modificado correctamente",
                        icon: "success"
                    })
                } else {
                    Swal.fire({
                        title: "Mensaje del sistema",
                        text: "Error al modificar módulo",
                        icon: "error"
                    })
                }
            })
        });
    </script>
@endsection
