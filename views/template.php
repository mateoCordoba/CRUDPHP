<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>crud PHP</title>
      <link rel="stylesheet" href="views/css/estilos.css">
  </head>
  <body>
    <?php include "modulos/navegacion.php";?>
    <section>
      <?php
        $mvc =new MvcController();
        $mvc -> enlacesPaginasController();
      ?>
    </section>
  </body>
</html>
