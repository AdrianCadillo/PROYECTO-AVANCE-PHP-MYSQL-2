<?php

use lib\BaseController;

class ConfigController extends BaseController
{

/** mostrar la vista coopia seguridad  y restaurar sistema*/

public function __construct()
{
    session_start();

    $this->NoAuth();
}

public function index()
{
    $this->view("config.index");
}
}