<?php
namespace lib;

use Http\error\Error;
use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

class View extends Authenticate
{
 /*** PROPIEDADES */ 
 
 private static string $RaizView = "resources.view.";

 /**** Metodo para las vistas */

 public static function view(string $vista,$datos=[])
 {
    $Blade = new Edge(new EdgeFileLoader());
    
    /// reemplazar el . por el /

    self::$RaizView = str_replace(".","/",self::$RaizView.$vista).".blade.php";

    /// verificar la existencia del archivo
    
    if(file_exists(self::$RaizView))
    {
      echo $Blade->render(self::$RaizView,$datos);  
    }
    else
    {
      $ViewError = str_replace(".","/","resources.view."."error.error404").".blade.php";
      echo $Blade->render($ViewError);    
    }

 }
}