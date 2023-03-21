<?php
namespace lib;

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

 public function load($input)
 {
   return $_POST[$input] ?? '';
 }

 public function post($input)
 {
   if(isset($_POST[$input]))
   {
      return $_POST[$input];
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
 



}