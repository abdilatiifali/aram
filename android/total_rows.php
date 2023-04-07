<?php

error_reporting(0);
include("db_config.php");

// array for JSON response
$response = array();


  
  
 
  $alldata= mysql_query("select * from tbl_vehicles");  
  $alldata2= mysql_query("select * from tbl_receipts");  
     
	$response["vehicleRows"]=mysql_num_rows($alldata);
	$response["receiptRows"]=mysql_num_rows($alldata2);

     echo json_encode($response);
    

?>