<?php
include_once 'connection.php';

class User5 {
		
		private $db;
		private $connection;
		
		function __construct() {
			$this -> db = new DB_Connection();
			$this -> connection = $this->db->getConnection();
		}
		
		public function does_reward_exist()
		{
			//Career Type Start;
			
			$query = "Select * from tbl_driver_detail";
			$result = mysqli_query($this->connection, $query);
			$response2['info']= array();
			$response['info']= array();
			while ($row=mysqli_fetch_assoc($result))
			{
				$response['info']["id"] ="".$row["id"];
				
     		$response['info']["issue_place"] ="".$row["issue_place"];
     		$response['info']["licence_no"] ="".$row["licence_no"];
     		$response['info']["issue_date"] ="".$row["issue_date"];
     		$response['info']["expiry_date"] ="".$row["expiry_date"];
     		
     		
     		
     		$response['info']["vehicle_types"] ="".$row["vehicle_types"];
     		$response['info']["name"] ="".$row["name"];
     		
     		
     		$response['info']["gender"] ="".$row["gender"];
     		
     		$response['info']["date_birth"] ="".$row["date_birth"];
     		$response['info']["nationality"] ="".$row["nationality"];
     		$response['info']["comments"] ="".$row["contact_no"];
     		$response['info']["created_At"] ="".$row["created_At"];
$response2['info'][] =$response['info'];
			}

		
			
			echo json_encode($response2);
				


		}
		
	}
	
	
	$user5 = new User5();
	{
			
			$user5-> does_reward_exist();
			
		}
		?>