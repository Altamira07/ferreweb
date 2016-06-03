<?php
	include ('sistema.php');
	if(isset($_REQUEST) && !empty($_REQUEST)){
		$correo = $_REQUEST['datos']['email'];
		$pass = md5($_REQUEST['datos']['pass']);
		$passR = md5($_REQUEST['datos']['passR']);

		if ($pass === $passR) {
			$web->query ("insert into usuario (email,contrasena) value ('$correo','$pass')");
			$id = $web->getId($correo);
			$web->query("insert into rol_usuario (id_rol,id) value ('3','$id')");
			header('Location:iniciarsecion.php');
		}else{
			header('Location:nueva_cuenta.php');
		}

	}	
?>