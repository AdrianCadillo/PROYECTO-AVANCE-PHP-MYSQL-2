<?php
namespace Repository\report;

interface Orm 
{
/*=========================
METODO PARA REGISTRAR A CUALQUIER 
TABLA DE LA BASE DE DATOS
===========================*/

public static function Insert(string $Table,array $datos);

/*=========================
METODO PARA MOSTRAR REGISTROS DE 
CUALQUIER TABLA
===========================*/

public static function get(string $Table);

/*============================
METODO PARA MODIFICAR A CUALQUIER 
TABLA DE LA BASE DE DATOS
==============================*/

public static function Update(string $Tabla,array $datos);


/*============================
METODO PARA BUSQUEDAS DE CUALQUIER TABLA
POR UN ATRIBUTO
==============================*/

public static function Search_(string $Table,$atributo,$valor);
/*============================
METODO PARA ELIMINAR CUALQUIER REGISTRO DE UNA TABLA
==============================*/

public static function destroy(string $Tabla,string $atributo,$valor);

/*================================
Llamamos a un procedimiento almacenado
=================================*/

public static function procedure(string $Procedure,array $datos,$evento);

}