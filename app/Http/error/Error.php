<?php 
 namespace Http\error;

use lib\View;

 class Error {

 /*** ERROR 404 */
 
 public static function ErrorPage404()
 {
  session_start();
    View::view("error.error404");
 }

 /*** PAGINA NO AUTORIZADO */

 public static function PageNoAutorizado()
 {
  session_start();
   View::view("error.pageNoAutorizado");
 }
 }

?>