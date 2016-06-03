<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$combo = $web->combo("select id_proveedor,proveedor from proveedor","proveedor");
		$web->smarty->assign('combo',$combo);
		$web->smarty->assign('nombre',"Selecciona el proveedor a eliminar");
		$web->smarty->display('eliminar.html');
	}else{
		header('Location: ..');
	}
?>
