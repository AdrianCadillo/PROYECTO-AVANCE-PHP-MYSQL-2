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




} 