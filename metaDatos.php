<?php
	$objeto = array("Hola"=>1213,"fgasd"=>'a',"xxx"=>'satanas');
	//A partir de esta linea no se puede cambiar nada
	echo "<table>";
	foreach ($objeto as $llave => $valor)
	 {	
	 	echo "
			<tr>
				<th>$llave</th>
				<td>$valor</td>
			</tr>
	 	";
	 }
	 echo "</table>";
	
?>