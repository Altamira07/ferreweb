<?php 
	include '../sistema.php';
	class ProductoAPI extends Sistema
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
						$response = $this->getProducto($id);
					}else{
						$response = $this->getProductos();
					}
					echo json_encode($response,JSON_PRETTY_PRINT);
					
					break;	
				case 'POST':
					$this->newPorducto();
					break;
				case 'PUT':
					$this->updateProducto();
					break;
				case 'DELETE':
					$this->deleteProducto();
					break;
				default: 
			}
		}
		public function getProductos()
		{
			return $this->datos("select * from producto");
		}
		public function getProducto($id)
		{
			return $this->datos("select * from producto where id = $id ");
		}
		public function newPorducto()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$this->insert($obj->nombre);
			$this->response(200,"success","new record");
		
		}
		public function insert ($nombre='')
		{
			$this->query("insert into producto(nombre) values('$nombre')");
			return $this->rs;
		}
		public function response ($code=200,$status="",$message="")
		{
			http_response_code($code);
			$response = array("status"=>$status,"message"=>$message);
			echo json_encode($response,JSON_PRETTY_PRINT);
		}
		public function updateProducto()
		{
			$obj = json_decode(file_get_contents('php://input'));
			$objArr = (array)$obj;
			$id = $_GET['id'];
			$this->update($id,$obj->nombre);
			$this->response(200,"success","new record");
		}
		public function update ($id,$nombre='')
		{
			$this->query("update producto set nombre = '$nombre' where id = $id ");
			return $this->rs;
		}
		public function deleteProducto()
		{
			$id = $_GET['id'];
			$this->delete($id);
			$this->response(200,"success","new record");
		}
		public function delete($id)
		{
			$this->query("delete from producto where id = $id ");
			return $this->rs;
		}
	}
?>