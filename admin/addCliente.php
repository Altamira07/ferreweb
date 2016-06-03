<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$campos = array ('cliente'=>"Nombre del cliente",'apaterno'=>"Apellido Paterno",'amaterno'=>"Apellido Materno",'nacimiento'=>"nacimiento",'domicilio'=>"Domicilio");
		$combos = array();
		$combo = $web->combo("select id_municipio,municipio from municipio","municipio");
		array_push($combos, $combo);
		$web->smarty->assign('nombForm','Agregar Cliente');
		$web->smarty->assign('campos',$campos);
		$web->smarty->assign('combos',$combos);
		$web->smarty->display('agregar.html');
	}else{
		header('Location: ..');
	}
	
	
?>
