
/*** Permite realizar un preview a la imagen , 
 además valida el tipo de imagen
 */
function LeerImagen(Input, IdIamgen) {

    /// validamos que sea una imagen
    var filePath = $(Input).val(); /// obtenemos la direccion del archivo
    var Extensiones = /(.png|jpg)$/; /// especificamos las extensiones que solo se aceptará
    if (!Extensiones.exec(
        filePath)) { /// verificamos que la extension sea la correcta al seleccionar
        Swal.fire({
            title:'Mensaje del sistema',
            text:'Error, el archivo no es una imágen | posiblemente seleccionó una extensión no aceptable',
            icon:'error'
        })
        filePath = "";
        $(this).val("");
        return false;
    }else{

    if (Input.files && Input.files[0]) {// verificamos si tenemos una imagen seleccionado
        var Lectura = new FileReader();/// leemos la imágen seleccionado
        Lectura.onload = function(e) {
            $('#' + IdIamgen).attr('src', e.target.result);/// le asignamos la imagen a img
        }
        Lectura.readAsDataURL(Input.files[0]);
   }
}
} 

/** MOSTRAR LOS ROLES EXISTENTES */
function showRole()
{
    let HTML = "";
    $.ajax({
        url:URL_BASE_+"usuario/showRoles",
        method:"GET",
        success:function(response)
        {
           response = JSON.parse(response);

           response.roles.forEach(role=> {
             
            HTML+=`
             <div class='col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12'>
             <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                          <input type="checkbox" name='role[]' value="`+role.id_rol+`" class="custom-control-input" id="`+role.id_rol+`">
                          <label class="custom-control-label" for="`+role.id_rol+`">`+role.name_rol+`</label>
             </div>
             </div>
            `;
           });

           $('.roles').html(HTML)
        }
    })
}