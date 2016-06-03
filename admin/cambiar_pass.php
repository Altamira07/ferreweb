<?php 
	include ('../sistema.php');
	if ($web->checkRol('administrador')){
		if (isset($_POST['passActual']) && !empty($_POST['passActual'])) 
		{
			$passActual = md5($_POST['passActual']);
			$correo = $_SESSION['email'];
			$datos = $web->datos("select contrasena from usuario where email = '$correo' && contrasena = '$passActual' ");
			if (!empty($datos))
			{
				if (isset($_POST['passNueva']) && !empty($_POST['passNueva']) && isset($_POST['passR']) && !empty($_POST['passR'])  ) 
				{
					$passNueva = md5($_POST['passNueva']);
					$passR = md5($_POST['passR']);
					if ($passNueva === $passR) {
						$web->query("update usuario set contrasena= '$passNueva' where email = '$correo' ");
						$web->smarty->assign('mensaje',"Exito, Cambiaste la contraseña");
					}else{
						$web->smarty->assign('mensaje',"Las contraseñas no coinciden");
					}
				}
			}else{
				$web->smarty->assign('mensaje',"La contraseña Actual no es valida");
			}
		}
		$web->smarty->display('cambiar_pass.html');
	}else{
		header('Location: ..');
	}
?>