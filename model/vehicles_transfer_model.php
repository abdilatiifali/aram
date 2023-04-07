<?php
// Config file
require_once('../inc/config.php');


// plate_no chassis_no receipt_no amount date  owner gender mother_name
// birth_date birth_place nationality personal_id contact_no  address  email

/* Owner, birth_day, nationality, birth_place, mother_name, mobile_no, email, address, gender, personal_id,
						  fees, issue_date, expire_date, plate_no, plate_type,
						  */
// Ajax Pagination
if(isset($_POST['plate_no']) && $_POST['plate_no'] != '' && isset($_POST['chassis_no']))
{
    $get_veh_data = mysqli_query($con, "select * from tbl_vehicles
									    where
										plate_no = '".mysqli_real_escape_string($con, $_POST['plate_no'])."'
										and
										chassis_no = '".mysqli_real_escape_string($con, $_POST['chassis_no'])."'
										");
	$previous_vehicle_data =  mysqli_fetch_object($get_veh_data);

    $user_data = $_SESSION['logged_in_user_data'];
	$sql = 'INSERT into tbl_vehicle_transfer
	        (Owner, birth_day, nationality, birth_place, mother_name, mobile_no, email, address,
			 gender, personal_id, amount, plate_no, chassis_no, owner_status, issue_date, receipt_no, issue_place, createBy)
			VALUES
			("'.$previous_vehicle_data->Owner.'",
			 "'.$previous_vehicle_data->birth_day.'",
			 "'.$previous_vehicle_data->nationality.'",
			 "'.$previous_vehicle_data->birth_place.'",
			 "'.$previous_vehicle_data->mother_name.'",
			 "'.$previous_vehicle_data->mobile_no.'",
			 "'.$previous_vehicle_data->email.'",
			 "'.$previous_vehicle_data->address.'",
			 "'.$previous_vehicle_data->gender.'",
			 "'.$previous_vehicle_data->personal_id.'",
			 "'.$previous_vehicle_data->fees.'",
			 "'.$previous_vehicle_data->plate_no.'",
			 "'.$previous_vehicle_data->chassis_no.'",
			 2,
			 "'.$previous_vehicle_data->issue_date.'",
			 "'.$previous_vehicle_data->receipt_no.'",
			 "'.$previous_vehicle_data->issue_place.'",
			 '.$user_data->id.'
			)';
	//echo $sql;
	//mysqli_query($con, $sql); exit;
	if(mysqli_query($con, $sql))
	{
	     $sql_update = 'UPDATE tbl_vehicles
						SET
						 Owner = "'.mysqli_real_escape_string($con, $_POST['owner']).'",
						 birth_day = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['birth_date']))).'",
						 nationality = "'.mysqli_real_escape_string($con, $_POST['nationality']).'",
						 birth_place = "'.mysqli_real_escape_string($con, $_POST['birth_place']).'",
						 mother_name = "'.mysqli_real_escape_string($con, $_POST['mother_name']).'",
						 mobile_no = "'.mysqli_real_escape_string($con, $_POST['contact_no']).'",
						 email = "'.mysqli_real_escape_string($con, $_POST['email']).'",
						 address = "'.mysqli_real_escape_string($con, $_POST['address']).'",
						 gender = "'.mysqli_real_escape_string($con, $_POST['gender']).'",
						 personal_id = "'.mysqli_real_escape_string($con, $_POST['personal_id']).'",
						 fees = "'.mysqli_real_escape_string($con, $_POST['amount']).'",
						 receipt_no = "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
						 issue_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date']))).'",
						 issue_place = "'.mysqli_real_escape_string($con, $_POST['issue_place']).'",
						 updated_time = "'.date('Y-m-d').'",
						 status = 1
						where
							plate_no = "'.mysqli_real_escape_string($con, $_POST['plate_no']).'"
							and
							chassis_no = "'.mysqli_real_escape_string($con, $_POST['chassis_no']).'"
						';
		if(mysqli_query($con, $sql_update))
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
	}
	else
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../vehicle_transfer.php');


}// search section      s_v_card_from_date  s_v_card_to_date
else if(isset($_POST['s_v_card_from_date']) && isset($_POST['s_v_card_to_date']))      // Search records
{
	$where = ' status = 1 and updated_time > DATE_SUB(NOW(), INTERVAL 7 day)';
	if(isset($_POST['s_v_card_from_date']) && $_POST['s_v_card_to_date'] != '')
	    $where .= ' and ( issue_date Between  "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_v_card_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_v_card_to_date']))).'" )';

	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_vehicles where'.$where.' group by plate_no ORDER BY  updated_time ';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from '.$statement.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);

		while($rec = mysqli_fetch_object($data))
		{

		   $result .= '<tr>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->Owner.'</td>
						<td>'.$rec->nationality.'</td>
						<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
						<td>'.$rec->model.'</td>
						<td>'.$rec->color.'</td>
						<td></td>
						<td>'.$rec->origin.'</td>
						<td>'.$rec->chassis_no.'</td> 
						<td><a href="?section=card_list&search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a></td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_card_list_statement'] = $statement;

		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_transfer_cl_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}
