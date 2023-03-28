<?php

use lib\BaseController;
use models\Modulo;
use Repository\report\CrudRepository;

class ModuleController extends BaseController
{
 
/********* PROPIEDADES */

private CrudRepository $ModelModulo;

public function __construct()
{
    $this->ModelModulo = new Modulo;
}

/*===============================
VISTA INDEX
================================= */

public function index()
{

    $this->view("module.IndexView");
}
/*===============================
Registro de módulos
================================= */

public function store()
{
 
  if(isset($_POST['save']))
  {
    $datos = [
        "name_modulo"=>$this->post("name_modulo"),
        "key_modulo" =>$this->post("key_modulo")
      ];
      
      echo $this->ModelModulo->create($datos);/// existe | 0 | 1
  }
}
/*===============================
Visualizar los módulos
================================= */

public function show()
{

    echo json_encode(['modulos'=>$this->ModelModulo->all()]);
}

/*===============================
MODIFICAR MODULO
================================= */

public function update($datos=null)
  {
    if (isset($_POST['update'])) {
      if ($datos != null) {
        echo $this->ModelModulo->modify([
          "id_modulo" => $datos[0],
          "name_modulo" => $this->post("name_modulo"),
          "key_modulo" => $this->post("key_modulo")
        ]);
      }
    }
}

/*===============================
ELIMINAR MODULO
================================= */

public function delete($data = null){

  if(isset($_POST['delete']))
  {
    if($data!=null)
    {
      echo $this->ModelModulo->delete($data[0]);
    }
  }
}
/*===============================
Importar datos desde excel
================================= */

public function import()
{

  if($this->getSizefile("excel_modulo")):
     if($this->getTypefile("excel_modulo") === 'text/csv'):
      $Data = $this->getDataExcel("excel_modulo");

      foreach($Data as $data)
      {
       $valor = $this->ModelModulo->create([
         "name_modulo"=>$this->encode_($data[0]),
         "key_modulo"=>$this->encode_($data[1])
       ]);
      }
 
      echo $valor;

    else:
      echo "error";
     endif;
  endif;
}

/** método para exportar datos a un txt */

public function exporttxt()
{
  /// creamos el nombre el archivo txt

  $Name_txt = "Reporte_Modulos";

  $Name_txt.= date("YmdHis").rand().".txt";

  /// abrir el archivo creado el archivo txt

  $File_Txt = fopen($Name_txt,"w");

  /// escribimos en el archivo

  $Modulos = $this->ModelModulo->all();

  $Indice =0;

  foreach($Modulos as $module)
  {
    fwrite($File_Txt,"**************** Reporte ( $Indice ) **************\n\n");

    fwrite($File_Txt,"NOMBRE MÓDULO : ".$module->name_modulo."\n");

    fwrite($File_Txt,"KEY MÓDULO : ".$module->key_modulo."\n\n");


    fwrite($File_Txt,"**************** Fín Reporte ( $Indice ) **************\n\n");

    $Indice++;
  }

  /// cerramos el proceso

  fclose($File_Txt);

    /// leemos el archivo txt generado
    readfile($Name_txt);
    /************************ DESCARGA AUTOMÁTICA DEL ARCHIVO TXT ************************ */
    header( "Content-Type: application/octet-stream");
    header( "Content-Disposition: attachment; filename=".$Name_txt.""); //archivo de salida 
    /************************* FIN PROCESO DE DESCARGA ARCHIVO TXT *********************** */
    unlink($Name_txt);


}





} 