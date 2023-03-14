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
      return $_POST['input'];
   }
 }

}