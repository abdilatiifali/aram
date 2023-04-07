<?php 
// Config file
require_once('../inc/config.php');

// update record 

if(isset($_GET['id']))
{
	$rec_id = base64_decode($_GET['id']);
    $check = mysqli_query($con, 'select id from tbl_traffic_fines where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{  // receipt_no = "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
		$sql = 'UPDATE tbl_traffic_fines 
		 		SET
	             fine_no = "'.mysqli_real_escape_string($con, $_POST['fine_number']).'",
				 issue_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
				 time = "'.date('H:i:s', strtotime(mysqli_real_escape_string($con, $_POST['time']))).'",
				 issue_place = "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
				 fine_code = "'.mysqli_real_escape_string($con, $_POST['fine_code']).'",
				 fine_type = "'.mysqli_real_escape_string($con, $_POST['fine_type']).'",
				 plate_no = "'.mysqli_real_escape_string($con, $_POST['plate_no']).'",
				 registration = "'.mysqli_real_escape_string($con, $_POST['registration']).'",
				 driver_name = "'.mysqli_real_escape_string($con, $_POST['driver_name']).'",
				 licence_no = "'.mysqli_real_escape_string($con, $_POST['licence_no']).'",
				 comments = "'.mysqli_real_escape_string($con, $_POST['comments']).'"
				WHERE id = '.$rec_id.'
				'; 
		if(mysqli_query($con, $sql))
			 $_SESSION['success'] = 'Record has been Updated';
		else	 		 
			 $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';		 
	}
	else	 		 
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';	
	header('location:../traffic.php');	
}
else if(isset($_GET['fine_payment_id']))
{
	$rec_id = base64_decode($_GET['fine_payment_id']);
    $check = mysqli_query($con, 'select id from tbl_traffic_fines where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{  // receipt_no = "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
		$sql = 'UPDATE tbl_traffic_fines 
		 		SET
	             receipt_no = "'.mysqli_real_escape_string($con, $_POST['fp_receipt_no']).'",
				 payment_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['fp_payment_date']))).'",
				 status = 2
			    WHERE id = '.$rec_id.'
				'; 
		if(mysqli_query($con, $sql))
			 $_SESSION['success'] = 'Record has been Updated';
		else	 		 
			 $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';		 
	}
	else	 		 
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';	
	$_SESSION['fine_section'] = 'payment';	
	header('location:../traffic.php');	
}
else if(isset($_GET['fine_master_id']))
{
	$rec_id = base64_decode($_GET['fine_master_id']);
    $check = mysqli_query($con, 'select id from tbl_fine_master where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{  // fine_code, comments, black_point, prison, vehicle_confiscation, amount, status
	         
		$sql = 'UPDATE tbl_fine_master 
		 		SET
	             fine_code = "'.mysqli_real_escape_string($con, $_POST['m_code']).'",
				 comments = "'.mysqli_real_escape_string($con, $_POST['m_detail']).'",
				 black_point = "'.mysqli_real_escape_string($con, $_POST['m_black_point']).'",
				 prison = "'.mysqli_real_escape_string($con, $_POST['m_prison']).'",
				 vehicle_confiscation = "'.mysqli_real_escape_string($con, $_POST['m_vc_period']).'",
				 amount = "'.mysqli_real_escape_string($con, $_POST['m_amount']).'",
				 status = 2
				WHERE id = '.$rec_id.'
				'; 
		if(mysqli_query($con, $sql))
			 $_SESSION['success'] = 'Record has been Updated';
		else	 		 
			 $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';		 
	}
	else	 		 
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';	
	$_SESSION['fine_section'] = 'master';		
	header('location:../traffic.php');	
}
else if(isset($_POST['action']) && $_POST['action'] == 'validate_receipt_no' && isset($_POST['receipt_no']) && $_POST['receipt_no'] != '')
{
	$check = mysqli_query($con, 'select * from tbl_traffic_fines where receipt_no = '.mysqli_real_escape_string($con,$_POST['receipt_no']).' ');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))	
	     echo 'yes';
	else 
	     echo 'no'; 	  
}
else if(isset($_POST['add_fine_form']) && $_POST['add_fine_form'] == 1)
{   //                                 
	$sql = 'INSERT into tbl_traffic_fines
	        (receipt_no, fine_no, issue_date,  time, issue_place, fine_code,  fine_type, plate_no, registration, driver_name, licence_no, comments,payment_date)
			VALUES
			("",
			 "'.mysqli_real_escape_string($con, $_POST['fine_number']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date']))).'",
			 "'.date('H:i:s', strtotime(mysqli_real_escape_string($con, $_POST['time']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
			 "'.mysqli_real_escape_string($con, $_POST['fine_code']).'",
			 "'.mysqli_real_escape_string($con, $_POST['fine_type']).'",
			 "'.mysqli_real_escape_string($con, $_POST['plate_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['registration']).'",
			 "'.mysqli_real_escape_string($con, $_POST['driver_name']).'",
			 "'.mysqli_real_escape_string($con, $_POST['licence_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['comments']).'",
			 "'.date('Y-m-d').'"
			 )';  
	//echo $sql; 
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	//echo mysqli_error($con); exit;	 
	header('location:../traffic.php');	
}
else if(isset($_POST['action']) && $_POST['action'] == 'fine_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->fine_no.'</td>
					<td>'.$rec->fine_code.'</td>
					<td>'.date('d-m-Y', strtotime($rec->issue_date)).'</td>
					<td>'.$rec->issue_place.'</td>
					<td>'.$rec->fine_type.'</td>
					<td>'.$rec->plate_no.'</td>
					<td>'.$rec->registration.'</td>
					<td>'.$rec->licence_no.'</td>
					<td>'.$rec->driver_name.'</td>
					<td>'.($rec->status == 2 ? 'Paid' : '').'</td>
					<td>
					  <a href="?fine_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
					  </a>
					</td>
					
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='fine_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
else if(isset($_POST['action']) && $_POST['action'] == 'fine_pay_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$sr_no = (($_POST['page'] - 1) * 10) + 1;
	if($sr_no  == 0) $sr_no = 1;
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['current_statement_finepay']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT t_fine.*, fm.amount from {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
	                <td>'.$sr_no.'</td>
					<td>'.date('d-m-Y', strtotime($rec->issue_date)).'</td>
					<td>'.$rec->fine_code.'</td>
					<td>'.$rec->fine_no.'</td>
					<td>'.$rec->plate_no.'</td>
					<td>'.$rec->issue_place.'</td>
					<td>$'.$rec->amount.'</td>
					<td></td>
                    <td></td>
					<td>
					  <a href="?fine_payment_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
					  </a>
					</td>
				 </tr>';
		$sr_no++;		  
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='fine_pay_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
else if(isset($_POST['action']) && $_POST['action'] == 'master_fine_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->fine_code.'</td>
					<td>'.$rec->comments.'</td>
					<td>$'.$rec->amount.'</td>
					<td>'.$rec->black_point.'</td>
					<td>'.$rec->prison.'</td>
					<td>'.$rec->vehicle_confiscation.'</td>
					<td>
					  <a href="?fine_master_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
					  </a>
					</td>
					<td>
					  <a href="model/fine_model.php?delid='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure to delete?\');" class="glyphicon glyphicon-trash">
					  </a>
					</td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='fine_master_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
else if(isset($_POST['m_add_form']) && $_POST['m_add_form'] == 1)
{   //  m_code  m_detail  m_amount m_black_point  m_prison m_vc_period                                
	$sql = 'INSERT into tbl_fine_master
	        (fine_code, comments, black_point, prison, vehicle_confiscation, amount, status)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['m_code']).'",
			 "'.mysqli_real_escape_string($con, $_POST['m_detail']).'",
			 "'.mysqli_real_escape_string($con, $_POST['m_black_point']).'",
			 "'.mysqli_real_escape_string($con, $_POST['m_prison']).'",
			 "'.mysqli_real_escape_string($con, $_POST['m_vc_period']).'",
			 "'.mysqli_real_escape_string($con, $_POST['m_amount']).'",
			 2
			 )'; 
	//echo $sql;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['fine_section'] = 'master';	 
	header('location:../traffic.php');	
}
else if(isset($_GET['delid']))  // delete record
{
	$rec_id = base64_decode($_GET['delid']);
    $check = mysqli_query($con, 'select id from tbl_fine_master where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
	if(!empty($check_data))
	{
		 @mysqli_query($con, 'DELETE from tbl_fine_master where id = '.$rec_id.'');
		 $_SESSION['success'] = 'Record has been deleted';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    $_SESSION['fine_section'] = 'master';
	header('location:../traffic.php');	 
}   /// search section
// search section      s_fine_by_fine_no  s_fine_plate_no  s_fine_licence_no
else if(isset($_POST['s_fine_by_fine_no']) || isset($_POST['s_fine_plate_no']) || isset($_POST['s_fine_licence_no']))      // Search records
{
	$where = '';
	if(isset($_POST['s_fine_by_fine_no']) && $_POST['s_fine_by_fine_no'] != '')
	   $where .= ' fine_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_by_fine_no']).'%" ';
	if(isset($_POST['s_fine_plate_no']) && $_POST['s_fine_plate_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' plate_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_plate_no']).'%" ';  
	}
	if(isset($_POST['s_fine_licence_no']) && $_POST['s_fine_licence_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' licence_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_licence_no']).'%" ';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_traffic_fines where'.$where.' ';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from tbl_traffic_fines where'.$where.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		$result = '';
		while($rec = mysqli_fetch_object($data))
		{  
		
		   $result .= '<tr>
						<td>'.$rec->fine_no.'</td>
						<td>'.$rec->fine_code.'</td>
						<td>'.date('d-m-Y', strtotime($rec->issue_date)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.$rec->fine_type.'</td>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->registration.'</td>
						<td>'.$rec->licence_no.'</td>
						<td>'.$rec->driver_name.'</td>
						<td>'.($rec->status == 2 ? 'Paid' : '').'</td>
						<td>
						  <a href="?fine_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
						  </a>
						</td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_statement'] = $statement;
		
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='fine_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
} // s_fine_pay_by_fine_no  s_fine_pay_plate_no  s_fine_pay_licence_no
else if(isset($_POST['s_fine_pay_by_fine_no']) || isset($_POST['s_fine_pay_plate_no']) || isset($_POST['s_fine_pay_licence_no']))      // Search records
{
	$where = ' t_fine.status = 1 ';
	if(isset($_POST['s_fine_pay_by_fine_no']) && $_POST['s_fine_pay_by_fine_no'] != '')
	    if($where != '')
	      $where .='  ';	
	   $where .= ' AND t_fine.fine_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_pay_by_fine_no']).'%" ';
	if(isset($_POST['s_fine_pay_plate_no']) && $_POST['s_fine_pay_plate_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' t_fine.plate_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_pay_plate_no']).'%" ';  
	}
	if(isset($_POST['s_fine_pay_licence_no']) && $_POST['s_fine_pay_licence_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' t_fine.licence_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_fine_pay_licence_no']).'%" ';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		//$statement = ' tbl_traffic_fines where'.$where.' ';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$sr_no = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$statement = "  tbl_traffic_fines as t_fine
						inner join tbl_fine_master as fm
						on fm.fine_code = t_fine.fine_code
						where ".$where." ORDER BY t_fine.id DESC";
		//$con = $pagination_data['db_con'];
	    $data = mysqli_query($con,"SELECT t_fine.*, fm.amount from {$statement} LIMIT {$startpoint} , {$per_page}");		
		$result = '';	 
		while($rec = mysqli_fetch_object($data))
		{  
		
		   $result .= '<tr>
						<td>'.$sr_no.'</td>
						<td>'.date('d-m-Y', strtotime($rec->issue_date)).'</td>
						<td>'.$rec->fine_code.'</td>
						<td>'.$rec->fine_no.'</td>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->issue_place.'</td>
						<td>$'.$rec->amount.'</td>
						<td></td>
						<td></td>
						<td>
						  <a href="?fine_payment_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
						  </a>
						</td>
					 </tr>';
			$sr_no++;		  
		}
		if(mysqli_num_rows($data) <= 0)
		       $result = '<tr><td style="color:red;" colspan="10"> No record found</td></tr>'; 
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_statement'] = $statement;
		
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='fine_pay_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}
// ajax pagination after search results
else if(isset($_POST['action']) && $_POST['action'] == 'receipt_ajax_pagination' && isset($_POST['page']))
{
    //$pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['receipt_search_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{
		  if(strlen($rec->comments) > 15)
			  $comment = substr($rec->comments,0,15).'...';
		  else
			  $comment = $rec->comments; 	  
		  $result .= '<tr>
						<td>'.$rec->receipt_no.'</td>
						<td>'.date('d-m-y', strtotime($rec->date)).'</td>
						<td>'.$rec->received_from.'</td>
						<td>'.$rec->for_opt.'</td>  
						<td>$'.$rec->amount.'</td>
						<td>'.$comment.'</td>
						<td>
						  <a href="?id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
						  </a>
						</td>
						<td>
						  <a href="model/receipt_model.php?delid='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash">
						  </a>
						</td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='receipt_ajax_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
// ajax pagination of receipts in vehicles module
else if(isset($_POST['action']) && $_POST['action'] == 'receipt_ajax_pagination_vehicle' && isset($_POST['page']))
{
    //$pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['receipt_search_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{
		  if(strlen($rec->comments) > 15)
			  $comment = substr($rec->comments,0,15).'...';
		  else
			  $comment = $rec->comments; 	  
		  $result .= '<tr>
						<td>'.$rec->vehicle_no.'</td>
						<td>'.$rec->receipt_no.'</td>
						<td>'.date('d-m-y', strtotime($rec->date)).'</td>
						<td>'.date('d-m-y', strtotime($rec->expire_date)).'</td>
						<td>'.$rec->for_opt.'</td>  
						<td>$'.$rec->amount.'</td>
						<td>'.$comment.'</td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='receipt_ajax_pagination_vehicle', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
} // Checking receipt no validation

else
{
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../traffic.php');
}


?>