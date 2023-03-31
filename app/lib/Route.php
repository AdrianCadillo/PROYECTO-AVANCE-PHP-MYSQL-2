<?php
namespace lib;

use Http\error\Error;

class Route 
{

 /** PROPIEDADES */   

 private static array $Ruta;

 private static string $raizApp = "app/Http/controllers/";
/*==========================
Retorna la url
===========================*/

private static function getUrl():array
{
    if(isset($_GET['ruta']))
    {
       self::$Ruta = explode("/",$_GET['ruta']);  
    }

    return self::$Ruta;
}

/*==========================
Obtener el controlador  
===========================*/
private static function getNameController():string
{
 return !empty(self::getUrl()[0])?ucwords(self::getUrl()[0])."Controller":"";
}

/*==========================
Obtener el método 
===========================*/
private static function getNameMethod():string
{
 return !empty(self::getUrl()[1])?self::getUrl()[1]:"";
}
/*==========================
Run router (valida que el controlador y metodo exista)
===========================*/

public static function run()
{
 /// verificamos que hemos especificado el controlador en el navegador   
 if(!empty(self::getNameController())):

    /// crear una variable para alamcenar el controlador

    $Controller = self::getNameController();

    /// creamos el archivo controlador

    $File = self::$raizApp.$Controller.".php";

    /// verificamos que exista el archivo controlador

    if(file_exists($File)):
     /// importamos el archivo

     require_once $File;

     /// creamos un objeto que instancie al controlador

     $Objeto = new $Controller;

     /// verificar que el método no este vacio

     if(!empty(self::getNameMethod())):
       
        $Methodo = self::getNameMethod(); /// le asignamos el metodo a una variable

        if(method_exists($Objeto,$Methodo)): /// verificamo que el método exista
                
            /// proceso para casos que el método tenga parámetros

            self::requestParamMethod($Objeto,$Methodo);

        else:
            /// error 4040
            Error::ErrorPage404();

        endif;
    else:
        $Objeto->index();
     endif;
    else:
      Error::ErrorPage404();
    endif;
  
else:
    /// redirigir a una página principal

    echo "pagina principal";
 endif;
}

/*==========================
Validamos si el método tendrá argumento o no
===========================*/

private static function requestParamMethod($Objeto,$methodo)
{
 $Cantidad_Ruta = sizeof(self::getUrl());

  if($Cantidad_Ruta>2) /// contiene parametros
  {
    $Parametros = [];

    for($item = 2;$item < $Cantidad_Ruta;$item++)
    {
     array_push($Parametros,self::getUrl()[$item]);
    }
    
    $Objeto->{$methodo}($Parametros);
  }
  else
  {
    $Objeto->{$methodo}();
  }
}



}