<?php
	include('../sistema.php');
	$pagina = 0;
	if ($web->checkRol('administrador'))
	{
		if (isset($_POST) && !empty($_POST))
		{
			$email = $_POST['email'];
			$pass = $_POST['pass'];
			$pass = md5($pass);
			if (!empty($email) && !empty($pass) && !isset($_POST['editar']) && !$web->valCorreo($email)){ 
				$web->query("insert into usuario (email,contrasena) value ('$email','$pass')");
				$id = $web->getId($email);
				$web->query("insert into rol_usuario (id_rol,id) value ('4','$id')");
			}else{
				$web->query("update usuario set contrasena='$pass' where email='$email' ");
			}
		}
		if (isset($_GET) && !empty($_GET)) {
			$pagina = $_GET['pagina'];
			$pagina = ($pagina-1)*5;
		}	
		$datos = $web->datos("select email from usuario limit $pagina,5");
		$cantidad = $web->datos("select count(*) from usuario");
		$cantidad = intval($cantidad[0][0]/5);
		$web->smarty->assign('cantidad',$cantidad);
		$pagina = ($pagina/5) +1;
		$web->smarty->assign('pagina',$pagina);
		$web->smarty->assign('datos',$datos);
		$web->smarty->display('formulario_alta_usuarios.html');
	}else{
		header('Location: ..');
	}
?>
