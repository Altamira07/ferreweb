<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$combo = $web->combo("select id,nombre from producto","producto");
		$web->smarty->assign('combo',$combo);
		$web->smarty->assign('nombre',"Selecciona el producto a eliminar");
		$web->smarty->display('eliminar.html');
	}else{
		header('Location: ..');
	}
?>
