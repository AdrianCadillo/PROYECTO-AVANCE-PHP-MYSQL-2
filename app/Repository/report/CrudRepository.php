<?php 
namespace Repository\report;

use Repository\implementacion\OrmImpl;

abstract class CrudRepository extends OrmImpl
{
  /* Método para Insertar */
  
  public abstract function create(array $datos);

  /** Método para modificar */

  public abstract function modify(array $datos);

  /** Método para eliminar */

  public abstract function delete($id);

  /** Método para mostrar datos */

  public abstract function all();
  
}