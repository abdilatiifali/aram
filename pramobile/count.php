<?php

include_once 'connection.php';
	
	class User {
		
		private $db;
		private $connection;
		
		function __construct() {
			$this -> db = new DB_Connection();
			$this -> connection = $this->db->getConnection();
		}
		
		public function does_user_exist($id,$vTime,$did,$dTime,$uid) 
		{
			$query = "select COUNT(id) as total from tbl_vehicles where id > $id or updated_At>'$vTime' ";
			$result = mysqli_query($this->connection, $query);
$res = mysqli_fetch_assoc($result);
$total1= $res['total'];
$query = "select COUNT(id) as total from tbl_users where id > $uid";
			$result = mysqli_query($this->connection, $query);
$res = mysqli_fetch_assoc($result);
$total2= $res['total'];

$query = "select COUNT(id) as total from tbl_driver_detail where id > $did or updated_At>'$dTime' ";
			$result = mysqli_query($this->connection, $query);
$res = mysqli_fetch_assoc($result);
$total4= $res['total'];
$total3 = $total1."-".$total2."-".$total4;
			$response3['total']= array();

$response3['total']=$total3;
			
			echo json_encode($response3);
				mysqli_close($this -> connection);}
			}
	
	$user = new User();
	$user-> does_user_exist($_GET['id'],$_GET['vTime'],$_GET['did'],$_GET['dTime'],$_GET['uid']);
	
?>