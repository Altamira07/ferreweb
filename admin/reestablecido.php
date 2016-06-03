<?php 
	include ('../sistema.php');
	$plantilla = '';
	if ($web->checkRol('administrador'))
	{
		if (isset($_POST) && !empty($_POST))
		{
			$pass = $_POST['pass'];
			$passR = $_POST['passR'];
			$pass = md5($pass);
			$passR = md5($passR);
		}
		if (isset($pass) && $pass === $passR)
		{
			$correo = $_SESSION['email'];
			$web->query ("update usuario set contrasena='$pass', clave='' where email = '$correo' "); 
			$plantilla = 'exito.html';
		}else{
			$web->smarty->assign('mensaje',"Las contraseñas deben ser iguales");
			$plantilla = 'reestablecer.html';
		}
		$web->smarty->display($plantilla);
	}else{
		header('Location: ..');
	}
?>