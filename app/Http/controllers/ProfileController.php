<?php

use lib\BaseController;

class ProfileController extends BaseController 
{

public function __construct()
{
    session_start();

    $this->NoAuth();
}
 /*==============================
   Vista del perfil
 ===============================*/

 public function index()
 {
    $this->view("usuario.Profile");
 }
}