<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$combo = $web->combo("select id_marca,marca from marca","marca");
		$web->smarty->assign('combo',$combo);
		$web->smarty->assign('nombre',"Selecciona la marca a eliminar");
		$web->smarty->display('eliminar.html');
	}else{
		header('Location: ..');
	}
?>
