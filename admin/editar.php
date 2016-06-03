<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_GET))
		{
			if (array_key_exists('proveedor',$_GET) && !empty($_GET['proveedor'])) {
				$id = $_GET['proveedor'];
				$web->smarty->assign('nombre',"Editar proveedor");
				$datos = $web->datos("select * from proveedor where id_proveedor =$id");
				$web->smarty->assign('id',"id_proveedor");
			}else if (array_key_exists('marca',$_GET) && !empty($_GET['marca'])) {
				$id = $_GET['marca'];
				$combos = array();
				$web->smarty->assign('nombre',"Editar marca");
				$combo = $web->comboSelect("select id_proveedor,proveedor from proveedor","proveedor",$id);
				$datos = $web->datos("select id_marca,marca from marca where id_marca =$id");
				array_push($combos, $combo);
				$web->smarty->assign('id',"id_marca");
				$web->smarty->assign('combos',$combos);
			}else if (array_key_exists('producto', $_GET) && !empty($_GET['producto'])){
				$id = $_GET['producto'];
				$seleccion = $web->datos("select id_marca from producto where id=$id");
				$seleccion = $seleccion[0];
				$combos = array();
				$web->smarty->assign('nombre',"Editar producto");
				$datos = $web->datos ("select id, nombre,precio from producto where id='$id'");
				$combo = $web->comboSelect ("select id_marca,marca from marca","marca",$seleccion);
				array_push($combos, $combo);
				$web->smarty->assign('id',"id");
				$web->smarty->assign('combos',$combos);
			} else if (array_key_exists('cliente', $_GET) && !empty($_GET['cliente'])) {
				 $id = $_GET['cliente'];
				 $combos = array();
				 $web->smarty->assign('nombre',"editar cliente");
				 $datos = $web->datos("select id_cliente,nombre,apaterno,amaterno,domicilio,nacimiento from cliente where id_cliente =$id");
				 array_push($combos, $combo);
				 $web->smarty->assign('id',"id");
				 $web->smarty->assign('combos',$combos);
			}
			$datos = $datos[0];
			foreach ($datos as $key => $value) {
				if (is_numeric($key)) {
						unset($datos[$key]);
				}
			}
			$web->smarty->assign('datos',$datos);


		}
		$web->smarty->display('edicion.html');
	}else{
		header('Location: ..');
	}
?>
