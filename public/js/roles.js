
/** Método para mostrar el DataTable */

function showDataTable(){

    var TablaRoles = $('#tabla-roles').DataTable({
     retrieve: true,
     "ajax":{
        url:URL_BASE_+"role/show_roles",
        method:"GET",
        dataSrc:"roles"
     },
     "columns":[
     {"data":"name_rol"},
     {"data":"permissions",render:function(dta){
        
        let data = '';

        if(dta.length>0)
        {
         dta.forEach(permiso => {
            data+= '<span class="badge badge-success"><b>'+permiso+'</b></span> ';
         });
        }
        else
        {
            data = '<span class="badge badge-danger"><b>Sin permisos asignados</b></span>';
        }

        return data;
     }},
     {"defaultContent":
    
     `
     <div class='row'>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-warning btn-sm' id='editar'><i class='fas fa-edit'></i></button></div>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-danger btn-sm' id='delete'><i class='fas fa-trash-alt'></i></button></div>
     </div>
     `  
     }
     ],
     language:SpanishDataTable()
    }).ajax.reload() 

    ConfirmDeletePermiso(TablaRoles,"#tabla-roles tbody")
}


/// modal para crear roles y asignar permisos 

function createRole()
{
    openModal("modal-role")
}

/// modal para crear roles y asignar permisos 

function openPermission()
{
    openModal("modal-permiso-create")
}

/// visualzia los permisos existentes

function showPermisos()
{
  let HTML = "";

  let permissions = showData(URL_BASE_+"permission/show");
  
  if(permissions.permisos.length > 0)
  {
    permissions.permisos.forEach(permiso => {
        HTML+=
        `
        <div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12'>
             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                <input type="checkbox" name='role[]' value="`+permiso.id_permiso+`" class="custom-control-input" id="`+permiso.id_permiso+`">
                <label class="custom-control-label" for="`+permiso.id_permiso+`">`+permiso.descripcion+`</label>
               </div>
        </div>
        `
    });

    $('.permisos').html(HTML)
  }
}


function modules() 
{
    let HTML = "<option selected disabled value='Seleccione'>Selecccione</option>";

    let modules = showData(URL_BASE_+"module/show");
    
    if(modules.modulos.length > 0)
    {
      modules.modulos.forEach(module => {
          HTML+=
          `
          <option value=`+module.id_modulo+`>`+module.name_modulo+`</option>
          `
      });
  
      $('#modulo').html(HTML)
    }
}

function savePermission(namePermiso,Descripcion,IdModulo)
{
    let Datos = {name_permiso:namePermiso.val(),descripcion:Descripcion.val(),modulo:IdModulo.val()};

    let respuesta = crud(URL_BASE_+"permission/store",Datos);

   if(respuesta == 1)
   {
    Swal.fire({
        title:"Mensaje del sistema",
        text:"Permiso registrado",
        icon:"success"
    }).then(function(){
        showPermisos()

        closeModal('modal-permiso-create')

        namePermiso.val("")

        Descripcion.val("")

        IdModulo.val("Seleccione")
    })
   }
   else{
    if(respuesta === 'existe')
    {
        Swal.fire({
            title:"Mensaje del sistema",
            text:"Error, no se acepta duplicidad",
            icon:"warning"
        })
    }else{
        Swal.fire({
            title:"Mensaje del sistema",
            text:"Error al intentar registro a la tabla permissions",
            icon:"error"
        })
    }
   }
    
}


/// metodo que valida si por lo menos hay un seleccionado en permisos

function ContarSeleccionados()
{
    let contador = 0;
    $('.permisos input[type=checkbox]').each(function()
    {
      if($(this).is(":checked"))
      {
        contador++;
      }
    })

    return contador;
}

/// metodo para crear nuevos roles a base d edatos

function save_Role(NameRol)
{
  if(ContarSeleccionados() > 0)
  {

    /// creamos al rol y le asignamos el permiso

      /// aqui solo guarmos el rol

      let response = crud(URL_BASE_+"role/store",{name_rol:NameRol.val()});
    

      if(response == 1)
      {
          Swal.fire({
              title:"Mensaje del sistema",
              text:"rol registrado",
              icon:"success"
          }).then(function(){

              asignPermisos(NameRol.val())
              closeModal('modal-role');
              NameRol.val("")
     
              $('.permisos input[type=checkbox]').prop("checked",false)
              /// asignamos permisos

              showDataTable()
          })
      }
      else{
  
          if(response === 'existe')
          {
              Swal.fire({
                  title:"Mensaje del sistema",
                  text:"Error, no se permite duplicidad de datos",
                  icon:"warning"
              })
          }
          else{
              Swal.fire({
                  title:"Mensaje del sistema",
                  text:"Error al registrar roles",
                  icon:"error"
              })
          }
      }

  }else{
    /// aqui solo guarmos el rol

    let response = crud(URL_BASE_+"role/store",{name_rol:NameRol.val()});
    

    if(response == 1)
    {
        Swal.fire({
            title:"Mensaje del sistema",
            text:"rol registrado",
            icon:"success"
        }).then(function(){
            NameRol.val("")
            closeModal('modal-permiso-create');

        })
    }
    else{

        if(response === 'existe')
        {
            Swal.fire({
                title:"Mensaje del sistema",
                text:"Error, no se permite duplicidad de datos",
                icon:"warning"
            })
        }
        else{
            Swal.fire({
                title:"Mensaje del sistema",
                text:"Error al registrar roles",
                icon:"error"
            })
        }
    }
  }
}

////metodo para asignar permisos

function asignPermisos(rolName)
{
    $('.permisos input[type=checkbox]').each(function()
    {
      
      let Permiso_ = $(this).val()

      if($(this).is(":checked"))
      {
       crud(URL_BASE_+"role/asignPermisos",{rol:rolName,permiso:Permiso_})
      }
    })
}

/// confirma antes de eliminar los permisos del rol

function ConfirmDeletePermiso(Tabla,Tbody)
{
  $(Tbody).on('click','#delete',function(){
   
    let fila_Seleccionada = $(this).parents("tr")

    if(fila_Seleccionada.hasClass("child"))
    {
        fila_Seleccionada = fila_Seleccionada.prev()
    }

    let Datos = Tabla.row(fila_Seleccionada).data()

    Swal.fire({
        title: 'Deseas eliminar al rol : '+Datos.name_rol+' ?',
        text: "Al eliminar el rol, también se eliminarán los permisos asignados , y además se le quitará el rol al usuario asignado",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
            delete_permisos(Datos.id_rol)
        }
      })
  });   
}

/// eliminar los permisos asignados al rol

function delete_permisos(id)
{
    let respuesta = crud(URL_BASE_+"role/deletePermisos/"+id);

    if(respuesta == 1)
    {
        Swal.fire({
            title:"Mensaje del sistema",
            text:"rol eliminado",
            icon:"success"
        }).then(function(){
 
            showDataTable()
        })
    }else{
        Swal.fire({
            title:"Mensaje del sistema",
            text:"Error al registrar rol",
            icon:"error"
        })   
    }

}

