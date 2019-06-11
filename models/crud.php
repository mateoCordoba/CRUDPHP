<?php
require_once "conexion.php";
class Datos extends Conexion{
  public function registroUsuarioModel($datosModel,$tabla){
    # Prepare() prepara una sentencia SQL para ser ejecutada por el método PDOStatement::execute()
    # la sentencia SQL puede contener cero o mas marcadores de parámetros con nombre (:name)
    # o signos de interrogacion (?) por los cuales los valores reales serán sustituiodos cuando la sentencia sea ejecutada
    # Ayuda a prevenir inyecciones SQL eliminando la necesidad de entrecomillar manuelmente los mparametros (esto se especifica mejor más adelante)
    $stmt=Conexion::conectar()->prepare("INSERT INTO $tabla(usuario,password,email)VALUES(:usuario,:password,:email);");

    # bindParam() vincula una variable PHP a un parámetro de sutitucion con Nombre
    # o signo de interrogación correspondiente ala sentencua SQL que fue usada
    # para preparar la sentencia
    $stmt->bindParam(":usuario",$datosModel["usuario"], PDO::PARAM_STR);
    $stmt->bindParam(":password",$datosModel["password"],PDO::PARAM_STR);
    $stmt->bindParam(":email",$datosModel["email"],PDO::PARAM_STR);

    if($stmt->execute()){
      return "succes";
    }else{
      return "error";
    }
    $stmt->close();
  }

  public function ingresoUsuarioModel($datosModel, $tabla){
    $stmt=Conexion::conectar()->prepare("SELECT usuario, password FROM $tabla WHERE usuario = :usuario;");
    $stmt->bindParam(":usuario",$datosModel["usuario"],PDO::PARAM_STR);
    $stmt->execute();
    # fetch(); ns retorna una fila de un conjunto de resultado asociados al objeto PDOStatement
    return $stmt->fetch();
  }

  public function vistaUsuariosModel($tabla){
    $stmt=Conexion::conectar()->prepare("SELECT * FROM $tabla;");
    $stmt->execute();
    #fetchAll(); obtiene todas las filas de un conjunto de resultado asiciado al objeto PDOStatement
    return $stmt->fetchAll();
  }

  public function editarUsuarioModel(
    $datosModel,#es la variable $datoscontroller pedida en editaUsuariosController()
    $tabla # es la tabla Usuarios que mandamos como parámetro el metodo editarusuariosModel de la clase Datos
           # almacenado en la variable $respuesta del editarUsuarioController()
  ){
    # Almacenamos en la variable $stmt un prepare accediendo primero al método conectar de la la clase Conexion (creada por mi)
    $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id=:id");

    $stmt -> bindParam(":id",$datosModel,PDO::PARAM_INT);

    $stmt -> execute();

    # fetch() Nos traera una sola fila
    return $stmt ->fetch();
  }

  public function actualizarUsuarioModel($datosModel,$tabla){
    #creamos el statement con el metodo conectar de la clase Conexion y el query para actualizar la tabla
    $stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET usuario =  :usuario, password = :password, email= :email WHERE id = :id");

    #ahora enlazamoms los parámetros

    $stmt->bindParam(":usuario", $datosModel["usuario"],PDO::PARAM_STR);
    $stmt->bindParam(":password", $datosModel["password"],PDO::PARAM_STR);
    $stmt->bindParam(":email", $datosModel["email"],PDO::PARAM_STR);
    #por último ponemos el WHERE
    $stmt->bindParam(":id", $datosModel["id"],PDO::PARAM_INT);
    #Ejecutamos el stmt
    if($stmt->execute()){
      return "succes";
    }else{
      return "error";
    }
    $stmt-> close();
  }


  #BORRAR USUARIOS
  public function borrarUsuariosModel($datosModel,$tabla){
    $stmt=Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id=:id;");

    # Creamos un parámetro de sustitución para en lazarlo al id que traemos desde el Controller
    $stmt->bindParam(":id",$datosModel,PDO::PARAM_INT);

    if($stmt->execute()){
      return "succes";
    }else{
      return "error";
    }
    $stmt->colse();

  }
}


?>
