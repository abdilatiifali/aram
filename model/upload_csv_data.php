<?php 
// Config file
require_once('../inc/config.php');

// Upload csv of receipt section....

if(isset($_FILES['csv_file_for_vehicle_types']))
{
	/*if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
         echo "<h1>" . "File ". $_FILES['csv_file_for_receipts']['name'] ." uploaded successfully." . "</h1>";
		 echo "<h2>Displaying contents:</h2>";
		 readfile($_FILES['csv_file_for_receipts']['tmp_name']);
	}*/
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_vehicle_types']['tmp_name'])) {
		
		$handle = fopen($_FILES['csv_file_for_vehicle_types']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			// Now add data in receipt table
			$sql = "INSERT into tbl_vehicle_types
					 (vehicle_type)
					 values
					 ('$data[0]')
					 ";
			//mysql_query($import) or die(mysql_error());
			mysqli_query($con, $sql);
			 
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
		header('location:../index.php');
	}

	
}
else if(isset($_FILES['csv_file_for_vehicle_plate_code']))
{
	/*if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
         echo "<h1>" . "File ". $_FILES['csv_file_for_receipts']['name'] ." uploaded successfully." . "</h1>";
		 echo "<h2>Displaying contents:</h2>";
		 readfile($_FILES['csv_file_for_receipts']['tmp_name']);
	}*/
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_vehicle_plate_code']['tmp_name'])) {
		$counter = 1;
		$handle = fopen($_FILES['csv_file_for_vehicle_plate_code']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($counter > 1)
			{
			// Now add data in receipt table
				$sql = "INSERT into tbl_vehicle_plate_codes
						 (vehicle_plate_code)
						 values
						 ('$data[0]')
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
		header('location:../vehicles.php');	
	}
	else
	{
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		header('location:../index.php');
	}

	
}
else if(isset($_FILES['csv_file_for_master_fine']))
{
	/*if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
         echo "<h1>" . "File ". $_FILES['csv_file_for_receipts']['name'] ." uploaded successfully." . "</h1>";
		 echo "<h2>Displaying contents:</h2>";
		 readfile($_FILES['csv_file_for_receipts']['tmp_name']);
	}*/
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_master_fine']['tmp_name'])) {
		$counter = 1;
		$handle = fopen($_FILES['csv_file_for_master_fine']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			if($counter > 1)
			{
			// Now add data in receipt table
				$sql = "INSERT into tbl_fine_master
						 (fine_code, comments, amount, black_point, prison, vehicle_confiscation, status)
						 values
						 ('$data[0]','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]', 2)
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
		header('location:../traffic.php');	
	}
	else
	{
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		header('location:../index.php');
	}

	
} 
else if(isset($_FILES['csv_file_for_licence']))
{
	/*if (is_uploaded_file($_FILES['csv_file_for_receipts']['tmp_name'])) {
         echo "<h1>" . "File ". $_FILES['csv_file_for_receipts']['name'] ." uploaded successfully." . "</h1>";
		 echo "<h2>Displaying contents:</h2>";
		 readfile($_FILES['csv_file_for_receipts']['tmp_name']);
	}*/
	//Import uploaded file to Database
	if (is_uploaded_file($_FILES['csv_file_for_licence']['tmp_name'])) {
		$counter = 1;
		$handle = fopen($_FILES['csv_file_for_licence']['tmp_name'], "r");
		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			
			if($counter > 1)
			{
			     echo '<pre>'; print_r($data); //exit;
				 $issue_date = convert_date($data[6]);  
				 $expiry_date = convert_date($data[7]); 
				 $birth_date = convert_date($data[10]);
				 $gender = $data[8] == 'Lab' ? 1 : 2;
				// Now add data in receipt table
				$sql = "INSERT into tbl_driver_detail
						 (receipt_no, fee, name, licence_no, issue_place, issue_date, expiry_date, gender, mother_name, 
					 	  date_birth, birth_place, nationality, address, email, contact_no, personal_id, vehicle_types, 
						  comments, updated_time, status)
						 values
						 ('$data[1]','$data[2]','".addslashes($data[3])."','$data[4]','".addslashes($data[5])."', '$issue_date' , '$expiry_date', '$gender', '".addslashes($data[9])."',
						  '$birth_date','".addslashes($data[11])."','".addslashes($data[12])."','".addslashes($data[13])."','$data[14]', '$data[15]', '$data[16]', '$data[17]', 
						  '".addslashes($data[18])."', '".date('Y-m-d')."',1
						 )
						 ";
				//mysql_query($import) or die(mysql_error());
				mysqli_query($con, $sql);
				echo mysqli_error($con); echo '<br/>';
			}
			$counter++;
			 
			//print_r($data);
			//echo '<br/>';
		}
		$_SESSION['success'] = 'CSV data has been added.';
		fclose($handle);
		header('location:../licence.php');	
	}
	else
	{
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		header('location:../licence.php');
	}

	
}
else
{
    $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php');
}

function convert_date($date)
 {
	$date_array = explode("/",$date);
	if(!empty($date_array) && isset($date_array[2]) && isset($date_array[1]) && isset($date_array[0]))
		$new_date = $date_array[2]."-".$date_array[1]."-".$date_array[0];	
	else
		$new_date = '0000-00-00';	
	return  $new_date;
 }

?>