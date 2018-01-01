<?php
class DbCrud
{
	private $db,$table;
	public function __construct($conn, $table)
	{
		$this->db = $conn;
		$this->table = $table;
		try
		{
			$fetch = $this->db->prepare("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name=:table");
			$fetch->bindParam(":table", $this->table);
			$fetch->execute();	
		}
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}	
	}

	public function Save($values)
	{
		
		try 
		{
			$qMark = "";
			$data = array();
			foreach ($values as $key => $value) {
				$qMark .= "?,";
				array_push($data, $value);
			}
			$qMark = substr($qMark,0,-1);
			$saving = $this->db->prepare("INSERT INTO ".$this->table." VALUES(".$qMark.")");
			return $saving->execute($data);
			
		} 
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}	
		
	}

	public function Update($values)
	{

		
		try 
		{
			$column = "";
			$data = array();
			foreach ($values as $key => $value) {
				array_push($data, $value);
				$column .= '`'.$key.'`=?,';
			}
			$column = substr($column,0,-1);
			$updating = $this->db->prepare("UPDATE ".$this->table." SET ".$column." WHERE Id=".$values->Id);
			return $updating->execute($data);
			
		} 
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}	
	}

	public function Delete($id)
	{
		try 
		{
			
			$deleting = $this->db->prepare("DELETE FROM ".$this->table." WHERE Id=:Id");
			$deleting->bindParam(":Id", $id);
			return $deleting->execute();
		} 
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}	
	}

	public function showDetail($id)
	{
		try 
		{
			$fetching = $this->db->prepare("SELECT * FROM ".$this->table." WHERE Id=:id");
			$fetching->bindParam(":id", $id);
			$fetching->execute();
			$data = array();
			while ($row = $fetching->fetch(PDO::FETCH_ASSOC)) {
				foreach ($row as $key => $value) {
					$data[$key] = $value;
				}
			}
			return $data;
		} 
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}		
	}

	public function showAll()
	{

		try 
		{
			
		 	$fetching = $this->db->prepare("SELECT * FROM ".$this->table);
			$fetching->execute();
			$data = array();

			$no=0;
			while ($rows = $fetching->fetch(PDO::FETCH_ASSOC)) {
				$_data = array();
				foreach ($rows as $row => $value) {
		  			$_data[$row] =  $value;
		  		} 
		  		array_push($data, $_data);
		 	}
		 	return $data;
		} 
		catch (PDOException $e) 
		{
			echo("Error ! : ". $e->getMessage());
		}	
	}
}
?>