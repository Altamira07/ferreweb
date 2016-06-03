<?php
	include('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_POST)){
			if (array_key_exists('marca', $_POST) && !empty($_POST['marca'] && !empty($_POST['proveedor']))) {
				$marca = $_POST['marca'];
				$proveedor = $_POST['proveedor'];
				$web->query("insert into marca (marca,id_provedor) values ('$marca','$proveedor')");
			}else if (array_key_exists('proveedor', $_POST) && !empty($_POST['proveedor'])) {
				$proveedor = $_POST['proveedor'];
				$web->query("insert into proveedor (proveedor) values ('$proveedor')");
			}else if (array_key_exists('nombre', $_POST) && !empty($_POST['nombre']) && !empty($_POST['precio']) && !empty($_POST['marca'])) {
				$nombre = $_POST['nombre'];
				$precio = $_POST['precio'];
				$marca = $_POST['marca'];
				$web->query("insert into producto (nombre,precio,id_marca) values ('$nombre','$precio','$marca')");

			}else if (array_key_exists('cliente',$_POST) && !empty ($_POST['cliente']) && !empty($_POST['apaterno']) && !empty($_POST['amaterno']) && !empty($_POST['nacimiento']) && !empty($_POST['municipio']) && !empty($_POST['domicilio'])) {
				$cliente = $_POST['cliente'];
				$paterno= $_POST['apaterno'];
				$materno = $_POST['amaterno'];
				$nacimiento = $_POST['nacimiento'];
				$municipio = $_POST['municipio'];
				$domicilio = $_POST['domicilio'];
				$web->query("insert into cliente (nombre,apaterno,amaterno,nacimiento,domicilio,id_municipio) values('$cliente','$paterno','$materno','$nacimiento','$domicilio','$municipio')");
			} else {
				die("Te falta un campo");
			}
		}
		$web->smarty->display('exito.html');
	}else{
		header('Location: ..');
	}
?>
