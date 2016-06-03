<?php 
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if ($_SESSION['logueado'])
		{
			$id = $_SESSION['empleado'];
			//echo $id;
			$correo = $_SESSION['email'];
			if(isset($_POST) && isset($_POST['guardar']) && $_POST['guardar'] ){
				$web->smarty->assign('mensaje',"Guardado con exito");
				$nombre = $_POST['nombre'];
				$apaterno = $_POST['apaterno'];
				$amaterno = $_POST['amaterno'];
				$rfc = $_POST['rfc'];
				$nacimiento = $_POST['nacimiento'];
				$web->query("update empleado set nombre='$nombre',apaterno='$apaterno',amaterno= '$amaterno',rfc= '$rfc',nacimiento='$nacimiento' WHERE id_empleado = '$id'");
			}
			$datos = $web->datos("select nombre,apaterno,amaterno,rfc,nacimiento from  empleado where id_empleado = '$id' ");
			$web->smarty->assign('datos',$datos);
			
			$web->smarty->display('datos_empleado.html');
		}else{
			header("Location:..");
		}
	}else{
		header('Location: ..');
	}
?>