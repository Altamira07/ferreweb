<?php
	include  ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_REQUEST) && !empty($_REQUEST)) {
			$correo = $_REQUEST['correo'];
			//$web->query("delete fro");
	 		$web->query ("delete from usuario where email='$correo'");

		}
		header('Location:usuarios.php');
	}else{
		header('Location: ..');
	}
	
?>