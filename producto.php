<?php
	include ('sistema.php');
	$categoria = $web->datos("select * from categoria");
	$web->smarty->assign('categoria',$categoria);
	$web->smarty->display('producto.html');
?>