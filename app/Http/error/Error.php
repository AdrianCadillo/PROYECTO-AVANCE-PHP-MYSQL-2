<?php 
 namespace Http\error;

use lib\View;

 class Error {

 /*** ERROR 404 */
 
 public static function ErrorPage404()
 {
    View::view("error.error404");
 }
 }

?>