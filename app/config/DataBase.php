<?php
namespace config;

use traits\Conexion;

class DataBase
{
 use Conexion;
 
   /*** CERRAR LA CONEXIÓN A LA BASE DE DATOS */

   public static function closeDataBase()
   {
    if(self::$Pps != null)
    {
        self::$Pps = null;
    }

    if(self::$Conection != null)
    {
        self::$Conection = null;
    }
   }
} 