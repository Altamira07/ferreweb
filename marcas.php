<?php
	include ('sistema.php');
	$marcas = $web->mostrartabla("select * from marca");
	$web->smarty->assign('marcas',$marcas);
	$web->smarty->display('marcas.html');
?>	