<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();


   $date=$_POST['date'];
    $response["success"] ='2';
   // $response["type"] ='users';
if($date=="")
  {
  	$alldata= mysql_query("select * from tbl_users"); 
  	
  }
  else
  {

	  $alldata= mysql_query("select * from tbl_users where created_At>'$date'"); 
  }

     while($row=mysql_fetch_assoc($alldata))
     {
     	
     		$response["success"] ='1';
     		
     		$response["id"][] =$row["id"];
     		$response["username"][] =$row["username"];
     		$response["password"][] =$row["password"];
     		$response["imei"][] =$row["location"];
     		$response["created_At"][] =$row["created_At"];
     		
     		
     	}
    
     
     
     

     echo json_encode($response);
    

?>