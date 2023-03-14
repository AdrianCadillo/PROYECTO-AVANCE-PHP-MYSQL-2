<?php

use config\DataBase;
use lib\BaseController;
use models\Role;
use Repository\report\CrudRepository;

class RoleController extends BaseController
{
  /** Propiedades */

  private CrudRepository $ModelRole;

  /** constructor */

  public function __construct()
  {
    $this->ModelRole = new Role;
  }

  public function index()
  {
    $roles = $this->ModelRole->all();  

    $this->view("role.IndexViewRol",compact("roles"));
  }

  public function create()
  {
    $datos = [
      "name_rol"=>"Contador"
    ];

    echo $this->ModelRole->create($datos); 
  }

  public function edit( )
  {
    
   
  }

}