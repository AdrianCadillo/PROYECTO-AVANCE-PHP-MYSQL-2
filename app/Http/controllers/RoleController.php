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

    session_start();

    $this->NoAuth();

   
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

  /** Método para mostrar los roles y sus permisos*/

  public function show_roles()
  {
    $Roles = '';

    foreach($this->ModelRole->all() as $role)
    {
      $Roles.='{
        "id_rol":"'.$role->id_rol.'",
        "name_rol":"'.$role->name_rol.'",
        "permissions":[';
        
        foreach($this->ModelRole->Search_("rol_has_permission","id_rol",$role->id_rol) as $role_permiso)
        {
          foreach($this->ModelRole->Search_("permission","id_permiso",$role_permiso->id_permiso) as $permiso)
          {
            $Roles.='"'.$permiso->descripcion.'",';
          }
        }
      
      /// eliminamos la uúltima coma
      $Roles = rtrim($Roles,",");
      
      $Roles.=']},';
    }

    /// eliminamos la última coma

    $Roles = rtrim($Roles,",");

    $Roles = '{"roles":['.$Roles.']}';

    echo $Roles;
  }

   

   

}