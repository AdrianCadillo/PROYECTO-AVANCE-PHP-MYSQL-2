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
}