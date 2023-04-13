<?php
namespace models;

use Repository\report\CrudRepository;

class Usuario extends CrudRepository
{

  private string $Table = "usuario" ;

  private static string $TableRelational = "usuario_has_role";

  private static string $Vista = "view_roles_del_usuario";
  
  private  array $Fillable = [
   "username","email","pasword","id_usuario"
  ];

  /* Método para Insertar */
  
  public function create(array $datos){

    if(count(self::Search_($this->Table,$this->Fillable[0],$datos['username']))>0):
       return "existe";

    else:

      return self::Insert($this->Table,$datos);

    endif;
    
  }

  /** Método para modificar */

  public function modify(array $datos)
  {

    if (count(self::Search_($this->Table, $this->Fillable[0], $datos['username'])) > 0) :

     if(!empty(array_keys($datos)[3]))
     {
      return self::Update($this->Table,["id_usuario"=>$datos["id_usuario"],"email"=>$datos["email"],"foto"=>$datos["foto"]]);
     }
     else{
      return self::Update($this->Table,["id_usuario"=>$datos["id_usuario"],"email"=>$datos["email"]]);
     }

    else :

      return self::Update($this->Table, $datos);

    endif;
  }

  /** Método para eliminar */

  public function delete($id){

    return self::destroy($this->Table,$this->Fillable[3],$id);
  }

  /** Método para mostrar datos */

  public function all(){

    return self::get($this->Table);
  }

  /** buscar un usuario */

  public static function search(string $username){

    return self::Search_("usuario","username",$username);
  }

  /*** asignar los roles al usuario */

  public static function assignRole(array $datos)
  {
    return self::Insert(self::$TableRelational,$datos);
  }

  /*** mostrar los roles del usuario */

  public static function roles($id_user)
  {
    return self::Search_(self::$Vista,"id_usuario",$id_user);
  } 

  /** mostrar usuario por id */

  public static function getBydId($Id_User)
  {
   return self::Search_("usuario","id_usuario",$Id_User);
  }

  /** Mostrar los roles no asignados a un usuario */

  public static function rolesNoAsigned($iduser)
  {
    return self::procedure("proc_roles_not_user",[$iduser],"c");
  }


  /** Quitar los roles del usuario */

  public static function deleteRoles($iduser)
  {
   self::destroy("usuario_has_role","id_usuario",$iduser);
  }

  /** acceder al sistema */

  public static function SignIn(array $datos)
  {
    return self::procedure("proc_login",$datos,"C");
  }

  /** Cambiar contraseña */

  public static function updateUserPassword(array $datos)
  {
    return self::Update("usuario",$datos);
  }
}