<?php
include_once 'connection.php';

class User5 {
		
		private $db;
		private $connection;
		
		function __construct() {
			$this -> db = new DB_Connection();
			$this -> connection = $this->db->getConnection();
		}
		
		public function does_reward_exist($id,$updated_time)
		{
			//Career Type Start;
			
			$query = "select * from tbl_driver_detail where id >$id or updated_At>'$updated_time' ORDER By id ASC limit 2000 ";
			$result = mysqli_query($this->connection, $query);
			$response2['info']= array();
			$response["info"]= array();
			while ($row=mysqli_fetch_assoc($result))
			{
$id= $row['id'];
				
				$response['info']["id"] =$row["id"];
     		$response['info']["issue_place"] ="".$row["issue_place"];
     		$response['info']["licence_no"] ="".$row["licence_no"];
     		$response['info']["issue_date"]="".$row["issue_date"];
     		$response['info']["expiry_date"] ="".$row["expiry_date"];
     		
     		
     		
     		$response['info']["vehicle_types"] ="".$row["vehicle_types"];
     		$response['info']["name"] ="".$row["name"];
     		
     		
     		$response['info']["gender"] ="".$row["gender"];
     		
     		$response['info']["date_birth"] ="".$row["date_birth"];
     		$response['info']["nationality"] ="".$row["nationality"];
     		$response['info']["comments"] ="".$row["contact_no"];
$response['info']["updated_time"]="".$row["updated_At"];
$response['info']["status"]="".$row["status"];
     		$response['info']["created_At"]="".$row["created_At"];
     		$response2['info'][] =$response['info'];
     		//mysqli_query($this->connection, "Update tbl_vehicles set status = 0 where id = $id");

			}

		


			
			echo json_encode($response2);

			
			
				


		}
		
	}
	
	
	$user5 = new User5();
	{
			
			$user5-> does_reward_exist($_GET['id'],$_GET['updated_time']);
			
		}
		?>