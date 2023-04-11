<?php

use lib\BaseController;

class DashboardController extends BaseController
{

public function __construct()
{
    session_start();

    $this->NoAuth();
}    
/*========================
VISUALIZAR LA VISTA DE Dashboard
========================== */

public function index()
{
    $this->view("Dashboard");
}
}