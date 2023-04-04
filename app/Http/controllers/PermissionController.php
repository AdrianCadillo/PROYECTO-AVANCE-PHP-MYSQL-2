<?php

use lib\BaseController;
use models\Permission;
use Repository\report\CrudRepository;

class PermissionController extends BaseController
{
 
 private CrudRepository $ModeloPermission;
 
 public function __construct()
 {
    session_start();

    $this->NoAuth();

    $this->ModeloPermission = new Permission;
 }


/**** METODO VISUALIZA LOS PERMISOS */

public function show()
{
   if($this->getTypeMethod() === "GET")
   {
    echo json_encode(["permisos"=>$this->ModeloPermission->all()]);
   }
}

/** metodo es para crear nuevos permisos */

public function store()
{
   if($this->getTypeMethod() === 'POST')
   {
      echo $this->ModeloPermission->create([
         "name_permiso"=>$this->post("name_permiso"),
         "descripcion"=>$this->post("descripcion"),
         "id_modulo"=>$this->post("modulo")
      ]);
   }
}
}