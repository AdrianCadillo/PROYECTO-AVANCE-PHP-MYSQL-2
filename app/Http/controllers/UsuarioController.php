<?php

use lib\BaseController;
use models\Usuario;
use Repository\report\CrudRepository;

class UsuarioController extends BaseController{

/*** PROPIEDADES */

private string $RutaFoto = "public/lib/fotos/";

private CrudRepository $ModelUser;

public function __construct()
{
    $this->ModelUser = new Usuario;
}

public function index()
{
    $datos = "Hola, soy el dato del usuario";

    $this->view("usuario.IndexView",compact("datos"));
}  

/*===============================
PARA LA VISTA DE CREAR NUEVO USUARIO
================================*/

public function create()
{
 $this->view("usuario.Create");
}
/*===============================
PARA CREAR UN USUARIO NUEVO EN LA 
BASE DE DATOS
================================*/

public function store()
{
  if(isset($_POST['save']))
  {
    $this->createAccount();
  }else{
     
  }
}
/*===============================
REALIZA EL PROCESO DE REGISTRO DE 
USUARIOS
================================*/
private function createAccount()
{
 if($this->getSizefile("foto")>0)
 {
   if($this->getTypefile("foto") === 'image/png')
   {
       /// creamos el nuevo nombre de la imagen

   $NameImagen = date("YmdHis").rand().".png";

   }
   else{
       /// creamos el nuevo nombre de la imagen

    $NameImagen = date("YmdHis").rand().".jpg";
    
   }

   $Datos_Usuario = [
    "username"=>$this->post("username"),
    "email"=>$this->post("email"),
    "pasword"=>password_hash($this->post("pasword"),PASSWORD_BCRYPT),
    "foto"=>$NameImagen
   ];

   // enviarlo al servidor

   $this->RutaFoto.=$NameImagen;

   move_uploaded_file($this->getArchivo("foto"),$this->RutaFoto);

 }else{

    $Datos_Usuario = [
        "username"=>$this->post("username"),
        "email"=>$this->post("email"),
        "pasword"=>password_hash($this->post("pasword"),PASSWORD_BCRYPT),
    ];
    
 }

 /// mandamoa el registro a la base de datos

   echo $this->ModelUser->create($Datos_Usuario);
}


}