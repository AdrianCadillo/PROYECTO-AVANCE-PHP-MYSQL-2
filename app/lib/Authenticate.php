<?php
namespace lib;

class Authenticate
{

    private string $SessionUser = "username_";

    private string $redirecToSessionIniciada = "usuario";

    private string $redirectToLogin = "login";

    public function Redirect(string $redireccion)
    {
     header("Location:".URL_BASE.$redireccion);
    }
   

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

    /** Cúando estee authenticado */

    public function auth(){

        if($this->existSession($this->SessionUser)):
           $this->Redirect($this->redirecToSessionIniciada);
        endif;
    }

      /** Cúando no estee authenticado */

    public function NoAuth(){

        if(!$this->existSession($this->SessionUser)):
           $this->Redirect($this->redirectToLogin);
        endif;
    }

    /** cerrar session */

    public function logout_()
    {
        if($this->existSession($this->SessionUser)):
           session_destroy();

           $this->Redirect($this->redirectToLogin);
           
        endif;
    }




} 