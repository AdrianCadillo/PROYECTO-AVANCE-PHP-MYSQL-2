<?php 
namespace models;

use Repository\report\CrudRepository;

class Modulo extends CrudRepository
{
/******** PROPIEDADES******* */

private string $Tabla = "modulo";

private array $Fillable = [
 "id_modulo",
 "name_modulo",
 "key_modulo"

];

 /* Método para Insertar */
  
 public  function create(array $datos){

    if(count(self::Search_($this->Tabla,$this->Fillable[1],$datos['name_modulo']))>0)
    {
     return "existe";
    }else
    {
     return self::Insert($this->Tabla,$datos);
    } 
 }

 /** Método para modificar */

 public  function modify(array $datos){}

 /** Método para eliminar */

 public  function delete($id){}

 /** Método para mostrar datos */

 public  function all(){

   return self::get($this->Tabla);
 }
}