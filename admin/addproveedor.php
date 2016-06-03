<?php
	include('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$campos = array ('proveedor'=>"Nombre del proveedor");
		$web->smarty->assign('campos',$campos);
		$web->smarty->assign('nombForm','Agregar proveedor');
		$web->smarty->display('agregar.html');
	}else{
		header('Location: ..');
	}
?>
