<?php 
	include ('../sistema.php');
	$pagina = 0;
	if ($web->checkRol('administrador'))
	{
		if (isset($_REQUEST) && !empty($_REQUEST))
		{
			if (isset($_REQUEST['rol'])) {
				$rol = $_REQUEST['rol'];
				$web->query("insert into rol(rol) value ('$rol')");
			}elseif (isset($_REQUEST['eliminar'])) {
				$id = $_REQUEST['eliminar'];
				$web->query("delete from rol where id_rol='$id' ");
			}
			
		}
		if (isset($_GET['pagina']) && !empty($_GET['pagina'])) {
			$pagina = $_GET['pagina'];
			$pagina = ($pagina-1)*5;
		}
		$datos = $web->datos("select * from rol limit $pagina,5");
		$cantidad = $web->datos ("select count(*) from rol ");
		$cantidad = intval($cantidad[0][0]/5);
		$web->smarty->assign('cantidad',$cantidad);
		$pagina = ($pagina/5) +1;
		$web->smarty->assign('pagina',$pagina);
		$web->smarty->assign('datos',$datos);
		$web->smarty->display('roles.html');	
	}else{
		header('Location: ..');
	}
?>