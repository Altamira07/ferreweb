<?php 
include '../sistema.php';
	class EmpleadoAPI extends Sistema
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
						$response = $this->getEmpleado($id);
					}else{
						$response = $this->getEmpleados();
					}
					echo json_encode($response,JSON_PRETTY_PRINT);
					
					break;	
				case 'POST':
					$this->newEmpleado();
					break;
				case 'PUT':
					$this->updateEmpleado();
					break;
				case 'DELETE':
					$this->deleteEmpleado();
					break;
				default: 
			}
		}
		public function getEmpleados()
		{
			return $this->datos("select * from empleado");
		}
		public function getEmpleado($id)
		{
			return $this->datos("select * from empleado where id_empleado = $id ");
		}
		public function newEmpleado()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$this->insert($obj->nombre);
			$this->response(200,"success","new record");
		
		}
		public function insert ($nombre='')
		{
			$this->query("insert into empleado(nombre) value('$nombre')");
			return $this->rs;
		}
		public function response ($code=200,$status="",$message="")
		{
			http_response_code($code);
			$response = array("status"=>$status,"message"=>$message);
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
		public function updateEmpleado()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$id = $_GET['id'];
			$this->update($id,$obj->nombre);
			$this->response(200,"success","new record");
		}
		public function update ($id,$nombre='')
		{
			$this->query("update empleado set nombre = '$nombre' where id_empleado = $id ");
			return $this->rs;
		}
		public function deleteEmpleado()
		{
			$id = $_GET['id'];
			$this->delete($id);
			$this->response(200,"success","new record");
		}
		public function delete($id)
		{
			$this->query("delete from empleado where id_empleado = $id ");
			return $this->rs;
		}
	}

 ?>