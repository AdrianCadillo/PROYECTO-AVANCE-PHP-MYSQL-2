<?php
namespace lib;

class Authenticate
{

    /** validar una variable de session */

    public function existSession(string $NameSession)
    {
     return isset($_SESSION[$NameSession]);
    }

    /** Obtener la variable de session */

    public function getSession(string $NameSession)
    {
        return $_SESSION[$NameSession];
    }

    /** asignar a una variable de session un valor */

    public function assignValueSession(string $NameSession,$value)
    {
        $_SESSION[$NameSession] = $value;
    }

    /** eliminar una variable en session en particula */
    public function deleteSession(string $NameSession)
    {
      if(isset($_SESSION[$NameSession]))
       unset($_SESSION[$NameSession]);
    }
} 