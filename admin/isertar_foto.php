<?php
    include("../sistema.php");
    $web->rol("empleado");
    if(isset($_POST['foto']) && isset($_POST['email'])){
        //transformar el email a id_empleado
        $id = $web->getIdEmpleado($_POST['email']);
        $web->guarda_foto_empleado($id_empleado,trim($_POST['foto']));
    }
?>
