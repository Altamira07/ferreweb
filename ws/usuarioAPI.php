<?php 
include '../sistema.php';
	class UsuarioAPI extends Sistema
	{
		public function API()
		{
			header('Content-Type: application/json');
			$method = $_SERVER['REQUEST_METHOD'];
			switch ($method)
			{
				case 'GET':
					if (isset($_GET['id']))
					{
						$id = $_GET['id'];
						$response = $this->getUsuario($id);
					}else{
						$response = $this->getUsuarios();
					}
					echo json_encode($response,JSON_PRETTY_PRINT);
					
					break;	
				case 'POST':
					$this->newUsuario();
					break;
				case 'PUT':
					$this->updateUsuario();
					break;
				case 'DELETE':
					$this->deleteUsuario();
					break;
				default: 
			}
		}
		public function getUsuarios()
		{
			return $this->datos("select email,usuario from usuario");
		}
		public function getUsuario($email)
		{
			return $this->datos("select usuario from usuario where email = $email ");
		}
		public function newUsuario()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$this->insert($obj->email,$obj->pass);
			$this->response(200,"success","new record");
		
		}
		public function insert ($email='',$pass='')
		{
			$pass = md5($pass);
			$this->query("insert into usuario(email,contrasena) value('$email','$pass')");
			return $this->rs;
		}
		public function response ($code=200,$status="",$message="")
		{
			http_response_code($code);
			$response = array("status"=>$status,"message"=>$message);
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
		public function updateUsuario()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$id = $_GET['id'];
			$this->update($id,$obj->email);
			$this->response(200,"success","new record");
		}
		public function update ($id,$correo='')
		{
			$this->query("update usuario set email = '$correo' where usuario = '$id' ");
			return $this->rs;
		}
		public function deleteUsuario()
		{
			$id = $_GET['id'];
			$this->delete($id);
			$this->response(200,"success","new record");
		}
		public function delete($id)
		{
			$this->query("delete from usuario where usuario = '$id' ");
			return $this->rs;
		}
	}
 ?>