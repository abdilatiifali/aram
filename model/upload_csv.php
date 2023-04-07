<?php 
// Config file
require_once('../inc/config.php');

// Upload csv of receipt section....

if(isset($_FILES['csv_file_for_receipts']))
{
	/*if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
         echo "<h1>" . "File ". $_FILES['csv_file_for_receipts']['name'] ." uploaded successfully." . "</h1>";
		 echo "<h2>Displaying contents:</h2>";
		 readfile($_FILES['csv_file_for_receipts']['tmp_name']);
	}*/
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
		
		$handle = fopen($_FILES['csv_file_for_receipts']['tmp_name'], "r");
		$counter = 1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if($counter > 1)
			{  
				//first check account record ...
				$check = mysqli_query($con, 'select id from tbl_account_list where acc_name LIKE "%'.$data[6].'%"');
				$check_data = @mysqli_fetch_object($check);
				if(empty($check_data))
				{
					$sql_acc = 'INSERT into tbl_account_list
							(acc_name, date, amount)
							VALUES
							("'.$data[6].'",
							 "'.date('Y-m-d').'",
							 "'.$data[5].'"
							)';
					@mysqli_query($con, $sql_acc);		 
				}
				// Now add data in receipt table
				$issue_date = date('Y-m-d', strtotime($data[2]));  
				 $expiry_date = date('Y-m-d', strtotime($data[3])); 
				// $birth_date = date('Y-m-d', strtotime($data[2]));
				$sql = "INSERT into tbl_receipts
						 (receipt_no, date, expire_date, received_from, amount, for_opt, vehicle_no, comments)
						 values
						 ('$data[1]','$issue_date','$expiry_date','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]')
						 ";
				//mysql_query($import) or die(mysql_error());
				mysqli_query($con, $sql);
				
			}
			$counter++;
			 
			//print_r($data);
			//echo '<br/>';
		}
		$_SESSION['success'] = 'CSV data has been added.';
		fclose($handle);
		header('location:../index.php');	
	}
	else
	{
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		header('location:../index.php');
	}

	
}
// Upload csv of vehicles section....
else if(isset($_FILES['csv_file_for_vehicles']))
{ 
	/*
	  Owner birth_day nationality birth_place mother_name mobile_no email address gender personal_id fees issue_date expire_date plate_no
		plate_type code vehicle origin weight engine_no v_type color hp chassis_no model cylinder comments issue_place
      */
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_vehicles']['tmp_name'])) {
		
		$handle = fopen($_FILES['csv_file_for_vehicles']['tmp_name'], "r");
		$counter = 1;
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if($counter > 1){
			    
				//echo '<pre>'; print_r($data); exit;
				// Now add data in receipt table
				 $issue_date = date('Y-m-d', strtotime($data[12]));  
				 $expiry_date = date('Y-m-d', strtotime($data[14])); 
				 $birth_date = date('Y-m-d', strtotime($data[2]));
				//$issue_data_formt = explode("/", $data[12]); 
			//	$issue_date = $issue_data_formt[2].'-'.$issue_data_formt[1].'-'.$issue_data_formt[0];
				
				$sql = "INSERT into tbl_vehicles
						 (Owner, birth_day, nationality, birth_place, mother_name, mobile_no, email, address, gender, personal_id, 
						  fees, issue_date, expire_date, plate_no, plate_type, code, vehicle, origin, weight, engine_no, 
						  v_type, color, hp, chassis_no, model, cylinder, comments, issue_place,updated_time ,status, passengers )
						 values
						 ('".addslashes($data[1])."','$birth_date','".addslashes($data[3])."','".addslashes($data[4])."','".addslashes($data[5])."','".addslashes($data[6])."','$data[7]','".addslashes($data[8])."', '$data[9]','$data[10]',
						  '$data[11]','$issue_date','$expiry_date','$data[15]','".addslashes($data[16])."','".addslashes($data[17])."','".addslashes($data[18])."','".addslashes($data[19])."','".addslashes($data[20])."','".addslashes($data[21])."',
						  '".addslashes($data[22])."','".addslashes($data[23])."','".addslashes($data[24])."','".addslashes($data[25])."','".addslashes($data[26])."','".addslashes($data[27])."','".addslashes($data[28])."','".addslashes($data[13])."', '".date('Y-m-d H:i:s')."', 1, '')
						 ";
				if(mysqli_query($con, $sql)){
					continue;
					 //echo $counter .' ==> New record entered.  Vehicle No = '.$data[15].' <br/>';
				}
				else{
					
					//echo '<br>   ERROR ! '. mysqli_error($con).'  , Vehicle no = '.$data[15].' <br/>';
					continue;
				}
				//if($counter == 100) exit;
				//  Owner Name ,  Birth date , Nationality , Birth Place, Mother Name , Mobile , Email, Address , Gender , Personal Id
				//  Fees , Issue Date, Issue Place,  Expire Date , Plate No, Plate Type, Code, Vehicle, Origin, Weight, Engine No
				// V Type, Color , HP, Chassis No, Model, Cylinder, Comments
			}
			$counter++; 
			//print_r($data);
			//echo '<br/>';
		}
		$_SESSION['success'] = 'CSV data has been added.';
		fclose($handle);
		header('location:../vehicles.php');	
	}
	else
	{
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		header('location:../vehicles.php');
	}

	
}
else
{
    $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php');
}



?>