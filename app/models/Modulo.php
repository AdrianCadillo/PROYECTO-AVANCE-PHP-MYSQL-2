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

 public  function modify(array $datos){
    if (count(self::Search_($this->Tabla, $this->Fillable[1], $datos['name_modulo'])) > 0) {
      return  self::Update($this->Tabla, ["key_modulo" => $datos['key_modulo']]);
    } else {
      return self::Update($this->Tabla, $datos);
    } 
 }

 /** Método para eliminar */

 public  function delete($id){
  
    if (count(self::Search_("permission", $this->Fillable[0], $id)) > 0) {
      return 0;
    } else {
      return self::destroy($this->Tabla, $this->Fillable[0], $id);
    }
  
 }

 /** Método para mostrar datos */

 public  function all(){

   return self::get($this->Tabla);
 }
}