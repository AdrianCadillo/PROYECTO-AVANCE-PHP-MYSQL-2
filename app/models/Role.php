<?php
namespace models;

use Repository\report\CrudRepository;

class Role extends CrudRepository
{
 /******* Propiedades del modelo */

 private string $Table = "rol";

 private array $Fillable = [
 "id_rol",
 "name_rol"    
 ];
  /* Método para Insertar */
  
  public  function create(array $datos){

    if(count(self::Search_($this->Table,$this->Fillable[1],$datos["name_rol"])) > 0)
    {
      return "existe";
    }
    else{
      return self::Insert($this->Table,$datos);
    }
  }

  /** Método para modificar */

  public function modify(array $datos){

    return self::Update($this->Table,$datos);
  }

  /** Método para eliminar */

  public  function delete($id){
   
    return self::destroy($this->Table,$this->Fillable[0],$id);
  }

  /** Método para mostrar datos */

  public  function all(){

    return self::get($this->Table);
  }

  public static function AssigPermiso(array $datos)
  {
    self::Insert("rol_has_permission",$datos);
  }

  /// quitar los permisos

  public static function deletePermissions($id_rol)
  {
    /// eliminar de la tabla rol_haspermisos

    self::destroy("rol_has_permission","id_rol",$id_rol);

    /// eliminar de la tabla usuario_has_role


   self::destroy("usuario_has_role","id_rol",$id_rol);

   /// recien eliminamos la tabla de roles

   return self::destroy("rol","id_rol",$id_rol);

  }

}