<?php
	include ('sistema.php');
	$table = $web->mostrarTable ("select * from producto");
	$web->htmlApdf($table,"Holis");
?>