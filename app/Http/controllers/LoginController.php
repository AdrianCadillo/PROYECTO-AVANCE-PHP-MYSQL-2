<?php

use lib\BaseController;
use models\Role;
use models\Usuario;
use Repository\report\CrudRepository;

class LoginController extends BaseController
{

  private CrudRepository $ModelRole;

  private array $Errors = [];

    public function __construct()
    {
        $this->ModelRole = new Role;

        session_start();

        $this->auth();
    }
 /*=============================
   MOSTRAR LA VISTA DE LOGIN
 =============================*/

 public function index()
 {
    $Roles = $this->ModelRole->all();

    $this->view("auth.login",compact("Roles"));
 }
 /*=============================
   Método para la acción del boton login
 =============================*/

 public function login()
 {
    if($this->getTypeMethod() === "POST"):
       if($this->Validate()):
          $this->Attemp([
           "email"=>$this->post("email"),
           "rol"=>$this->post("rol"),
           "password"=>$this->post("pasword")
          ]);
       endif;
    endif;
 }

   /*=============================
   Método para Validar login
   =============================*/

private function Validate():bool
{
 if(empty($this->post("rol"))):
    $this->Errors[] = 'Seleccione un perfíl';
 else:
    $this->assignValueSession("rol",$this->post("rol"));
 endif;

 if(empty($this->post("email"))):
    $this->Errors[] = 'Complete su email';
 else:
    if(!filter_var($this->post("email"),FILTER_VALIDATE_EMAIL)):
       $this->Errors[] = 'El email es incorrecto';
    endif;
    $this->assignValueSession("email",$this->post("email"));
 endif;

 if(empty($this->post("pasword"))):
    $this->Errors[] = 'Complete su password';
 else:
    $this->assignValueSession("pasword",$this->post("pasword"));
 endif;

 /// preguntamos si hay errores

 if(count($this->Errors) == 0):
   return true;
 else:
    $this->assignValueSession("errores_login",$this->Errors);

    $this->Redirect("login");
 endif;
}

/*** Metodo para el acceso al sistema */

private function Attemp(array $datos)
{
   /// obtener al usuario
   
   $Usuario = Usuario::SignIn([$datos["email"],$datos["rol"]]);

   if(count($Usuario) > 0):

     $Email = $Usuario[0]->email;

     if($datos["email"] === $Email):
        
        /// obtenemos el password

        $Password = $Usuario[0]->pasword;

        if(password_verify($datos["password"],$Password)):
            
            $this->profile(
              $Usuario[0]->username,
              $Usuario[0]->email,
              $Usuario[0]->name_rol,
              $Usuario[0]->foto === null ? '':$Usuario[0]->foto,
              $Usuario[0]->id_rol
            );

            $this->Redirect("dashboard");

        else:
            $this->assignValueSession("mensaje_login","error en la contraseña");

            $this->Redirect("login");

        endif;
        
     else:
        $this->assignValueSession("mensaje_login","Error, el usuario no coincide con la base de datos");

        $this->Redirect("login");

     endif;

   else:

    $this->assignValueSession("mensaje_login","Usuario no existe en la base de datos");

    $this->Redirect("login");
   endif;
}

/** Profile del usuario */

private function profile(string $username,string $email,string $rol,string $foto,$id_rol)
{
  $this->assignValueSession("username_",$username);

  $this->assignValueSession("email",$email);

  $this->assignValueSession("rol_perfil",$rol);

  $this->assignValueSession("foto",$foto);

  $this->assignValueSession("id_perfil",$id_rol);
}


/** Método para cerrar session al sistema */

public function logout()
{
  $this->NoAuth();

  $this->logout_();
}

}