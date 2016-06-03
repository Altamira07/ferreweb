<?php
include ('sistema.php');

	try{
		$c = new nusoap_client('http://192.168.1.71/ferreweb/wsdl/marcas.wsdl','wsdl');
		$parameters = array('buscar' => 'm');
		$resultado = $c->call('obtenermarcas',$parameters);
	}catch(Exception $ex){
		echo "failed";
	}

	//Ya puedo procesar la informacion
	echo "<pre>";
	print_r($resultado);
	echo "</pre>";
	echo "Se encontraron:" .sizeof($resultado)."marcas";
 ?>