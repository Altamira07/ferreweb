<?php 
include '../sistema.php';
	class ProveedorAPI extends Sistema
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
						$response = $this->getProveedor($id);
					}else{
						$response = $this->getProveedores();
					}
					echo json_encode($response,JSON_PRETTY_PRINT);
					
					break;	
				case 'POST':
					$this->newProveedor();
					break;
				case 'PUT':
					$this->updateProveedor();
					break;
				case 'DELETE':
					$this->deleteProveedor();
					break;
				default: 
			}
		}
		public function getProveedores()
		{
			return $this->datos("select * from proveedor");
		}
		public function getProveedor($id)
		{
			return $this->datos("select * from proveedor where id_proveedor = $id ");
		}
		public function newProveedor()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$this->insert($obj->nombre);
			$this->response(200,"success","new record");
		
		}
		public function insert ($nombre='')
		{
			$this->query("insert into proveedor(proveedor) value('$nombre')");
			return $this->rs;
		}
		public function response ($code=200,$status="",$message="")
		{
			http_response_code($code);
			$response = array("status"=>$status,"message"=>$message);
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
		public function updateProveedor()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$id = $_GET['id'];
			$this->update($id,$obj->nombre);
			$this->response(200,"success","new record");
		}
		public function update ($id,$nombre='')
		{
			$this->query("update proveedor set proveedor = '$nombre' where id_proveedor = $id ");
			return $this->rs;
		}
		public function deleteProveedor()
		{
			$id = $_GET['id'];
			$this->delete($id);
			$this->response(200,"success","new record");
		}
		public function delete($id)
		{
			$this->query("delete from proveedor where id_proveedor = $id ");
			return $this->rs;
		}
	}

 ?>