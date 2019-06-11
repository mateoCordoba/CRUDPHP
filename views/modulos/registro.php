<h1>Registreo de usuarios</h1>
<form method="post">
  <input name="usuarioRegistro" type="text" placeholder="Nombre de usuario" required>
  <input name="passwordRegistro" type="password" placeholder="Contraseña" required>
  <input name="emailRegistro" type="email" placeholder="E-mail" required>
  <input name type="submit"value="Registrar" required>
</form>

<?php
$registro= new MvcController();
$registro -> registroUsuarioController();
?>
