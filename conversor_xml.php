<?php
include('sistema.php');
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['carrito']) && !empty($_GET['carrito'])) {
    $xml = new SimpleXMLElement('<xml/>');
 $id = $_GET['id'];
 $carrito = $_GET['carrito'];
$datos=$web->datos("select ca.id_carrito, c.nombre,c.id_cliente,ca.fecha from 
                        cliente c inner join carrito ca on c.id_cliente=ca.id_cliente
                        where ca.id_cliente=$id ");
//print_r($array);
foreach ($datos as $key => $value) 
{
    //echo $array['c.nombre'];
    $carrito = $xml->addChild('Carrito');
    $carrito->addAttribute('carrito',''.$value['id_carrito'].'');  
    $carrito->addChild('Cliente', ''.$value['nombre'].'');
    $carrito->addChild('id', ''.$value['id_cliente'].'');
    $carrito->addChild('total', "1000");
    $carrito->addChild('fecha', ''.$value['fecha'].'');
    
}
$producto=$web->datos("select id, producto, precio, cantidad, subtotal from vistaCarritoUno where id_carrito=$carrito");
foreach ($producto as $key => $value) 
{
    $productos=$xml->addChild('producto');
    $productos->addAttribute('id_producto', ''.$value['id'].'');
    $productos->addChild('Nombre',''.$value['producto'].'');
    $productos->addChild('Precio',''.$value['precio'].'');
    $productos->addChild('Cantidad',''.$value['cantidad'].'');
    $productos->addChild('subtotal',''.$value['subtotal'].'');
}
Header('Content-type: text/xml');
print($xml->asXML());
}

/*id_carrito
id_cliente
fecha
productos*/
?>
