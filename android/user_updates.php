<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();


   // $receiptNo=$_POST['receiptNo'];
    $response["success"] ='2';
 

$alldata= mysql_query("select * from tbl_users where created_At>'2016-05-10 05:00:06'");   

     while($row=mysql_fetch_assoc($alldata))
     {
     	
     		$response["success"] ='1';
     		
     		$response["id"][] =$row["id"];
     		$response["username"][] =$row["username"];
     		$response["password"][] =$row["password"];
     		$response["created_At"][] =$row["created_At"];
     		
     		
     	}
    
     
     
     

     echo json_encode($response);
    

?>