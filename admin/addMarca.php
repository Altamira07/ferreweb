<?php
	include ('../sistema.php');
		if ($web->checkRol('administrador'))
	{
		$campos = array ('marca'=>"Nombre de la marca");
		$combos = array();
		$combo = $web->combo("select id_proveedor,proveedor from proveedor","proveedor","4");
		array_push($combos, $combo);
		$web->smarty->assign('nombForm','Agregar Marca');
		$web->smarty->assign('campos',$campos);
		$web->smarty->assign('combos',$combos);
		$web->smarty->display('agregar.html');
	}else{
		header('Location: ..');
	}

?>
