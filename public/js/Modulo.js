class Modulo {
  constructor(urlbase) {
    this.URLBASE = urlbase;
  }

  /** registrar */

  saveModulo(url_, NameModulo, KeyModulo) {
    let saveresponse = "";
    $.ajax({
      url: this.URLBASE + url_,
      method: "POST",
      data: { save: "", name_modulo: NameModulo, key_modulo: KeyModulo },
      async: false,
      success: function (response) {
        saveresponse = response;
      },
    });

    /// refrescamos el DataTable

    this.TablaModulo_.ajax.reload(null, false);

    return saveresponse;
  }

  UpdateModulo(url_, NameModulo, KeyModulo) {
    let saveresponse = "";
    $.ajax({
      url: this.URLBASE + url_,
      method: "POST",
      data: { update: "", name_modulo: NameModulo, key_modulo: KeyModulo },
      async: false,
      success: function (response) {
        saveresponse = response;
      },
    });

    /// refrescamos el DataTable

    this.TablaModulo_.ajax.reload(null, false);

    return saveresponse;
  }

  /// Modificar 

  /*** Visualizar los datos */

  showModule(Tabla, url_) {
    this.TablaModulo_ = $("#" + Tabla).DataTable({
      ajax: {
        url: this.URLBASE + url_,
        method: "GET",
        dataSrc: "modulos",
      },
      columns: [
        { data: "name_modulo" },
        { data: "key_modulo" },
        {
          defaultContent: `
     <div class='row'>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-warning btn-sm' id='editar'><i class='fas fa-edit'></i></button></div>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-danger btn-sm' id='delete'><i class='fas fa-trash-alt'></i></button></div>
     </div>
     `,
        },
      ],
    });

    this.Editar(this.TablaModulo_,'#'+Tabla+' tbody')

    this.ConfirmModule(this.TablaModulo_,'#'+Tabla+' tbody',this.URLBASE)
  }

  /// editar

  Editar(Tabla,Tbody)
  {
    $(Tbody).on('click','#editar',function(){
     let Fila = $(this).parents('tr') /// fila seleccionada

     if(Fila.hasClass('child'))
     {
      Fila = Fila.prev() /// responsive
     }

     let Dato = Tabla.row(Fila).data()

     /// mostrar el modal

     IdModulo = Dato.id_modulo;

     $('#title_modal').text('Editar módulos')
     $('#update_modulo').show()
     $('#save_modulo').hide()

     NombreModulo.val(Dato.name_modulo)

     KeyModulo.val(Dato.key_modulo)
     $('#modal-modulos').modal('show')
    })
  }

  /// Confirmar eliminar m´doulo

  ConfirmModule(Tabla,Tbody,URL)
  {
    $(Tbody).on('click','#delete',function(){
     let Fila = $(this).parents('tr') /// fila seleccionada

     if(Fila.hasClass('child'))
     {
      Fila = Fila.prev() /// responsive
     }

     let Dato = Tabla.row(Fila).data()

     /// mostrar el modal

     IdModulo = Dato.id_modulo;

     Swal.fire({
      title: 'Deseas eliminar al módulo '+Dato.name_modulo+" ?",
      text: "Al eliminar el módulo no podrá recuperarlo!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
      if (result.isConfirmed) {
         /// ajax para eliminar
        $.ajax({
          url:URL+"module/delete/"+IdModulo,
          method:"POST",
          data:{delete:''},
          success:function(response)
          {
            if(response == 1)
            {
              Swal.fire({
                title:"Mensaje del sistema",
                text:"Módulo eliminado",
                icon:"success"
              })
            }else{
              Swal.fire({
                title:"Mensaje del sistema",
                text:"Error al eliminar módulo",
                icon:"error"
              })
            }
            Tabla.ajax.reload(null,false)
          }
        })
      }
    })
    })
  }
}
