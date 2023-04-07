<?php 
// Config file
require_once('../inc/config.php');   


//echo '<pre>'; print_r($_POST);  exit; 
/* receipt_no fee name licence_no issue_place issue_date expiry_date gender mother_name date_birth birth_place nationality address 
email contact_no personal_id vehicle_types comments



receipt_no   fees name   licence_no  issue_place issue_date  expiry_date  gender  mother_name  birth_date  birth_place  nationality
 address   email  contact_no  personal_id  vehicle_types  comments
*/
// get receipt data
if(isset($_POST['setting']))
{
	$sql = 'update tbl_settings
	        SET
			 printer = "'.addslashes(mysqli_real_escape_string($con, $_POST['setting'])).'"
			WHERE
			 id =  1
			 '; 
	//echo $sql; exit;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'Setting updated successfully';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	//$_SESSION['licence_section'] = 'card_list';	 
	header('location:../settings.php'); 
	die;
}
else if(isset($_GET['cardId']) && isset($_POST['licence_no']) && isset($_POST['issue_date']) && isset($_POST['date_birth']) && isset($_POST['add_licence_data']))
{   // licence_no  name nationality date_birth issue_place issue_date expiry_date vehicle_types
	$sql = 'Update tbl_driver_detail
	        SET
			 name = "'.mysqli_real_escape_string($con, $_POST['name']).'",
			 licence_no = "'.mysqli_real_escape_string($con, $_POST['licence_no']).'",
			 issue_place = "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
			 issue_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
			 expiry_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiry_date']))).'",
			 date_birth = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date_birth']))).'",
			 nationality = "'.mysqli_real_escape_string($con, $_POST['nationality']).'",
			 vehicle_types = "'.mysqli_real_escape_string($con,  $_POST['vehicle_types']).'",
			 updated_time = "'.date('Y-m-d').'",
			 status = 1
			WHERE
			 id =  '.mysqli_real_escape_string($con, $_GET['cardId']).'
			 '; 
	//echo $sql; exit;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'Record updated successfully';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['licence_section'] = 'card_list';	 
	header('location:../licence.php');
}
else if(isset($_POST['update_licence']) && $_POST['update_licence'] != ''  && isset($_POST['issue_date']) && isset($_POST['birth_date']))
{   // , , 
	// Upload image
	$file_name = isset($_POST['licence_user_prev_image']) ? $_POST['licence_user_prev_image'] : '';
	if(isset($_FILES["image"]["name"]) && $_FILES["image"]["name"] != '')
	{  
		@unlink($target_dir .$file_name);
		$target_dir = "../uploads/users_licence/";
		$file_name = time().'_'.$_FILES["image"]["name"];
		@move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .$file_name);
		
		
	}	
	
	$sql = 'Update tbl_driver_detail
	        SET
			 name = "'.mysqli_real_escape_string($con, $_POST['name']).'",
			 issue_place = "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
			 issue_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
			 expiry_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiry_date']))).'",
			 date_birth = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['birth_date']))).'",
			 nationality = "'.mysqli_real_escape_string($con, $_POST['nationality']).'",
			 vehicle_types = "'.mysqli_real_escape_string($con,  $_POST['vehicle_types']).'",
			 gender = "'.mysqli_real_escape_string($con, $_POST['gender']).'",
			 mother_name = "'.mysqli_real_escape_string($con, $_POST['mother_name']).'",
			 birth_place = "'.mysqli_real_escape_string($con, $_POST['birth_place']).'",
			 address = "'.mysqli_real_escape_string($con, $_POST['address']).'",
			 email = "'.mysqli_real_escape_string($con, $_POST['email']).'",
			 contact_no = "'.mysqli_real_escape_string($con, $_POST['contact_no']).'",
			 personal_id = "'.mysqli_real_escape_string($con, $_POST['personal_id']).'",
			 vehicle_types = "'.implode(",", $_POST['vehicle_types']).'",
			 comments = "'.mysqli_real_escape_string($con, $_POST['comments']).'",
			 image = "'.$file_name.'",
			 updated_time = "'.date('Y-m-d').'",
			 status = 1
			WHERE
			 id =  '.mysqli_real_escape_string($con, $_POST['update_licence']).'
			 '; 
	//echo $sql; exit;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	{
	     $_SESSION['success'] = 'Record updated successfully';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.aaa';
	//$_SESSION['licence_section'] = 'card_list';	 
	header('location:../licence.php');
}
else if(isset($_POST['licence_no']) && isset($_POST['issue_date']) && isset($_POST['date_birth']) && isset($_POST['add_licence_data']))
{   // licence_no  name nationality date_birth issue_place issue_date expiry_date vehicle_types
	$sql = 'INSERT into tbl_driver_detail
	        (name, licence_no, issue_place, issue_date, expiry_date, date_birth, nationality, vehicle_types, updated_time, status)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['name']).'",
			 "'.mysqli_real_escape_string($con, $_POST['licence_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiry_date']))).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date_birth']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['nationality']).'",
			 "'.mysqli_real_escape_string($con,  $_POST['vehicle_types']).'",
			 "'.date('Y-m-d').'",
			 1
			)'; 
	//echo $sql; exit;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['licence_section'] = 'card_list';	 
	header('location:../licence.php');
}
else if(isset($_POST['receipt_no']) && isset($_POST['name']) && isset($_POST['licence_no']) && isset($_POST['issue_date']) && isset($_POST['birth_date']) )
{
	// Upload image
	$file_name = '';
	if(isset($_FILES["image"]["name"]))
	{
		$target_dir = "../uploads/users_licence/";
		$file_name = time().'_'.$_FILES["image"]["name"];
		@move_uploaded_file($_FILES["image"]["tmp_name"], $target_dir .$file_name);
	}
	
	
	$sql = 'INSERT into tbl_driver_detail
	        (receipt_no, fee, name, licence_no, issue_place, issue_date, expiry_date, gender, mother_name, 
			 date_birth, birth_place, nationality, address, email, contact_no, personal_id, vehicle_types, comments,image, updated_time, status)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['fees']).'",
			 "'.mysqli_real_escape_string($con, $_POST['name']).'",
			 "'.mysqli_real_escape_string($con, $_POST['licence_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiry_date']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['gender']).'",
			 "'.mysqli_real_escape_string($con, $_POST['mother_name']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['birth_date']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['birth_place']).'",
			 "'.mysqli_real_escape_string($con, $_POST['nationality']).'",
			 "'.mysqli_real_escape_string($con, $_POST['address']).'",
			 "'.mysqli_real_escape_string($con, $_POST['email']).'",
			 "'.mysqli_real_escape_string($con, $_POST['contact_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['personal_id']).'",
			 "'.implode(",", $_POST['vehicle_types']).'",
			 "'.mysqli_real_escape_string($con, $_POST['comments']).'",
			 "'.$file_name.'",
			 "'.date('Y-m-d').'",
			 1
			 )'; 
	//echo $sql; exit;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	{
	     // update used receipt status in receipt table
		 mysqli_query($con, "update tbl_receipts
		 					 set
							   status = 0
							 where 
							 	receipt_no = '".mysqli_real_escape_string($con,$_POST['receipt_no'])."' 
						     ");
		 $_SESSION['success'] = 'New record has been added';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../licence.php');
}
// ajax pagination of licence
else if(isset($_POST['action']) && $_POST['action'] == 'licence_ajax_pagination' && isset($_POST['page']))
{
    $pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_statement']) && $_SESSION['search_statement'] != '')
	    $statement = $_SESSION['search_statement'];
	else	
		$statement = $pagination_data['current_statement'];
	//$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{
		  $result .= '<tr>
						<td>'.$rec->licence_no.'</td>
						<td>'.$rec->name.'</td> 
						<td>'.$rec->nationality.'</td>
						<td>'.date('d/m/Y', strtotime($rec->date_birth)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.date('d/m/Y', strtotime($rec->expiry_date)).'</td>
						<td>'.$rec->vehicle_types.'</td>  
						<td><a href="?licence_search_id='.$rec->licence_no.'" class="fa fa-print"></a></td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}// ajax pagination of licence Card list
