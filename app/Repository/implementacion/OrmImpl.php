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
 self::$Query = "UPDATE $Tabla SET ";

 foreach($datos as $atribute=>$value)
 {
   self::$Query.="$atribute=:$atribute,";
 }

 /// quitamos la última coma
self::$Query = rtrim(self::$Query,",")." WHERE ".array_keys($datos)[0]."=:".array_key_first($datos);

/// verificamos antes de modificar , si el id existe

if(count(self::Search_($Tabla,array_key_first($datos),array_values($datos)[0]))>0){
try {
   self::$Pps = self::getConexion()->prepare(self::$Query);

   foreach($datos as $atribute=>$value)
   {
    self::$Pps->bindValue(":$atribute",$value);
   }

   return self::$Pps->execute();

} catch (\Throwable $th) {

    echo $th->getMessage();
}finally{self::closeDataBase();}
}else
{
 echo "<h1 style=color:red;>No existe el id ".array_values($datos)[0]." </h1>";
} 
}

/*============================
METODO PARA BUSQUEDAS DE CUALQUIER TABLA
POR UN ATRIBUTO
==============================*/

public static function Search_(string $Table,$atributo,$valor){
   
   self::$Query_ = "SELECT *FROM $Table WHERE $atributo=:$atributo";

   try {
     self::$Pps = self::getConexion()->prepare(self::$Query_);

     self::$Pps->bindParam(":$atributo",$valor);

     self::$Pps->execute();

     return self::$Pps->fetchAll(\PDO::FETCH_OBJ);

   } catch (\Throwable $th) {
      echo $th->getMessage();
   }finally{self::closeDataBase();}
}

/*============================
METODO PARA ELIMINAR CUALQUIER REGISTRO DE UNA TABLA
==============================*/

public static function destroy(string $Tabla,string $atributo,$valor)
{
   self::$Query = "DELETE FROM $Tabla WHERE $atributo=:$atributo";

   /// validar si existe el id a eliminar

   if(count(self::Search_($Tabla,$atributo,$valor))>0){

   try {
      self::$Pps = self::getConexion()->prepare(self::$Query);

      self::$Pps->bindParam(":$atributo",$valor);

      return self::$Pps->execute();

   } catch (\Throwable $th) {
      
      echo $th->getMessage();
   }finally{self::closeDataBase();}
}else
{
   echo "<h1 style=color:red;>No existe el id ".$valor." </h1>";
}
}
}