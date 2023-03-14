<?php
namespace Repository\implementacion;

use config\DataBase;
use Repository\report\Orm;

class OrmImpl extends DataBase implements Orm
{
/*=========================
METODO PARA REGISTRAR A CUALQUIER 
TABLA DE LA BASE DE DATOS

INSERT INTO TABLA(atributo1,atributo2,atributo3,atributo4)
values(value1,value2,value3,value4)
 
===========================*/

public static function Insert(string $Table,array $datos)
{
 self::$Query = "INSERT INTO $Table(";

 foreach($datos as $atributo=>$value)
 {
    self::$Query.="$atributo,";
 }
/// eliminamos la última coma
 self::$Query = rtrim(self::$Query,",").") VALUES(";

 foreach($datos as $atributo=>$value)
 {
    self::$Query.=":$atributo,";
 }
  /// eliminamo la última coma
 self::$Query = rtrim(self::$Query,",").")";

 try {
    self::$Pps = self::getConexion()->prepare(self::$Query);

    /// enviar los datos

    foreach ($datos as $atributo => $value) {
        
        self::$Pps->bindValue(":$atributo",$value);
    }

    /// ejecutamos la Query

    return self::$Pps->execute();

 } catch (\Throwable $th) {
   echo $th->getMessage();
 }finally{self::closeDataBase();}
}

/*=========================
METODO PARA MOSTRAR DATOS A CUALQUIER 
TABLA DE LA BASE DE DATOS
===========================*/

public static function get(string $Table)
{
 self::$Query = "SELECT *FROM $Table";

 try {
   self::$Pps = self::getConexion()->prepare(self::$Query);

   self::$Pps->execute();

   return self::$Pps->fetchAll(\PDO::FETCH_OBJ);

 } catch (\Throwable $th) {
  echo $th->getMessage();
 }finally{self::closeDataBase();}
}

/*============================
METODO PARA MODIFICAR A CUALQUIER 
TABLA DE LA BASE DE DATOS
==============================*/

public static function Update(string $Tabla,array $datos)
{

}
}