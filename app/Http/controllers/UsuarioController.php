<?php

use lib\BaseController;
use models\Role;
use models\Usuario;
use Repository\report\CrudRepository;

class UsuarioController extends BaseController
{

  /*** PROPIEDADES */

  private string $RutaFoto = "public/lib/fotos/";

  private CrudRepository $ModelUser;

  private CrudRepository $ModelRole;

  private array $Errors = [];

  public function __construct()
  {
    session_start();
    
    $this->ModelUser = new Usuario;

    $this->ModelRole = new Role;
    
    $this->NoAuth();
  
  }

  public function index()
  {

    $Usuarios = $this->ModelUser->all();

    $this->view("usuario.IndexView", compact("Usuarios"));
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
    if (isset($_POST['save'])) {
      /// validar los inputs

      if (empty($this->post("username"))) :
        $this->Errors[] = 'Complete el campo de nombre de usuario';
      else :
        $this->assignValueSession("username", $this->post("username"));
      endif;

      if (empty($this->post("email"))) :
        $this->Errors[] = 'Complete el campo de nombre de email';
      else :

        if (!filter_var($this->post("email"), FILTER_VALIDATE_EMAIL)) :
          $this->Errors[] = 'el email es incorrecto ):';
        endif;

        $this->assignValueSession("email", $this->post("email"));
      endif;

      if (empty($this->post("pasword"))) :
        $this->Errors[] = 'Complete el campo de nombre de password';
      endif;

      /// verificamos que el array errors
      if (count($this->Errors) == 0) {
        $this->createAccount();


        /// redirecciona a la misma página

        $this->Redirect("usuario");
      } else {

        $this->assignValueSession("error", $this->Errors);


        /// redirecciona a la misma página

        $this->Redirect("usuario/create");
      }
    } else {
      /// redirecciona a la misma página

      $this->Redirect("usuario/create");
    }
  }
  /*===============================
REALIZA EL PROCESO DE REGISTRO DE 
USUARIOS
================================*/
  private function createAccount()
  {
    if ($this->getSizefile("foto") > 0) {
      if ($this->getTypefile("foto") === 'image/png') {
        /// creamos el nuevo nombre de la imagen

        $NameImagen = date("YmdHis") . rand() . ".png";
      } else {
        /// creamos el nuevo nombre de la imagen

        $NameImagen = date("YmdHis") . rand() . ".jpg";
      }

      $Datos_Usuario = [
        "username" => $this->post("username"),
        "email" => $this->post("email"),
        "pasword" => password_hash($this->post("pasword"), PASSWORD_BCRYPT),
        "foto" => $NameImagen
      ];

      // enviarlo al servidor

      $this->RutaFoto .= $NameImagen;

      move_uploaded_file($this->getArchivo("foto"), $this->RutaFoto);
    } else {

      $Datos_Usuario = [
        "username" => $this->post("username"),
        "email" => $this->post("email"),
        "pasword" => password_hash($this->post("pasword"), PASSWORD_BCRYPT),
      ];
    }

    /// mandamos el registro a la base de datos

    $Usuario_new = $this->ModelUser->create($Datos_Usuario);

    if ($Usuario_new == 1) {
      /// obtener el nuevo usuario

      $Usuario = Usuario::search($this->post("username"));

      if (count($Usuario) > 0) {
        /// obtenemos el id del usuario

        $IdUsuario = $Usuario[0]->id_usuario;

        /// verificar si hay or lo menos un rol seleccionado

        if (isset($_POST['role'])) {
          foreach ($this->post("role") as $role) {
            /// asignamos los roles al usuario

            Usuario::assignRole([
              'id_rol' => $role,
              'id_usuario' => $IdUsuario
            ]);
          }
        }
      }

      $this->assignValueSession("mensaje", "success");

      $this->reset();
    } else {

      if ($Usuario_new === 'existe') {
        $this->assignValueSession("mensaje", "existe");
      } else {
        $this->assignValueSession("mensaje", "error");
      }
    }
  }

  /*** poder mostrar los roles */

  public function showRoles()
  {

    echo json_encode(['roles' => $this->ModelRole->all()]);
  }

