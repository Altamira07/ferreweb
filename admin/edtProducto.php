<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$web->smarty->assign('nombre',"Editar Proveedor");
		$combo = $web->combo("select id,nombre from producto","producto");
		$web->smarty->assign('combo',$combo);
		$web->smarty->display('editar.html');
	}else{
		header('Location: ..');
	}
?>
