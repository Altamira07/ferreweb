<?php
	include ('sistema.php');
	if (isset($_REQUEST['q']))
	{
		$q=$_REQUEST['q'];
	}else{
		$q='';
	}
	$q = $web->mostrartabla("select nombre,marca,precio from producto p inner join marca m on m.id_marca = p.id_marca where nombre like '%".$q."%'");
	$web->smarty->assign('producto',$q);
	$web->smarty->display('producto.html');
?>