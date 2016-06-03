<?php
  include ('sistema.php');
  //Aqui voy a programar la recepcion de un formulario o el envio de un formulario que me encie el correo electronico mediante una casilla de texto
  $clave = $web->geneClave ();
  //consutar la la BD para saber si el correo es valido, y tratar de obtener el nombre de la persona
  $mensaje = "";
  $correo = "";
  if (isset($_REQUEST) && !empty($_REQUEST['email'])) {
    $mail = $_REQUEST['email'];
    //Validacion del correo
    $datos = $web->datos("select email from usuario where email = '$mail'");
    $correo = $datos[0];
  }else{
    $web->smarty->assign ('mensaje',"Debes especificar el correo");
    $web->smarty->display('error.html');
    die();
  }
  if (!empty($correo)) 
  {
    $mensaje = "Hola estimado usuario de ferreweb con esta clave va a poder ingresar al sistema $clave" ;
    $web->enviCorreo ($mail,"Usuario","Recuperacion de contraseña",$mensaje);
    //Aqui voy a insertar temporalmente la contraseña temporalmente encriptdad, y no voy a sobreescribir
    $clave = md5 ($clave);
    //Aqui voy a generar un insert para guardar la contraseña temporal encriptada en la base de datos
    $web->query ("update usuario set clave = '$clave' where email = '$mail'");
  }else{
    $web->smarty->assign ('mensaje',"El correo no existe");
    $web->smarty->display('error.html');
    die();
  }
    $web->smarty->assign('mensaje',"Se envio un correo con tu nueva clave");
    $web->smarty->display('mensaje.html');
  
  
?>
