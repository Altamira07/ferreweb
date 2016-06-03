<?php
include("../sistema.php");
$web->rol("empleado");
if(isset($_GET['id'])){
	$id=$_GET['id'];
	$web->query("select * from empleado where id_empleado=$id");
 	$arr = $web->rs->GetArray();
 	header("Content-type: image/png");
 	echo $arr[0]['foto'];
}
?>