<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();


   $date=$_POST['date'];
    $response["success"] ='2';
  // $response["type"] ='vehicles';
  
  if($date=="")
  {
 $alldata= mysql_query("select id,Owner,nationality,mobile_no,gender,issue_date,expire_date,plate_no,plate_type,engine_no,v_type,color,chassis_no,model,comments,created_At from tbl_vehicles"); 
  	
  }
  else
  {

	  $alldata= mysql_query("select * from tbl_vehicles where created_At>'$date'"); 
  }
  
 

     while($row=mysql_fetch_assoc($alldata))
     {
     	
     		$response["success"] ='1';
     		
     		$response["id"][] =$row["id"];
     		$response["Owner"][] =$row["Owner"];
     		//$response["birth_day"][] =$row["birth_day"];
     		$response["nationality"][] =$row["nationality"];
     		//$response["birth_place"][] =$row["birth_place"];
     		//$response["mother_name"][] =$row["mother_name"];
     		$response["mobile_no"][] =$row["mobile_no"];
     		//$response["address"][] =$row["address"];
     		//$response["email"][] =$row["email"];
     		$response["gender"][] =$row["gender"];
     		//$response["personal_id"][] =$row["personal_id"];
     		//$response["fees"][] =$row["fees"];
     		$response["issue_date"][] =$row["issue_date"];
     		$response["expire_date"][] =$row["expire_date"];
     		$response["plate_no"][] =$row["plate_no"];
     		$response["plate_type"][] =$row["plate_type"];
     		//$response["code"][] =$row["code"];
     		//$response["origin"][] =$row["origin"];
     		$response["engine_no"][] =$row["engine_no"];
     		$response["v_type"][] =$row["v_type"];
     		$response["color"][] =$row["color"];
     		//$response["hp"][] =$row["hp"];
     		$response["chassis_no"][] =$row["chassis_no"];
     		$response["model"][] =$row["model"];
     	//	$response["cylinder"][] =$row["cylinder"];
     		$response["comments"][] =$row["comments"];
     	//	$response["issue_place"][] =$row["issue_place"];
     		
     		$response["created_At"][] =$row["created_At"];
     		
     		
     	}
    
     
     
     

     echo json_encode($response);
    

?>