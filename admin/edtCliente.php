<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		$web->smarty->assign('nombre',"Editar Cliente");
		$combo = $web->combo("select id_cliente,nombre from cliente","cliente");
		$web->smarty->assign('combo',$combo);
		$web->smarty->display('editar.html');
	}else{
		header('Location: ..');
	}
?>