// Ajax Pagination
else if(isset($_POST['action']) && $_POST['action'] == 'vehicles_trans_history_ajax_pagination' && isset($_POST['page']))
{
    $pagination_data = $_SESSION['pagination_t_data'];	
	$page = $_POST['page'];
	$per_page = $pagination_data['per_page']; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
                    <td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
					<td>'.$rec->plate_no.'</td>
					<td>'.$rec->chassis_no.'</td>
					<td>'.$pagination_data['v_color'].'</td>
					<td>'.$pagination_data['v_v_type'].'</td>
					<td>'.$rec->Owner.'</td>
					<td>'.$rec->mobile_no.'</td>
					<td>'.$rec->address.'</td>
					<td><a href="?section=vehicle_search&search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_transfer_history_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
// search section      s_vt_name  s_vt_number 
else if(isset($_POST['s_vt_name']) || isset($_POST['s_vt_number']) || isset($_POST['vt_type']) || isset($_POST['vt_contact']))      // Search records
{
	$where = '';
	if(isset($_POST['s_vt_name']) && $_POST['s_vt_name'] != '')
	   $where .= ' vt.Owner LIKE "%'.mysqli_real_escape_string($con, $_POST['s_vt_name']).'%" ';
	if(isset($_POST['s_vt_number']) && $_POST['s_vt_number'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' vt.plate_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_vt_number']).'%" ';  
	}
	if(isset($_POST['vt_type']) && $_POST['vt_type'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' v.v_type LIKE "%'.mysqli_real_escape_string($con, $_POST['vt_type']).'%" ';  
	}
	if(isset($_POST['vt_contact']) && $_POST['vt_contact'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' vt.mobile_no LIKE "%'.mysqli_real_escape_string($con, $_POST['vt_contact']).'%" ';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement_for_pagination = ' tbl_vehicle_transfer  where'.$where.' ';
		$statement = " SELECT vt.* , v.expire_date, v.model, v.color, v.engine_no
							 				FROM tbl_vehicle_transfer vt 
							 				left join tbl_vehicles v  
											on v.plate_no = vt.plate_no
											";
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = ' '.$statement.' where'.$where.' ORDER BY vt.id DESC  LIMIT '.$startpoint.' , '.$per_page.' ';
		//echo $sql; exit;
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		{  
		//           
                                       
                                
		   $result .= '<tr>
						<td>'.(isset($rec->plate_no) ? $rec->plate_no : '').'</td>
						<td>'.(isset($rec->Owner) ? $rec->Owner : '').'</td>
						<td>'.(isset($rec->nationality) ? $rec->nationality :'').'</td>
						<td>'.(isset($rec->issue_place) ? $rec->issue_place : '').'</td>
						<td>'.(isset($rec->expire_date) ? date('d/m/Y', strtotime($rec->expire_date)) : '').'</td>
						<td>'.(isset($rec->model) ? $rec->model : '').'</td>
						<td>'.(isset($rec->color) ? $rec->color : '').'</td>
						<td>'.(isset($rec->chassis_no) ? $rec->chassis_no : '').'</td>
						<td>'.(isset($rec->engine_no) ? $rec->engine_no : '').'</td>
						<td><a href="?section=search_vehicle&search_vehicle_no='.(isset($rec->plate_no) ? $rec->plate_no : '').'" class="fa fa-print"></a></td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_vt_statement'] = $statement;
		$_SESSION['search_vt_statement_pagination'] = $statement_for_pagination;
		
		 $paginaton = ajax_pagination($statement_for_pagination,$per_page,$page,$url='vehicles_transfer_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}

// vehicle transfer search vehicle pagination
// Ajax Pagination
else if(isset($_POST['action']) && $_POST['action'] == 'vehicles_transfer_ajax_pagination' && isset($_POST['page']))
{ 
    $pagination_data = $_SESSION['pagination_vt__data'];
	//echo '<pre>'; print_r($pagination_data); exit;	
	$page = $_POST['page'];
	$per_page = $pagination_data['per_page'];; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_vt_statement']) && $_SESSION['search_vt_statement'] != '')
	{
	    $statement = $_SESSION['search_vt_statement'];
		$statement_for_pagination = $_SESSION['search_vt_statement_pagination'];
	}
	else
	{	
		$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
		$statement_for_pagination = $pagination_data['statement_for_pagination'];
	}
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"{$statement} LIMIT {$startpoint} , {$per_page}");
	//echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}";		
	$result = '';	   
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
						<td>'.(isset($rec->plate_no) ? $rec->plate_no : '').'</td>
						<td>'.(isset($rec->Owner) ? $rec->Owner : '').'</td>
						<td>'.(isset($rec->nationality) ? $rec->nationality :'').'</td>
						<td>'.(isset($rec->issue_place) ? $rec->issue_place : '').'</td>
						<td>'.(isset($rec->expire_date) ? date('d/m/Y', strtotime($rec->expire_date)) : '').'</td>
						<td>'.(isset($rec->model) ? $rec->model : '').'</td>
						<td>'.(isset($rec->color) ? $rec->color : '').'</td>
						<td>'.(isset($rec->chassis_no) ? $rec->chassis_no : '').'</td>
						<td>'.(isset($rec->engine_no) ? $rec->engine_no : '').'</td>
						<td><a href="?section=search_vehicle&search_vehicle_no='.(isset($rec->plate_no) ? $rec->plate_no : '').'" class="fa fa-print"></a></td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement_for_pagination,$per_page,$page,$url='vehicles_transfer_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
//
//vehicle transfer card list pagination
else if(isset($_POST['action']) && $_POST['action'] == 'vehicles_transfer_cl_ajax_pagination' && isset($_POST['page']))
{ 
    $pagination_data = $_SESSION['pagination_data_cl'];
	//echo '<pre>'; print_r($pagination_data); exit;	
	$page = $_POST['page'];
	$per_page = $pagination_data['per_page'];; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_card_list_statement']) && $_SESSION['search_card_list_statement'] != '')
	    $statement = $_SESSION['search_card_list_statement'];
	else	
		$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
	//echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}";		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->Owner.'</td>
						<td>'.$rec->nationality.'</td>
						<td>'.date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
						<td>'.$rec->model.'</td>
						<td>'.$rec->color.'</td>
						<td></td>
						<td>'.$rec->origin.'</td>
						<td>'.$rec->chassis_no.'</td> 
						<td><a href="?section=card_list&search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a></td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_transfer_cl_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}

?>
