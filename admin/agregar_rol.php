<?php
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_REQUEST) && !empty($_REQUEST) && isset($_REQUEST['correo'])) {
			$correo = $_REQUEST['correo'];
			$datos = $web->datos("select usuario from usuario where email ='$correo' ");
			$id = $datos [0]['usuario'];
			if (isset($_REQUEST['roles']) && !empty($_REQUEST['roles'])) {
				$id_rol = $_REQUEST['roles'];
				$web->query("insert into rol_usuario (id_rol,id) value ($id_rol,$id) ");
			}
			$datos = $web->datos("select id_rol,rol from rol where id_rol in (select id_rol from rol_usuario where id= $id )" );
			$combo = $web->combo("select id_rol,rol from rol","roles");
			//Asiganacion de varibles necesarias para el formulario
			$web->smarty->assign('correo',$correo);
			$web->smarty->assign('combo',$combo);
			$web->smarty->assign('datos',$datos);
			$web->smarty->display('agregar_rol.html');//desplegar la vista
		}else{
			header("Location:usuarios.php");
		}
	}else{
		header('Location: ..');
	}

	
?>