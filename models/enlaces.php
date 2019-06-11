<?php

class Paginas{

  public function enlacesPaginasModel($enlaces){
    if(
      $enlaces == "ingresar" ||
      $enlaces == "usuarios" ||
      $enlaces == "editar" ||
      $enlaces == "salir"){
        # de acuerdo al resultado de $enlaces el modulo tendra la ruta de enlace
        $module = "views/modulos/".$enlaces.".php";

    }else if($enlaces == "index.php"){
      $module = "views/modulos/registro.php";

    }else if($enlaces == "ok"){
      $module = "views/modulos/registro.php";

    }else if($enlaces == "fallo"){
      $module = "views/modulos/ingresar.php";

    }else if($enlaces == "cambio"){
      $module = "views/modulos/usuarios.php";

    }else{
      $module = "views/modulos/registro.php";
    }

    return $module;
  }
}
?>
