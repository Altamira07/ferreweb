<?php
	session_start();
	include ('config.php');

	//Definimos las rutas absolutas
	//define ('PATHAPP','/var/www/html/ferreweb/');
	define('PATHLIB', PATHAPP.LIB);
	//Incluimos a librerias
	include (PATHLIB.'adodb/adodb.inc.php');
	include (PATHLIB.'smarty/Smarty.class.php');
	include (PATHLIB.'phpmailer/PHPMailerAutoload.php');
	include(PATHLIB.'html2pdf/vendor/autoload.php');
	include(PATHLIB.'nusoap/nusoap.php');

	//Clases del sistema
	class Conexion
	{
		function Conectar()
		{
			$this->server =DB_DBMS;
			$this->host =DB_HOST;
			$this->userdb=DB_USER;
			$this->passdb=DB_PASS;
			$this->database=DB_NAME;
			$this->DB=&ADONewConnection($this->server);
			$this->DB->pConnect($this->host,$this->userdb,$this->passdb,$this->database);
		}
	}
	class Sistema extends Conexion
	{
		var $rs='';
		var $query='';
		public $smarty ;

		//Constructor de la clase
		function __construct ()
		{
			parent::Conectar();
			$this->smarty = new Smarty ();
		}
		//Variables
		function query($query)
		{
			$this->query = $query;
			$this->rs  = $this->DB->Execute($this->query);
			if ($this->DB->ErrorMsg())
				$this->error("Valio mae".$this->DB->ErrorMsg());

		}
		public function htmlApdf($contenido,$nombre)
		{
			    $html2pdf = new HTML2PDF('P', 'A4', 'fr');
		//      $html2pdf->setModeDebug();
		        $html2pdf->setDefaultFont('Arial');
		        $html2pdf->writeHTML($contenido, isset($_GET['vuehtml']));
		        $html2pdf->Output($nombre);
		    
		}
		public function productosPDF()
		{
			try{
				$html2pdf = new HTML2PDF('P','A4','fr');
				$html2pdf->setDefaultFont('Arial');
		        $datos = $this->datos("select id,nombre,precio from producto");
		        $this->smarty->assign('datos',$datos);
		        $contenido = $this->smarty->fetch('productosPDF.html');
		        $html2pdf->WriteHTML($contenido);
				$html2pdf->Output('productos.pdf');	
			}catch (Exception$ex){}
		
		}
		function getId ($email)
		{
			$id = $this->datos("select usuario from usuario where email='$email' ");
			return $id[0][0];
		}
		function getIdCliente ($email)
		{
			$id = $this->datos("select id_cliente from usuario where email='$email' ");
			return $id[0][0];
		}
		public function guarda_foto_empleado($id,$foto){
				$encoded = $foto;
			    $encoded = str_replace(' ', '+', $encoded);
			    $encoded = str_replace('data:image/jpeg;base64,', '', $encoded);
			    $image = base64_decode($encoded);
			    //para mysql
			    $image = mysql_escape_string($image);
			    //par postgres
			    //$image = pg_escape_bytea($image); y -> '{$image}' 
			    $sql = " 		 UPDATE  empleado 
			                     SET foto = '$image' 
			                     WHERE id_empleado = $id "; 
			    //echo $sql;
				$this->query($sql);

		}
		function getIdEmpleado ()
		{

			return $_SESSION['empleado'];
		}
		function getIdPrivilegio ($privilegio)//Regresa la id del privilegio
		{
			$id = $this->datos("select id_privilegio from privilegio where privilegio='$privilegio'");
			return $id[0][0];
		}
		function existePrivilegio ($privilegio) //Regresa verdadero si existe, falso si no
		{
			$dat = $this->datos("select * from privilegio where privilegio = '$privilegio'");
			if (empty($dat)) {
				return false;
			}else
				return true;
		}
		function datos($query)
		{
			$this->query($query);
			$datos = $this->DB->GetAll($query);
			return $datos;
		}

		function combo ($query,$name)
		{
			$this->query($query);
			$campos = $this->DB->GetAll($query);
			$this->smarty->assign('name',$name);
			$this->smarty->assign('campos',$campos);
			return $this->smarty->fetch('combo.html');
		}
		function comboSelect ($query,$name,$seleccion)
		{
			$this->query($query);
			$campos = $this->DB->GetAll($query);
			$this->smarty->assign('name',$name);
			$this->smarty->assign('seleccion',$seleccion);
			$this->smarty->assign('campos',$campos);
			return $this->smarty->fetch('combo.html');
		}
		function mostrarTabla ($query)
		{
			$this->DB->SetFetchMode(ADODB_FETCH_ASSOC);
			$this->query($query);
			$cantcolumnas = $this->rs->_numOfFields;
			$cantregistros = $this->rs->_numOfRows;
			try{
				$nombcolumnas = array_keys($this->rs->fields);
				$datos = $this->DB->GetAll($query);
			}catch (Exception $e){}
			//print_r($nombcolumnas);
			//print_r($datos);
			$this->smarty();
			$this->smarty->assign('cantcolumnas', $cantcolumnas);
			$this->smarty->assign('cantregistros', $cantregistros);
			$this->smarty->assign('nombcolumnas', $nombcolumnas);
			$this->smarty->assign('datos', $datos);

			return $this->smarty->fetch('mostrartabla.html');

		}
		function smarty ()
		{
			$this->smarty->setTemplateDir(PATHAPP.TEMPLATES);
			$this->smarty->setCompileDir(PATHAPP.TEMPLATES_C);
			$this->smarty->setCacheDir(PATHAPP.CACHE);
			$this->smarty->setConfigDir(PATHAPP.CONFIGS);
			$this->smarty->debugging = false;
			$this->smarty->caching = true;
			$this->smarty->cache_lifetime=0;

		}
		function error($mensaje)
		{
			$this->smarty();
			$this->smarty->assign('mensaje',$mensaje);
			$this->smarty->display('error.html');
		}
		
		function mostrar ()
		{
			$this->smarty();
			$this->smarty->assign('mensaje',$mensaje);
			$this->smarty->display('mostrar.html');
		}
		function displayAdmin ($pagina)
		{
			$this->smarty();
			$this->smarty->display($pagina);
		}
		function login($email, $pass)
    	{
	        $pass = md5($pass);
	        $bandera = false;
	        $arrayRol = array ();
	        $arrayPrivilegio = array();
	        $datos = $this->datos("select * from usuario where email ='$email' and contrasena = '$pass'");
	        if (empty($datos)) {
	        	$datos = $this->datos("select * from usuario where email ='$email' and clave = '$pass'");
	        	$bandera = true;
	        }
	        if ($this->valCorreo($email)){
	            $this->error("formato de correo electronico invalido");
	        }
	        if (!empty($datos))
	        {
	        	
	        	$roles = $this->DB->GetALL("select rol from rol where id_rol in (select id_rol from rol_usuario where id in (select usuario from usuario where email = '$email' ))");
		        foreach ($roles as $key => $value)
		            	array_push($arrayRol, $value['0']);
		        $privilegios = $this->DB->GetALL("select privilegio from privilegio where id_privilegio in ( select id_privilegio from rol_privilegio where id_rol in ( select id_rol from rol where id_rol in (select id_rol from rol_usuario where id in (select usuario from usuario where email = '$email' ))))");
		        foreach ($privilegios as $key => $value)
		            	array_push($arrayPrivilegio, $value['0']);
		        $dat = $this->datos("select id_cliente,id_empleado from usuario where email = '$email' ");
		            // Voy a crear las variables de sesion
		        $_SESSION['email'] = $email;
		        $_SESSION['logueado'] = true;
		        $_SESSION['roles'] = $arrayRol;

		        $_SESSION['privilegios'] = $arrayPrivilegio;
		        if ($bandera) {
		        	foreach ($_SESSION['roles'] as $key => $value) {
		        		if ($value==="Cliente") {
		        				header('Location:cliente');
		        			}else
		        				header('Location:admin/reestablecer.php');
		        	}
		        	$_SESSION['reestablecer'] = true;
		        }else{
					foreach ($_SESSION['roles'] as $key => $value) {
		        		if ($value==="Cliente") {
		        				$id = $dat[0][0];
		        				$_SESSION['cliente'] = $id;
		        				header('Location:cliente');
		        			}else{
		        				$id = $dat[0][1];
		        				$_SESSION['empleado'] = $id;
		        				header('Location:admin');
		        			}
		        	}
		        		
		        	$_SESSION['reestablecer'] = false; 
		        }
		        
		    }else{
            	$this->error("Usuario o contraseña incorrecto");
        	}
    	}

	    function checkRol($rol){
	    	if ($_SESSION['logueado']){
	    		if (!in_array($rol, $_SESSION['roles']))
	    			return false;
	    	}
	    	else
	    		return false;
	    	return true;
	    }

	    function checkPrivileges($privilege)
	    {
	        if ($_SESSION['logueado']){
	            if(!in_array($privilege, $_SESSION['privilegios']))
	        		return false;
	        }
	        else
	    		return false;
	    	return true;
	    }
	    function valCorreo ($correo){
			if (filter_var($correo, FILTER_VALIDATE_EMAIL)){
	            return false;
	        }
	        return true;
	    }
	    public function logout()
	    {
	    	unset($_SESSION);
	        session_destroy();
	        header('Location: ..');
	    }
			public function geneClave ()
			{
				$valor = rand(1,100000) * rand(1,100000);
				$clave = MD5($valor);
				return substr($clave,0,8);
			}
			public function enviCorreo ($destino,$nombre,$asunto,$mensaje)
			{
				$mail = new PHPMailer(); // the true param means it will throw exceptions on errors, which we need to catch
				$mail->IsSMTP(); // telling the class to use SMTP

				try {
					//$mail->SMTPDebug  = MAIL_SMTPDEBUG;                     // enables SMTP debug information (for testing)
					$mail->SMTPAuth   = MAIL_SMTPAUTH;                  // enable SMTP authentication
					$mail->SMTPSecure = MAIL_SMTPSECURE;                 // sets the prefix to the servier
					$mail->Host       = MAIL_HOST;      // sets GMAIL as the SMTP server
					$mail->Port       = MAIL_PORT;                   // set the SMTP port for the GMAIL server
					$mail->Username   = MAIL_USERNAME;  // GMAIL username
					$mail->Password   = MAIL_PASS;            // GMAIL password
					//Por si lo ocupo $mail->AddReplyTo('name@yourdomain.com', 'First Last');
					$mail->AddAddress($destino, $nombre);
					$mail->SetFrom(MAIL_USERNAME, 'ferreweb');
					$mail->Subject = $asunto;
					$mail->AltBody = $mensaje; // optional - MsgHTML will create an alternate automatically
					$mail->MsgHTML($mensaje);
					// Por si algun dia lo ocupo$mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
					$mail->Send();
				} catch (phpmailerException $e) {
					echo $e->errorMessage(); //Pretty error messages from PHPMailer
				} catch (Exception $e) {
					echo $e->getMessage(); //Boring error messages from anything else!
				}
			}
			public function dolar_peso()
			{
				$valorActual = $this->datos("select * from divisa where nombre='dolar'");
				$valorActual = $valorActual[0];
				$datos =array();
				$fecha = getdate();
				$fecha = $fecha['year']."-".$fecha['mon']."-".$fecha['mday'];
				
				if($valorActual['fecha']===$fecha)
				{
					array_push($datos,$valorActual['valor'],$valorActual['fecha']);
				}else{
					$valorNuevo = $this->dolar();
					$dolar = round($valorNuevo['dolar'],2);
					$fecha = $valorNuevo['fecha'];
					array_push($datos, $dolar,$fecha);
					$this->query("update divisa set valor= $dolar , fecha = '$fecha' where tipo = 1 ");
				}
				return $datos;
			}	
			private function dolar()
			{
				$de = 'USD';
				$a = 'MXN';
				$url = 'http://finance.yahoo.com/d/quotes.csv?f=l1d1t1&s='.$de.$a.'=X';
				$handle = fopen($url, 'r');
				if ($handle) {
					$r = fgetcsv($handle);
					fclose($handle);
				}
				$dolar = array('dolar' => $r[0], 'fecha'=>$r[1],'hora'=>$r[2]);
				return $dolar;
			}
	}
$web = new Sistema;
//$web->smarty();
?>
