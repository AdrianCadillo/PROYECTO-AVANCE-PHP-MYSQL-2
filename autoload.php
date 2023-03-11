<?php

require 'app/config/setting.php';

use lib\Route;

spl_autoload_register(function($file){
 
    /**** INVERTIR \ POR / */

    $file = str_replace("\\","/",$file);
    
    $file = "app/".$file.".php";

    if(file_exists($file))
    {
       require $file; 
    }
});

Route::run();

 