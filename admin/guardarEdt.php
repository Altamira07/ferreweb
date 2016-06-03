<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (array_key_exists('id_cliente',$_POST))
	 	{
			$cliente = $_POST['id_cliente'];
			$nombre = $_POST['nombre'];
			$paterno= $_POST['apaterno'];
			$materno = $_POST['amaterno'];
			$nacimiento = $_POST['nacimiento'];
			$municipio = $_POST['municipio'];
			$domicilio = $_POST['domicilio'];
			//$web->query("update cliente set apaterno= '$paterno',amaterno='$materno', ");
		}
		$web->smarty->display('exito.html');
	}else{
		header('Location: ..');
	}
?>
