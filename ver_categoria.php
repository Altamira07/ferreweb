<?php 
	include ('sistema.php');
	if (isset($_GET['categoria']) && !empty($_GET['categoria']))
	{
		$id_categoria = $_GET['categoria'];
		$nombre = $web->datos("select nombre from categoria where id_categoria = '$id_categoria'");
		$nombre = $nombre[0][0];
		$web->smarty->assign('nombre',$nombre);
		$dolar = $web->dolar_peso();
		$datos = $web->datos("select * from verCategoria where id_categoria = '$id_categoria'");
		foreach ($datos as $key => $value) {
			$dolares = $value[3]/$dolar[0];
			array_push($datos[$key],$dolares);
		}
		$web->smarty->assign('fecha',$dolar[1]);
		$web->smarty->assign('datos',$datos);
		$web->smarty->display('ver_categoria.html');	
	
	}else
		header("Location:producto.php");
?>