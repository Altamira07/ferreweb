<?php 
	if(!extension_loaded("soap")){
		dl("php_soap.dll");
	}
	ini_set("soap.wsdl_cache_enable","0");
	$server = new SoapServer("marcas.wsdl");

	function obtenermarcas($criteria){
		include("../sistema.php");
		$criteria = htmlentities($criteria);
		return $web->datos("select id_marca, marca from marca where marca like '%$criteria%'");
	}

	$server->AddFunction("obtenermarcas");
	$server->handle();
 ?>