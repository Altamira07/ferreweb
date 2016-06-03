<?php 
	if(!extension_loaded("soap")){
		dl("php_soap.dll");
	}
	ini_set("soap.wsdl_cache_enable","0");
	$server = new SoapServer("productos.wsdl");

	function obtenerproductos($criteria){
		include("../sistema.php");
		$criteria = htmlentities($criteria);
		return $web->datos("select id, nombre from producto where marca like '%$criteria%'");
	}

	$server->AddFunction("obtenerproductos");
	$server->handle();
 ?>