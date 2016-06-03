<?php 
	include ('sistema.php');
	$paramers = array('CityName'=>'Mexico', 'CountryName'=>'Mexico');
	try {
		$c = new nusoap_client('http://www.webservicex.net/globalweather.asmx?WSDL','wsdl');
		$result = $c->call('GetWeather',$paramers);
	} catch (Exception $ex) {
		echo "Fallo";
	}
	$result = $result['GetWeatherResult'];
	$result = str_replace('utf-16', 'utf-8', $result);
	print_r($result);
	$temp = new SimpleXMLElement($result);
	echo "Temperatura en mexico". $temp->Temperature;
?>