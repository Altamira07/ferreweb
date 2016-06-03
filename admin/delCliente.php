<?php
  include ('../sistema.php');
  	if ($web->checkRol('administrador'))
	{
	
	  $combo = $web->combo("select id_cliente,nombre from cliente","cliente");
	  $web->smarty->assign('combo',$combo);
	  $web->smarty->assign('nombre',"Selecciona el Cliente a eliminar");
	  $web->smarty->display('eliminar.html');
	}else{
		header('Location: ..');
	}
?>
