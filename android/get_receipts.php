<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();


    $date=$_POST['date'];
    $response["success"] ='2';
  // $response["type"] ='receipts';
  if($date=="")
  {
  	$alldata= mysql_query("select * from tbl_receipts"); 
  	
  }
  else
  {

	  $alldata= mysql_query("select * from tbl_receipts where created_At>'$date'"); 
  }
  

     while($row=mysql_fetch_assoc($alldata))
     {
     	
     		$response["success"] ='1';
     		
     		$response["id"][] =$row["id"];
     		$response["receipt_no"][] =$row["receipt_no"];
     		$response["date"][] =$row["date"];
     		$response["expire_date"][] =$row["expire_date"];
     		$response["received_from"][] =$row["received_from"];
     		$response["amount"][] =$row["amount"];
     		$response["for_opt"][] =$row["for_opt"];
     		
     		$response["vehicle_no"][] =$row["vehicle_no"];
     		$response["comments"][] =$row["comments"];
     		
     		$response["created_At"][] =$row["created_At"];
     		
     		
     	}
    
     
     
     

     echo json_encode($response);
    

?>