  /** resetear los campos */

  private function reset()
  {
    $this->deleteSession("username");

    $this->deleteSession("email");
  }

  /** EDITAR LOS USUARIOS */

  public function editar($datos = null)
  {
    if ($datos != null) {
      if (!empty($datos[0])) {
        $Roles = $this->ModelRole->all();

        /// mostrar los roles que tiene asignado el usuario a editar

        $Roles_Usuario = Usuario::roles($datos[0]);

        /// roles no asignados del usuario

        $Roles_No_Asignados_User = Usuario::rolesNoAsigned($datos[0]);

        $Usuario = Usuario::getBydId($datos[0]);

        $this->view("usuario.EditarView", compact("Usuario", "Roles", "Roles_Usuario", "Roles_No_Asignados_User"));
      } else {
        $this->Redirect("usuario");
      }
    } else {
      $this->Redirect("usuario");
    }
  }

  /** Método para modificar un usuario */

  private function UpdateUserData($id)
  {
    if ($this->getSizefile("foto") > 0) {
      if ($this->getTypefile("foto") === 'image/png') {
        /// creamos el nuevo nombre de la imagen

        $NameImagen = date("YmdHis") . rand() . ".png";
      } else {
        /// creamos el nuevo nombre de la imagen

        $NameImagen = date("YmdHis") . rand() . ".jpg";
      }

      $Datos_Usuario = [
        "id_usuario" => $id,
        "username" => $this->post("username"),
        "email" => $this->post("email"),
        "foto" => $NameImagen
      ];

      // enviarlo al servidor

      $this->RutaFoto .= $NameImagen;

      move_uploaded_file($this->getArchivo("foto"), $this->RutaFoto);
    } else {

      $Datos_Usuario = [
        "id_usuario" => $id,
        "username" => $this->post("username"),
        "email" => $this->post("email"),
      ];
    }

    /// mandamos el registro a la base de datos

    $Usuario_new = $this->ModelUser->modify($Datos_Usuario);

    if ($Usuario_new == 1) {
      /// obtener el nuevo usuario

      $Usuario = Usuario::search($this->post("username"));

      if (count($Usuario) > 0) {
        /// obtenemos el id del usuario

        $IdUsuario = $Usuario[0]->id_usuario;

        /// eliminamos los roles del usuario

        Usuario::deleteRoles($id);

        /// verificar si hay or lo menos un rol seleccionado


        if (isset($_POST['role'])) {
          foreach ($this->post("role") as $role) {
            /// asignamos los roles al usuario

            Usuario::assignRole([
              'id_rol' => $role,
              'id_usuario' => $IdUsuario
            ]);
          }
        }
      }

      $this->assignValueSession("mensaje_update", "success");

      $this->reset();
    } else {
      $this->assignValueSession("mensaje_update", "error");
    }
  }

  public function update($dato = null)
  {

    if (isset($_POST['update'])) {
      /// validar los inputs

      if (empty($this->post("username"))) :
        $this->Errors[] = 'Complete el campo de nombre de usuario';
      endif;

      if (empty($this->post("email"))) :
        $this->Errors[] = 'Complete el campo de nombre de email';
      else :

        if (!filter_var($this->post("email"), FILTER_VALIDATE_EMAIL)) :
          $this->Errors[] = 'el email es incorrecto ):';
        endif;
      endif;

      /// verificamos que el array errors
      if (count($this->Errors) == 0) {
        $this->UpdateUserData($dato[0]);


        /// redirecciona a la misma página

        $this->Redirect("usuario");
      } else {

        $this->assignValueSession("error", $this->Errors);


        /// redirecciona a la misma página

        $this->Redirect("usuario/editar/" . $dato[0]);
      }
    } else {
      /// redirecciona a la misma página

      $this->Redirect("usuario");
    }
  }

  /** método para eliminar usuarios */

  public function delete($dato = null)
  {
    if (isset($_POST['delete'])) {
      /// elimino todos los roles del usuario

      Usuario::deleteRoles($dato[0]);

      /// elimino al usuario

      echo $this->ModelUser->delete($dato[0]);
    }
  }
}
