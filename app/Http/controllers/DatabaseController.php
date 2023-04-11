<?php

use Http\error\Error;
use lib\BaseController;
use traits\DatabaseConfig;

class DatabaseController extends BaseController
{

  use DatabaseConfig;  

/** mostrar la vista coopia seguridad  y restaurar sistema*/

public function __construct()
{
    session_start();

    $this->NoAuth();
}

public function index()
{
   if($this->autorizado("Config.copia") or $this->autorizado("Config.restaurar")):
    $this->view("config.index");
   else:
    Error::PageNoAutorizado();
   endif;
}

/** REALIZAR LA COPIA DE SEGURIDAD */

public function copia()
{
    if($this->getTypeMethod() === 'POST'):
      
        if(empty($this->post("name_copia"))):

          $this->assignValueSession("mensaje","Complete el nombre de la copia de seguridad");
           
        else:
         /// llamamos al método copia

         $this->getCopia();
        endif;
     $this->Redirect("database");
    endif;
}

/** Restauración del sistema */

public function restoreBD()
{
   if($this->getTypeMethod() === 'POST')
   {
      $this->restore();
   }  
}
}