<?php 
	include ('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if (isset($_REQUEST['id_rol']) && !empty($_REQUEST['id_rol']))
		{
			$id_rol = $_REQUEST['id_rol'];
			if (isset($_REQUEST['privilegio']) && !empty($_REQUEST['privilegio'])) 
			{
				$privilegio = $_REQUEST['privilegio'];
				if (!$web->existePrivilegio($privilegio)) 
					$web->query("insert into privilegio (privilegio) value ('$privilegio')");	
				$id_privilegio = $web->getIdPrivilegio($privilegio);
				$web->query("insert into rol_privilegio (id_rol,id_privilegio) value ('$id_rol','$id_privilegio')");
			}
			if (isset($_REQUEST['eliminar']) && !empty($_REQUEST['eliminar']))
			{
				$id_privilegio = $_REQUEST['eliminar'];
				$web->query("delete from rol_privilegio where id_rol ='$id_rol' && id_privilegio = '$id_privilegio' ");
			}
			
			$datos = $web->datos ("select id_privilegio,privilegio from privilegio where id_privilegio in (select id_privilegio from rol_privilegio where id_rol='$id_rol')");
			$nombre_rol = $web->datos ("select rol from rol where id_rol = '$id_rol' ");
			$nombre_rol = $nombre_rol[0][0];
			$web->smarty->assign('nombre_rol',$nombre_rol);
			$web->smarty->assign('id_rol',$id_rol);
			$web->smarty->assign('datos',$datos);
			$web->smarty->display('privilegios.html');
		}else
			header("Location:roles.php");
		
	
	}else{
		header('Location: ..');
	}
?>