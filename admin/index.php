<?php
	include('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$web->smarty->display('index.html');
	}else{
		header('Location: ..');
	}
?>
