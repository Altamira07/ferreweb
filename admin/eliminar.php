<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset ($_POST)) {
			if(array_key_exists('producto',$_POST) && !empty($_POST['producto'] )){
				$proveedor = $_POST['producto'];
				$web->query("delete from producto where id_proveedor='$proveedor'");
				$web->smarty->display('delProducto.php');
			}
			if (array_key_exists('cliente',$_POST) && !empty($_POST['cliente'])) {
				$cliente = $_POST['cliente'];
				$web->query("delete from cliente where id_cliente = '$cliente'");
				$web->smarty->display('delCliente.php');
			}
		}
	}else{
		header('Location: ..');
	}
?>
