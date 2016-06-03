<?php
	include('../sistema.php');
	if ($web->checkRol('administrador'))
	{
		if(isset($_SESSION['reestablecer']) &&$_SESSION['reestablecer'])
		{
			$web->smarty->display('reestablecer.html');
		}
		else{	
			header('Location:index.php');
		} 
	}else{
		header('Location: ..');
	}
?>