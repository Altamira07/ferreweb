<?php
	include ('sistema.php');
	print_r($_POST);
	if (isset($_POST)) {
		$correo = $_POST['email'];
		$pass = $_POST['pass'];
		$web = new Sistema;
		$web->Conectar ();
		$web->login($correo,$pass);
	}else
		$web->error("Usuario  o contraseña incorrecta");
?>