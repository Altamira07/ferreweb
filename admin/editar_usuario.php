<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_GET) && !empty($_GET) && isset($_GET['correo']) &&!empty($_GET['correo']) ) {
			$web->smarty->assign('correo',$_GET['correo']);
			$web->smarty->display('editar_usuario.html');
		}else{
			header("Location:usuarios.php");
		}
	}else{
		header('Location: ..');
	}

?>