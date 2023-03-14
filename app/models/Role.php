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

    return self::Insert($this->Table,$datos);
  }

  /** Método para modificar */

  public function modify(array $datos){}

  /** Método para eliminar */

  public  function delete($id){}

  /** Método para mostrar datos */

  public  function all(){

    return self::get($this->Table);
  }

}