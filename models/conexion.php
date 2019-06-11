<?php

class Conexion{
  public function conectar(){
    $link = new PDO("mysql:host=localhost:3306;dbname=cursoPHP","mateo","Boundman");
    return $link;
    #var_dump($link);
  }
}
$a = new conexion();
$a -> conectar();
?>
