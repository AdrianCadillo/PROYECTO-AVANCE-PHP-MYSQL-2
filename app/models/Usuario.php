<?php
namespace models;

use Repository\report\CrudRepository;

class Usuario extends CrudRepository
{

  private string $Table = "usuario" ;
  
  private array $Fillable = [
   "username","email","pasword"
  ];

  /* Método para Insertar */
  
  public function create(array $datos){

    return self::Insert($this->Table,$datos);
  }

  /** Método para modificar */

  public function modify(array $datos){}

  /** Método para eliminar */

  public function delete($id){}

  /** Método para mostrar datos */

  public function all(){}
}