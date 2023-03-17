
class Modulo 
{

  constructor(urlbase)
  {
   this.URLBASE = urlbase
   
  }
  
 /** registrar */
 
 saveModulo(url_,NameModulo,KeyModulo)
 {
  let saveresponse = "";  
  $.ajax({
    url:this.URLBASE+url_,
    method:"POST",
    data:{save:'',name_modulo:NameModulo,key_modulo:KeyModulo},
    async:false,
    success:function(response)
    {
        saveresponse = response;
    }
    
  })

  /// refrescamos el DataTable
  
  this.TablaModulo_.ajax.reload(null,false)

  return saveresponse;
 }

 /*** Visualizar los datos */

 showModule(Tabla,url_)
 {
     this.TablaModulo_ = $('#'+Tabla).DataTable({

    "ajax":{
     
        url:this.URLBASE+url_,
        method:"GET",
        dataSrc:"modulos"
    },
    "columns":[
     {"data":"name_modulo"},
     {"data":"key_modulo"},
     {"defaultContent":`
     <div class='row'>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-warning btn-rounded btn-fw' id='editar'><i class='fas fa-pencil'></i></button></div>
     <div class='col-xl-3 col-lg-3 col-md-4 col-sm-4 col-12'><button class='btn btn-danger btn-rounded btn-fw' id='delete'><i class='fas fa-trash-alt'></i></button></div>
     </div>
     `}
    ]
  })
 }
}