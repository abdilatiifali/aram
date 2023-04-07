<?php
include_once 'connection.php';

class User5 {
		
		private $db;
		private $connection;
		
		function __construct() {
			$this -> db = new DB_Connection();
			$this -> connection = $this->db->getConnection();
		}
		
		public function does_reward_exist($id)
		{
			//Career Type Start;
			
			$query = "select * from tbl_users where id >$id  limit 2000 ";
			$result = mysqli_query($this->connection, $query);
			$response2['info']= array();
			$response["info"]= array();
			while ($row=mysqli_fetch_assoc($result))
			{
$id= $row['id'];
				
				$response['info']["id"] =''.$row["id"];
$response['info']["username"] =''.$row["username"];
     		$response['info']["password"] =''.$row["password"];
     		$response['info']["status"] =''.$row["status"];
     		$response['info']["imei"] =''.$row["location"];
     		$response['info']["created_At"] =''.$row["created_At"];
     		$response2['info'][] =$response['info'];
     		

			}

		


			
			echo json_encode($response2);

			
			
				


		}
		
	}
	
	
	$user5 = new User5();
	{
			
			$user5-> does_reward_exist($_GET['id']);
			
		}
		?>