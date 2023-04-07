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
			
			$query = "select * from tbl_vehicles where id >$id or updated_At>'$updated_time' ORDER By id ASC  limit 2000 ";
			$result = mysqli_query($this->connection, $query);
			$response2['info']= array();
			$response["info"]= array();
			while ($row=mysqli_fetch_assoc($result))
			{
$id= $row['id'];
				
				$response['info']["id"] =''.$row["id"];
$response['info']["status"] =''.$row["status"];
     		$response['info']["Owner"] =''.$row["Owner"];
     		$response['info']["nationality"] =''.$row["nationality"];
     		$response['info']["mobile_no"] =''.$row["mobile_no"];
     		$response['info']["gender"] =''.$row["gender"];
     		$response['info']["issue_date"] =''.$row["issue_date"];
     		$response['info']["expire_date"] =''.$row["expire_date"];
     		$response['info']["plate_no"] =''.$row["plate_no"];
     		$response['info']["plate_type"] =''.$row["plate_type"];
     		$response['info']["engine_no"]=''.$row["engine_no"];
     		$response['info']["v_type"] =''.$row["v_type"];
     		$response['info']["color"] =''.$row["color"];
     		$response['info']["chassis_no"] =''.$row["chassis_no"];
     		$response['info']["model"] =''.$row["model"];
     		$response['info']["comments"] =''.$row["comments"];
     			$response['info']["updated_time"] =''.$row["updated_At"];
     		$response['info']["created_At"] =''.$row["created_At"];
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