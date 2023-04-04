<?php 

namespace models;

use Repository\report\CrudRepository;

class Permission extends CrudRepository {


    private string $table = "permission";

    private array $fillable =["name_permiso","descripcion","id_modulo"];


    /* Método para Insertar */
  
  public  function create(array $datos){

    if(count(self::Search_($this->table,$this->fillable[0],$datos["name_permiso"])) > 0)
    {
     return  "existe";
    }else{

      return self::Insert($this->table,$datos);
    }

  }

  /** Método para modificar */

  public  function modify(array $datos){}

  /** Método para eliminar */

  public  function delete($id){}

  /** Método para mostrar datos */

  public  function all()
  {
    return self::get($this->table);
  }

}