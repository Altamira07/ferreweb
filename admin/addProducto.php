<?php
	include('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$campos = array ('nombre'=>"Nombre del produto",'precio'=>"precio");
		$combos = array();
		$combo = $web->combo("select id_marca,marca from marca","marca");
		array_push($combos, $combo);
		$web->smarty->assign('campos',$campos);
		$web->smarty->assign('combos',$combos);
		$web->smarty->assign('nombForm',"Agregar Producto");
		$web->smarty->display('agregar.html');
	}else{
		header('Location: ..');
	}

?>