else if(isset($_POST['action']) && $_POST['action'] == 'licence_ajax_pagination_card' && isset($_POST['page']))
{
    $pagination_data = $_SESSION['licence_card_pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_licence_card_statement']) && $_SESSION['search_licence_card_statement'] != '')
	    $statement = $_SESSION['search_licence_card_statement'];
	else	
		$statement = $pagination_data['current_statement'];
	//$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{
		  $result .= '<tr>
						<td><a href="?print_licence_no='.$rec->licence_no.'"  class="fa fa-print"></td>
						<td>'.$rec->licence_no.'</td>
						<td>'.$rec->name.'</td> 
						<td>'.$rec->nationality.'</td>
						<td>'.date('d/m/Y', strtotime($rec->date_birth)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.date('d/m/Y', strtotime($rec->expiry_date)).'</td>
						<td>'.$rec->vehicle_types.'</td>  
						<td><a href="?cardId='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit"></a></td>
                        <td><a href="model/licence_model.php?delete_cardID='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure to delete ? \');" class="glyphicon glyphicon-trash"></a></td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_card_pagination', $con);
	echo json_encode(array('result' => $result , 'pagination' => $paginaton));
}
// Remove_session_value_of_search_statement 
else if( isset($_POST['action']) &&  $_POST['action'] = 'Remove_session_value_of_search_statement_card')
{
	unset($_SESSION['search_licence_card_statement']);
	return true;
}   
// search section      s_licence_no  s_l_name s_l_nationality
else if(isset($_POST['s_licence_no']) || isset($_POST['s_l_name']) || isset($_POST['s_l_nationality']))      // Search records
{
	$where = '';
	if(isset($_POST['s_l_name']) && $_POST['s_l_name'] != '')
	   $where .= ' name LIKE "%'.mysqli_real_escape_string($con, $_POST['s_l_name']).'%" ';
	if(isset($_POST['s_licence_no']) && $_POST['s_licence_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' licence_no LIKE "'.mysqli_real_escape_string($con, $_POST['s_licence_no']).'" ';  
	}
	if(isset($_POST['s_l_nationality']) && $_POST['s_l_nationality'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' nationality LIKE "%'.mysqli_real_escape_string($con, $_POST['s_l_nationality']).'%" ';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_driver_detail where'.$where.' ';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from '.$statement.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		{  
		
		   $result .= '<tr>
						<td>'.$rec->licence_no.'</td>
						<td>'.$rec->name.'</td> 
						<td>'.$rec->nationality.'</td>
						<td>'.date('d/m/Y', strtotime($rec->date_birth)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.date('d/m/Y', strtotime($rec->expiry_date)).'</td>
						<td>'.$rec->vehicle_types.'</td>  
						<td><a href="?licence_search_id='.$rec->licence_no.'"" class="fa fa-print"></a></td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_statement'] = $statement;
		
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}   // Remove_session_value_of_search_statement 
else if( isset($_POST['action']) &&  $_POST['action'] = 'Remove_session_value_of_search_statement')
{
	unset($_SESSION['search_statement']);
	return true;
}// search section    l_from_date  l_to_date
else if(isset($_POST['l_from_date']) && $_POST['l_from_date'] != '' && isset($_POST['l_to_date']) && $_POST['l_to_date'] != '')      // Search records
{
	$where = ' issue_date Between "'.date('Y-m-d', strtotime($_POST['l_from_date'])).'" and "'.date('Y-m-d', strtotime($_POST['l_to_date'])).'" ';
	$result = '';
	// statement for pagination
	$statement = ' tbl_driver_detail where'.$where.' ';
	//$_SESSION['receipt_search_statement'] = $statement;
	$page = 1;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$sql = 'select * from '.$statement.'  LIMIT '.$startpoint.' , '.$per_page.' ';
	$data = mysqli_query($con, $sql);
	
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td><a href="?print_licence_no='.$rec->licence_no.'"  class="fa fa-print"></td>
					<td>'.$rec->licence_no.'</td>
					<td>'.$rec->name.'</td> 
					<td>'.$rec->nationality.'</td>
					<td>'.date('d/m/Y', strtotime($rec->date_birth)).'</td>
					<td>'.$rec->issue_place.'</td>
					<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
					<td>'.date('d/m/Y', strtotime($rec->expiry_date)).'</td>
					<td>'.$rec->vehicle_types.'</td>  
					<td><a href="?cardId='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit"></a></td>
                    <td><a href="model/licence_model.php?delete_cardID='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure to delete ? \');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	//$pagination_data = $_SESSION['pagination_data'];
	// Storing previous statement in session
	$_SESSION['search_licence_card_statement'] = $statement;
	
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_card_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
} 
// Delete licence
else if(isset($_GET['delete_cardID']) && $_GET['delete_cardID'] != '')
{
	$id = base64_decode($_GET['delete_cardID']);
	@mysqli_query($con, "update tbl_driver_detail
						 set
						   status = 0
						 where 
						   id = ".$id."
						 ");
	$_SESSION['licence_section'] = 'card_list';	
	$_SESSION['success'] = 'Record deleted from card list';
	header('location:../licence.php');		
}

else
{  
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../licence.php');
}


?>