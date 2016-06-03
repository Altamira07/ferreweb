<?php 
	include ('sistema.php');
	if (isset($_GET) && !empty($_GET) && isset($_GET['producto']) && !empty($_GET['producto']) && isset($_GET['categoria']) && !empty($_GET['categoria'])) 
	{
		$id = $_GET['producto'];
		$detalle = $web->datos("select * from detalle where id='$id' ");
		$cometarios = $web->datos("select * from comentario where id= '$id'");
		$id = $_GET['categoria'];
		$nombre = $web->datos ("select nombre from categoria where id_categoria = '$id'");
		$nombre = $nombre[0][0];
		$web->smarty->assign('nombre',$nombre);
		$web->smarty->assign('detalle',$detalle);
		$web->smarty->assign('comentarios',$cometarios);
		$web->smarty->assign('categoria',$_GET['categoria']);
		$web->smarty->display('detalle.html');
	}else
		header("Location:producto.php")
?>