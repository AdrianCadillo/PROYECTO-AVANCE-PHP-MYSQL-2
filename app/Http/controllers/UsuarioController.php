<?php

use lib\BaseController;
use Repository\implementacion\OrmImpl;

class UsuarioController extends BaseController{


public function index()
{
    $datos = "Hola, soy el dato del usuario";

    $this->view("usuario.IndexView",compact("datos"));
}  

public function test()
{
   echo OrmImpl::Insert("usuario",[
     "username"=>"adrian@3400",
     "email"=>"adriaaanroosales@gmail.com",
     "pasword"=>"12345678",   
    ]);
}

}