<?php

class MvcController{
  #llamamos a la plantilla
  public function pagina(){
    include "views/template.php";
  }

  #enlaces hacia las diferente páginas
  public function enlacesPaginasController(){
    if (isset($_GET['action'])){
      $enlacesController=$_GET['action'];
    }else{
      $enlacesController="index";
    }
    $respuesta = Paginas::enlacesPaginasModel($enlacesController);
    include $respuesta;
  }

  # Registro de Usuarios
  public function registroUsuarioController(){
    if(isset($_POST["usuarioRegistro"])){
      $datosController = array("usuario"=>$_POST["usuarioRegistro"],
                            "password"=>$_POST["passwordRegistro"],
                            "email"=>$_POST["emailRegistro"]);

      $respuesta=Datos::registroUsuarioModel($datosController,"usuarios");
      echo $respuesta;
    }
  }

  # Ingreso de usuarios
  public function ingresoUsuarioController(){
    if(isset($_POST["usuarioIngreso"])){
      $datosController= array(
        "usuario"=>$_POST["usuarioIngreso"],
        "password"=>$_POST["passwordIngreso"]);
      # Almacenamos en la variable $respuesta  el método ingresoUsuarioModel() de la clase Datos
      # recibiendo como parámetros el Hash "$datosController" con los datos 'usuario' y 'password'
      # y el nombre de la tabla 'usuarios'
      $respuesta = Datos::ingresoUsuarioModel($datosController,"usuarios");

      # Vérificamos si el password ingresado en ingresar coincide
      # con el almacenado en la base de datos de usuario
      if($_POST["passwordIngreso"]== $respuesta["password"] && $_POST["usuarioIngreso"]== $respuesta["usuario"]){
        var_dump("Bienvenido".$respuesta["usuario"]);
        #header sirve para actualiza la página y borrar el caché
        session_start();
          $_SESSION["validar"]=true;
        header("location:index.php?action=usuarios");

      }else{
        var_dump("La contraseña no es correcta o el usuario ".$_POST["usuarioIngreso"] ." No está en la base de datos");
        header("location:index.php?action=fallo");
      }

    }
  }

  # Controller para Ver usuarios
  public function vistaUsuariosController(){
    $respuesta = Datos::vistaUsuariosModel("usuarios");
    foreach ($respuesta as $fila => $item) {
      echo '<tr>
      <td>'.$item["usuario"].'</td>
      <td>'.$item["password"].'</td>
      <td>'.$item["email"].'</td>
      <td><a href="index.php?action=usuarios&idBorrar='.$item["id"].'" ><button>Eliminar</button></a></td>
      <td><a href="http:index.php?action=editar&id='.$item["id"].'"><button>Editar</button></a></td>
      </tr>';
      #Necesitamos enviar el id del usuario que quiero modificar, para a través
      #de esos id vaciar la información en los value del editar.php, para ello
      #vamos a agregar una variable GET en la url donde está el botón editar que no redireccionará a la vista editar.php
      #en el archivo vistaUsuariosController() justo como se ve arrriba ,
    }

  }


  # Controller para editar Usuarios
  public function editarUsuarioController(){
    $datosController=$_GET["id"];
    # para comprovar qué nos trae la varibale $_GET, y lo imprimimos
    echo "id=".$datosController;# esto me retorna la información almacenada ne la variable $datos,
                #  que es la peticion get del 'id' antes realizada en el botón editar
                #conectarme a la base de datos, entonces le voy a pedir al crud.php
                #desde el controller.php que me traiga una respuesta

    # acá solo traemos los datos del usuario con el correspondiente 'id' ya almacenado en la base de datos
    $respuesta = Datos::editarUsuarioModel($datosController,"usuarios");
    var_dump($respuesta);
    echo '
    <input type="hidden" value="'.$respuesta["id"].'" name="idEditar">
    <input type="text" name="usuarioEditar" value="'.$respuesta["usuario"].'" required>
    <input type="password" name="passwordEditar" value="'.$respuesta["password"].'"  required>
    <input type="email"  name="emailEditar" value="'.$respuesta["email"].'" required>
    <input type="submit" value="Actualizar" required>';
  }

  public function actualizarUsuarioController(){
    if(isset($_POST["usuarioEditar"])){
      $datosController = array(
        "id"=>$_POST["idEditar"],
        "usuario" => $_POST["usuarioEditar"],# name de el input del formulario de actualizar usuario
        "password"=> $_POST["passwordEditar"],
        "email"=> $_POST["emailEditar"]
      );

      var_dump($datosController);
      $respuesta = Datos::actualizarUsuarioModel($datosController,"usuarios");
      if($respuesta=="succes"){
        header("location:index.php?action=cambio");
      }else{
        echo "error";
      }

    }
  }

  public function borrarUsuariosController(){
    if(isset($_GET["idBorrar"])){
      $datosController = $_GET["idBorrar"];
      #le enviamos la respuesta al modelo
      $respuesta = Datos:: borrarUsuariosModel($datosController,"usuarios");
      if($respuesta=="succes"){
        header("location:index.php?action=usuarios");
      }else{
        echo "error";
      }
    }
  }


}
?>
