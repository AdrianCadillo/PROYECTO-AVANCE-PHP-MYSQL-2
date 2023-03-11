<?php
namespace traits;

use PDO;

trait Conexion{

     /*********** PROPIEDADES PARA NUESTRA CONEXIÓN ****************** */

     public static $Pps = null;

     private static $Conection = null;
 
     public static string $Query;
 
     public static string $Query_;
 
     /**** METODO PARA LA CONEXIÓN A LA BASE DE DATOS */

     public static  function getConexion()
     {
        try {
            self::$Conection = new PDO(DRIVER,USERNAME,PASSWORD);

            self::$Conection->exec("set names utf8");

        } catch (\Throwable $th) {
            echo $th->getMessage();
        }

        return self::$Conection;
     }

     /*** CERRAR LA CONEXIÓN A LA BASE DE DATOS */

     public abstract static function closeDataBase();
}