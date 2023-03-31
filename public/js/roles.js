
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
        }else{
            data = '<span class="badge badge-danger"><b>Sin permisos asignados</b></span>';
        }

        return data;
     }},
     {"data":"name_rol"}
     ],
     language:SpanishDataTable()
    }) 
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

