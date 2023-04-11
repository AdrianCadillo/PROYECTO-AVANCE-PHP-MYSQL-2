<?php
namespace lib;

use models\Role;
use models\Usuario;

class BaseController extends View
{
 

 /** Método asset */

 public function asset(string $directorio)
 {
  
    return  URL_BASE."public/lib/".$directorio;
  
 }

 /**
 * Mtodo para dirigir a los componentes
 */

 public function getComponents(string $file)
 {
  return str_replace(".","/",RAIZVIEW.$file).".blade.php";
 }
 

 public function post($input)
 {
   if(isset($_POST[$input]))
   {
      return $_POST[$input];
   }
 }

 public function get($input)
 {
   if(isset($_GET[$input]))
   {
      return $_GET[$input];
   }
 }

 private function file($Name)
 {
  if(isset($_FILES[$Name]))
   {
      return $_FILES[$Name];
   }
 }

 public function getSizefile($Name)
 {
 
   return $this->file($Name)['size'];
 
 }

 public function getNamefile($Name)
 {
 
      return $this->file($Name)['name'];
  
 }

 public function getTypefile($Name)
 {
      return $this->file($Name)['type'];
 }

 public function getArchivo($Name)
 {
      return $this->file($Name)['tmp_name'];
 }

 public function load(string $NameSession)
 {
  if(isset($_SESSION[$NameSession]))
  {
    echo $_SESSION[$NameSession];
    
    unset($_SESSION[$NameSession]);
  }
 }

 /** Mostrar los roles del usuario */
 
 public function roles($idUser)
 {
  return Usuario::roles($idUser);
 }

 /// obtener la data del excel

 public function getDataExcel(string $Name):array{

  $File_excel = file($this->getArchivo($Name));

  $Data_Excel = [];$item = 0;

  foreach($File_excel as $data)
  {
    if($item>0)
    {
      $data = explode(";",$data);

      array_push($Data_Excel,$data);
    }

    $item++;
  }

  return $Data_Excel;
 }

 public function encode_(string $valor)
 {
  return mb_convert_encoding($valor,'UTF-8', 'ISO-8859-1');
 }
 
 public function getTypeMethod()
 {
  return  $_SERVER['REQUEST_METHOD'];
 }

 public function old(string $NameSession)
 {
  $Valor = "";

  if($this->existSession($NameSession)):
    $Valor = $this->getSession($NameSession);

    /// ELIMINAR LA VARIABLE DE SESSION

    $this->deleteSession($NameSession);
  endif;

  return $Valor;
 }


 /// autorizar permisos del sistema al usuario

 public function autorizado($permiso):bool{

  return Role::Autorize([$this->getSession("id_perfil"),$permiso]);
 } 

 /// obtener foto

 public function getFoto():string
 {
  $Foto = "dist/img/user4-128x128.jpg";

  if($this->existSession("foto"))
  {
    if($this->getSession("foto") !== null)
    {
      $Foto ="fotos/".$this->getSession("foto");
    }
  }

  return $Foto;
 }

 

}