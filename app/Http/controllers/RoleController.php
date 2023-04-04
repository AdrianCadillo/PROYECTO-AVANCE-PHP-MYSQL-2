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
    
  }

  public function store()
  {
    if($this->getTypeMethod() === 'POST')
    {
      $datos = [
        "name_rol"=>$this->post("name_rol")
      ];
  
      echo $this->ModelRole->create($datos);
    } 
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

  /// asignamos permisos

  public function asignPermisos()

  {
    if($this->getTypeMethod() === 'POST')
    {
      $Role = $this->ModelRole->Search_("rol","name_rol",$this->post("rol"));

      if(count($Role)>0)
      {
        $Id_Rol = $Role[0]->id_rol;

        $datos = [
          "id_permiso"=>$this->post("permiso"),
          "id_rol"=>$Id_Rol
        ];
    
        Role::AssigPermiso($datos);
      }
    } 
  }

  /// quitar permisos a los roles

  public function deletePermisos($data=null)
  {
    if($this->getTypeMethod() === 'POST')
    {
     echo Role::deletePermissions($data[0]);
    }
  }
   

   

}