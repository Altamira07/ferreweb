<?php
	include ('sistema.php');
	$proveedor = $web->mostrartabla("select proveedor from proveedor");
	$web->smarty->assign('proveedor',$proveedor);
	$web->smarty->display('proveedor.html');
?>	