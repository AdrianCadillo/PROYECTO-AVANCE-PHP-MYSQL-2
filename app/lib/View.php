<?php
namespace lib;

use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

class View extends Authenticate
{
 /*** PROPIEDADES */ 
 
 private string $RaizView = "resources.view.";

 /**** Metodo para las vistas */

 public function view(string $vista,$datos=[])
 {
    $Blade = new Edge(new EdgeFileLoader());
    
    /// reemplazar el . por el /

    $this->RaizView = str_replace(".","/",$this->RaizView.$vista).".blade.php";

    /// verificar la existencia del archivo
    
    if(file_exists($this->RaizView))
    {
      echo $Blade->render($this->RaizView,$datos);  
    }
    else
    {
        echo "error 404";
    }

 }
}