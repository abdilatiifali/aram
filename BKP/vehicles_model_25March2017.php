<?php 
// Config file
require_once('../inc/config.php');

// get receipt data
if(isset($_POST['action']) && $_POST['action'] == 'licence_get_receipt_data' && isset($_POST['receipt_no']) && $_POST['receipt_no'] != '')
{
	$check = mysqli_query($con, "select * from tbl_receipts where receipt_no = '".mysqli_real_escape_string($con,$_POST['receipt_no'])."' and status = 1 ");
    $receipt_data = @mysqli_fetch_object($check);
    if(!empty($receipt_data))       
	{
		$issue_date = strtotime($receipt_data->date);
		//$expire_days = (((24 * 60 * 60) * 365) * 3);
		$expire_days = (((24 * 60 * 60) * ONEYEAR)); //365
		$expire_Date = $issue_date + $expire_days; 
		
		//GET Valide Start and Expiry Date in DB base on Receipt number
		$QryVeh = mysqli_query($con, "select issue_date, expire_date from tbl_vehicles where receipt_no = '".mysqli_real_escape_string($con,$_POST['receipt_no'])."' and status = 1 ");
		$veh_data = @mysqli_fetch_object($QryVeh);
		if(!empty($veh_data))       
		{			
			$_SESSION['VEHISSDATE']	=	date('d-m-Y' , strtotime($veh_data->issue_date));
			$_SESSION['VEHEXPDATE']	=	date('d-m-Y' , strtotime($veh_data->expire_date));
		}
		else
		{
			$_SESSION['VEHISSDATE']	=	date('d-m-Y', strtotime($receipt_data->date));
			$_SESSION['VEHEXPDATE']	=	date('d-m-Y', $expire_Date);
		}
		echo json_encode(array('result' => 'yes', 
							   'fees' => $receipt_data->amount, 
							   'holder_name' => $receipt_data->received_from, 
							   'issue_date' => date('d-m-Y' , strtotime($receipt_data->date)),  
							   'expire_date' => date('d-m-Y' , $expire_Date)
							   ));
	}
	else 
	     echo json_encode(array('result' => "no"));	  
}

// Add new vehicle
else if(isset($_GET['cardlist_id']))
{   ////                     //            
	$sql = "update  tbl_vehicles
			 Set
			  Owner = '".mysqli_real_escape_string($con, $_POST['cl_owner'])."',
			  issue_date = '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['cl_issue_date'])))."',
			  expire_date = '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['cl_expire_date'])))."',
			  plate_no = '".mysqli_real_escape_string($con, $_POST['cl_plate_no'])."',
			  origin = '".mysqli_real_escape_string($con, $_POST['cl_origin'])."',
			  v_type = '".mysqli_real_escape_string($con, $_POST['cl_v_type'])."',
			  color = '".mysqli_real_escape_string($con, $_POST['cl_color'])."',
			  chassis_no = '".mysqli_real_escape_string($con, $_POST['cl_chassis_no'])."',
			  model = '".mysqli_real_escape_string($con, $_POST['cl_model'])."',
			  issue_place = '".mysqli_real_escape_string($con, $_POST['cl_issue_place'])."',
			  nationality = '".mysqli_real_escape_string($con, $_POST['cl_nationality'])."',
			  passengers = '".mysqli_real_escape_string($con, $_POST['cl_passengers'])."', 
			  updated_time = '".date('Y-m-d')."',
			  status = 1
			 where
			   id = '".base64_decode(mysqli_real_escape_string($con, $_GET['cardlist_id']))."'
			 ";
	if(mysqli_query($con, $sql))
	{
	     $_SESSION['success'] = 'Record updated successfully.';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../vehicles.php?section=card_list');	
     die;
}
else if(isset($_POST['add_new_vehicle']))
{
	$_SESSION['receipt_no']  =  mysqli_real_escape_string($con, $_POST['search_receipt_no']); 
	$_SESSION['owner'] =  mysqli_real_escape_string($con, $_POST['owner']);
	$_SESSION['birth_date'] =  mysqli_real_escape_string($con, $_POST['birth_date']);
	$_SESSION['nationality'] =  mysqli_real_escape_string($con, $_POST['nationality']);
	$_SESSION['birth_place'] =  mysqli_real_escape_string($con, $_POST['birth_place']);
	$_SESSION['mother_name'] =  mysqli_real_escape_string($con, $_POST['mother_name']);
	$_SESSION['mobile_no'] =  mysqli_real_escape_string($con, $_POST['mobile_no']);
	$_SESSION['email'] =  mysqli_real_escape_string($con, $_POST['email']);
	$_SESSION['address'] =  mysqli_real_escape_string($con, $_POST['address']);
	$_SESSION['gender'] =  mysqli_real_escape_string($con, $_POST['gender']);
	$_SESSION['personal_id'] =  mysqli_real_escape_string($con, $_POST['personal_id']);
	$_SESSION['fees'] =  mysqli_real_escape_string($con, $_POST['fees']);
	$_SESSION['issue_date'] =  mysqli_real_escape_string($con, $_POST['issue_date']);
	$_SESSION['expire_date'] =  mysqli_real_escape_string($con, $_POST['expire_date']);
	//$_SESSION['code'] =  mysqli_real_escape_string($con, $_POST['code']);
	$_SESSION['plate_no'] =  mysqli_real_escape_string($con, $_POST['plate_no']);
	$_SESSION['plate_type'] =  mysqli_real_escape_string($con, $_POST['plate_type']);
	$_SESSION['code'] =  mysqli_real_escape_string($con, $_POST['code']);
	$_SESSION['vehicle'] =  mysqli_real_escape_string($con, $_POST['vehicle']);
	$_SESSION['origin'] = mysqli_real_escape_string($con, $_POST['origin']);
	$_SESSION['weight'] =  mysqli_real_escape_string($con, $_POST['weight']);
	$_SESSION['engine_no'] = mysqli_real_escape_string($con, $_POST['engine_no']);
	$_SESSION['v_type'] =  mysqli_real_escape_string($con, $_POST['v_type']);
	$_SESSION['color'] =  mysqli_real_escape_string($con, $_POST['color']);
	$_SESSION['hp'] =  mysqli_real_escape_string($con, $_POST['hp']);
	$_SESSION['chassis_no'] =  mysqli_real_escape_string($con, $_POST['chassis_no']);
	$_SESSION['model'] =  mysqli_real_escape_string($con, $_POST['model']);
	$_SESSION['cylinder'] =  mysqli_real_escape_string($con, $_POST['cylinder']);
	$_SESSION['comments'] =  mysqli_real_escape_string($con, $_POST['comments']);
	$_SESSION['issue_place'] =  mysqli_real_escape_string($con, $_POST['issue_place']);
		
	//CHASSIS NUMBER VALIDATION
	$QryChno = mysqli_query($con, "select chassis_no, plate_no, plate_type, code, engine_no from tbl_vehicles where UPPER(chassis_no) = '".mysqli_real_escape_string($con, strtoupper($_POST['chassis_no']))."'");		
	$chrow = @mysqli_fetch_object($QryChno);
	
	//PLATE NUMBER VALIDATION	
	$platecode = $_SESSION['code'].''.$_SESSION['plate_no'];
	
	$QryPlate = mysqli_query($con, "select chassis_no, plate_no, plate_type, code, engine_no from tbl_vehicles where plate_no = '".mysqli_real_escape_string($con, $platecode)."'");		
	$pnrow = @mysqli_fetch_object($QryPlate);

	//ENGINE NUMBER VALIDATION
	/*$QryEng = mysqli_query($con, "select engine_no from tbl_vehicles where engine_no='".mysqli_real_escape_string($con, $_POST['engine_no'])."'");
	$enrow = @mysqli_fetch_object($QryEng);*/
		
	if(strtoupper($chrow->chassis_no) == strtoupper($_SESSION['chassis_no']))
	{
		$_SESSION['error'] = 'ERROR ! Same chassis number already exist, please enter the correct chassis number';
		header('location:../vehicles.php');
		exit();	
	}
	else if($pnrow->plate_no == $platecode)
	{		
		$_SESSION['error'] = 'ERROR ! Same plate number already exist, please enter the correct plate number';
		header('location:../vehicles.php');	
		exit();
	}
	/*elseif($enrow->engine_no == $_SESSION['engine_no'])
	{
		$_SESSION['error'] = 'ERROR ! Same engine number already exist, please enter the correct engine number';
		header('location:../vehicles.php');	
		exit();
	}*/
	else
	{			
		$sql = "INSERT into tbl_vehicles
			 (Owner, birth_day, nationality, birth_place, mother_name, mobile_no, email, address, gender, personal_id, 
			  fees, issue_date, expire_date, plate_no, plate_type, code, vehicle, origin, weight, engine_no, 
			  v_type, color, hp, chassis_no, model, cylinder, comments, issue_place, updated_time, status,passengers)
			 values
			 ('".mysqli_real_escape_string($con, $_POST['owner'])."',
			  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['birth_date'])))."',
			  '".mysqli_real_escape_string($con, $_POST['nationality'])."',
			  '".mysqli_real_escape_string($con, $_POST['birth_place'])."',
			  '".mysqli_real_escape_string($con, $_POST['mother_name'])."',
			  '".mysqli_real_escape_string($con, $_POST['mobile_no'])."',
			  '".mysqli_real_escape_string($con, $_POST['email'])."',
			  '".mysqli_real_escape_string($con, $_POST['address'])."',
			  '".mysqli_real_escape_string($con, $_POST['gender'])."',
			  '".mysqli_real_escape_string($con, $_POST['personal_id'])."',
			  '".mysqli_real_escape_string($con, $_POST['fees'])."',
			  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date'])))."',
			  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expire_date'])))."',
			  '".(mysqli_real_escape_string($con, $_POST['code']).''.mysqli_real_escape_string($con, $_POST['plate_no']))."',
			  '".mysqli_real_escape_string($con, $_POST['plate_type'])."',
			  '".mysqli_real_escape_string($con, $_POST['code'])."',
			  '".mysqli_real_escape_string($con, $_POST['vehicle'])."',
			  '".mysqli_real_escape_string($con, $_POST['origin'])."',
			  '".mysqli_real_escape_string($con, $_POST['weight'])."',
			  '".mysqli_real_escape_string($con, $_POST['engine_no'])."',
			  '".mysqli_real_escape_string($con, $_POST['v_type'])."',
			  '".mysqli_real_escape_string($con, $_POST['color'])."',
			  '".mysqli_real_escape_string($con, $_POST['hp'])."',
			  '".mysqli_real_escape_string($con, $_POST['chassis_no'])."',
			  '".mysqli_real_escape_string($con, $_POST['model'])."',
			  '".mysqli_real_escape_string($con, $_POST['cylinder'])."',
			  '".mysqli_real_escape_string($con, $_POST['comments'])."',
			  '".mysqli_real_escape_string($con, $_POST['issue_place'])."',
			  '".date('Y-m-d')."',
			  1,
			  ''
			 )
			 ";
			 
			if(mysqli_query($con, $sql))
			{
			 // update used receipt status in receipt table
			 mysqli_query($con, "update tbl_receipts
								 set
								   status = 0
								 where 
									receipt_no = '".mysqli_real_escape_string($con,$_POST['search_receipt_no'])."' 
								 ");
			 $_SESSION['success'] = 'New record has been added';
			 	$_SESSION['receipt_no']	=	'';
				$_SESSION['owner'] =  '';
				$_SESSION['birth_date'] =  '';
				$_SESSION['nationality'] =  '';
				$_SESSION['birth_place'] =  '';
				$_SESSION['mother_name'] =  '';
				$_SESSION['mobile_no'] =  '';
				$_SESSION['email'] =  '';
				$_SESSION['address'] =  '';
				$_SESSION['gender'] =  '';
				$_SESSION['personal_id'] =  '';
				$_SESSION['fees'] =  '';
				$_SESSION['issue_date'] =  '';
				$_SESSION['expire_date'] =  '';
				$_SESSION['code'] =  '';
				$_SESSION['plate_no'] =  '';
				$_SESSION['plate_type'] =  '';
				$_SESSION['code'] =  '';
				$_SESSION['vehicle'] =  '';
				$_SESSION['origin'] =  '';
				$_SESSION['weight'] =  '';
				$_SESSION['engine_no'] =  '';
				$_SESSION['v_type'] = '';
				$_SESSION['color'] =  '';
				$_SESSION['hp'] =  '';
				$_SESSION['chassis_no'] =  '';
				$_SESSION['model'] =  '';
				$_SESSION['cylinder'] =  '';
				$_SESSION['comments'] = '';
				$_SESSION['issue_place'] =  '';
			}
			else
			{     
				$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
			}
		header('location:../vehicles.php');					 
	}
	
}
// Update vehicle record
else if(isset($_POST['update_vehicle_record']) && $_POST['update_vehicle_record'] != '')
{
	$plateno = (mysqli_real_escape_string($con, $_POST['code']).''.mysqli_real_escape_string($con, $_POST['plate_no']));
	$sql = "update  tbl_vehicles
			 Set
			  Owner = '".mysqli_real_escape_string($con, $_POST['owner'])."',
			  birth_day = '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['birth_date'])))."',
			  nationality = '".mysqli_real_escape_string($con, $_POST['nationality'])."',
			  birth_place = '".mysqli_real_escape_string($con, $_POST['birth_place'])."',
			  mother_name = '".mysqli_real_escape_string($con, $_POST['mother_name'])."',
			  mobile_no = '".mysqli_real_escape_string($con, $_POST['mobile_no'])."',
			  email = '".mysqli_real_escape_string($con, $_POST['email'])."',
			  address = '".mysqli_real_escape_string($con, $_POST['address'])."',
			  gender = '".mysqli_real_escape_string($con, $_POST['gender'])."',
			  personal_id = '".mysqli_real_escape_string($con, $_POST['personal_id'])."',
			  fees = '".mysqli_real_escape_string($con, $_POST['fees'])."',
			  issue_date = '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['issue_date'])))."',
			  expire_date = '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expire_date'])))."',
			  plate_no = '".mysqli_real_escape_string($con, $plateno)."',
			  plate_type = '".mysqli_real_escape_string($con, $_POST['plate_type'])."',
			  code = '".mysqli_real_escape_string($con, $_POST['code'])."',
			  vehicle = '".mysqli_real_escape_string($con, $_POST['vehicle'])."',
			  origin = '".mysqli_real_escape_string($con, $_POST['origin'])."',
			  weight = '".mysqli_real_escape_string($con, $_POST['weight'])."',
			  engine_no = '".mysqli_real_escape_string($con, $_POST['engine_no'])."',
			  v_type = '".mysqli_real_escape_string($con, $_POST['v_type'])."',
			  color = '".mysqli_real_escape_string($con, $_POST['color'])."',
			  hp = '".mysqli_real_escape_string($con, $_POST['hp'])."',
			  chassis_no = '".mysqli_real_escape_string($con, $_POST['chassis_no'])."',
			  model = '".mysqli_real_escape_string($con, $_POST['model'])."',
			  cylinder = '".mysqli_real_escape_string($con, $_POST['cylinder'])."',
			  comments = '".mysqli_real_escape_string($con, $_POST['comments'])."',
			  issue_place = '".mysqli_real_escape_string($con, $_POST['issue_place'])."',
			  updated_time = '".date('Y-m-d')."',
			  status = 1
			 where
			   id = '".mysqli_real_escape_string($con, $_POST['update_vehicle_record'])."'
			 ";

	if(mysqli_query($con, $sql))
	{
	     $_SESSION['success'] = 'Record updated successfully.';
	}
	else{
			 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	}
	header('location:../vehicles.php');	
	
} //insert from card list..........
else if(isset($_POST['cl_form_add']))  
{   // cl_owner    cl_nationality   cl_issue_date cl_expire_date  cl_plate_no  cl_origin cl_v_type  cl_color
                              //   cl_chassis_no   cl_model   cl_issue_place  cl_passengers  
	$sql = "INSERT into tbl_vehicles
			 (Owner, nationality, issue_date, expire_date, plate_no,  origin,  
			  v_type, color,  chassis_no, model, issue_place, passengers, updated_time, status)
			 values
			 ('".mysqli_real_escape_string($con, $_POST['cl_owner'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_nationality'])."',
			  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['cl_issue_date'])))."',
			  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['cl_expire_date'])))."',
			  '".mysqli_real_escape_string($con, $_POST['cl_plate_no'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_origin'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_v_type'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_color'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_chassis_no'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_model'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_issue_place'])."',
			  '".mysqli_real_escape_string($con, $_POST['cl_passengers'])."',
			  '".date('Y-m-d')."',
			  1
			 )
			 ";
	if(mysqli_query($con, $sql))
	{
	     // update used receipt status in receipt table
		 $_SESSION['success'] = 'New record has been added';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../vehicles.php?section=card_list');					 
	
	
}
// Ajax Pagination
else if(isset($_POST['action']) && $_POST['action'] == 'vehicles_ajax_pagination' && isset($_POST['page']))
{
    $pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = $pagination_data['per_page'];; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_statement']) && $_SESSION['search_statement'] != '')
	    $statement = $_SESSION['search_statement'];
	else	
		$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->plate_no.'</td>
					<td>'.$rec->Owner.'</td>
					<td>'.$rec->nationality.'</td>
					<td>'.$rec->issue_place.'</td>
					<td>'.$rec->expire_date.'</td>
					<td>'.$rec->model.'</td>
					<td>'.$rec->color.'</td>
					<td>'.$rec->chassis_no.'</td>
					<td><a href="?section=vehicle_search&search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
// 
else if(isset($_POST['action']) && $_POST['action'] == 'vehicles_cardlist_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	if(isset($_SESSION['search_card_statement']) && $_SESSION['search_card_statement'] != '')
	    $statement = $_SESSION['search_card_statement'];
	else	
		$statement = $_SESSION['vehicle_card_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->plate_no.'</td>
					<td>'.$rec->Owner.'</td>
					<td>'.$rec->nationality.'</td>
					<td>'. date('d/m/Y', strtotime($rec->issue_date)).'</td>
					<td>'.$rec->issue_place.'</td>
					<td>'. date('d/m/Y', strtotime($rec->expire_date)).'</td>
					<td>'.$rec->model.'</td>
					<td>'.$rec->color.'</td>  
					<td>'.$rec->v_type.'</td>
					<td>'.$rec->origin.'</td>
					<td>'.$rec->passengers.'</td> 
					<td>'.$rec->chassis_no.'</td>
					<td><a href="?cardlist_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit"></a>
					    <a href="?search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a>
					</td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_card_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
// search section      s_v_name  s_v_number s_v_nationality
else if(isset($_POST['s_v_name']) || isset($_POST['s_v_number']) || isset($_POST['v_type']) || isset($_POST['v_contact']))      // Search records
{
	$where = '';
	if(isset($_POST['s_v_name']) && $_POST['s_v_name'] != '')
	   $where .= ' Owner LIKE "%'.mysqli_real_escape_string($con, $_POST['s_v_name']).'%" ';
	if(isset($_POST['s_v_number']) && $_POST['s_v_number'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' plate_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_v_number']).'%" ';  
	}
	if(isset($_POST['v_type']) && $_POST['v_type'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' v_type LIKE "%'.mysqli_real_escape_string($con, $_POST['v_type']).'%" ';  
	}
	if(isset($_POST['v_contact']) && $_POST['v_contact'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' mobile_no LIKE "%'.mysqli_real_escape_string($con, $_POST['v_contact']).'%" ';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_vehicles where'.$where.' ';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from tbl_vehicles where'.$where.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		{  
		
		   $result .= '<tr>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->Owner.'</td>
						<td>'.$rec->nationality.'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'.$rec->expire_date.'</td>
						<td>'.$rec->model.'</td>
						<td>'.$rec->color.'</td>
						<td>'.$rec->chassis_no.'</td>
						<td><a href="?section=vehicle_search&search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a></td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_statement'] = $statement;
		
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}// Search Card List ...........  s_v_card_name    s_v_card_from_date   v_card_to_date   
else if(isset($_POST['s_v_card_name']) || (isset($_POST['s_v_card_from_date']) && isset($_POST['v_card_to_date'])))      // Search records
{
	$where = ' status = 1 and updated_time > DATE_SUB(NOW(), INTERVAL 7 day) ';
	if(isset($_POST['s_v_card_name']) && $_POST['s_v_card_name'] != '')
	{
		if($where != '')
	      $where .=' AND ';	
	    $where .= ' (Owner LIKE "%'.mysqli_real_escape_string($con, $_POST['s_v_card_name']).'%" )';
	}
	if(isset($_POST['s_v_card_from_date']) && $_POST['s_v_card_from_date'] != '' && isset($_POST['v_card_to_date']) && $_POST['v_card_to_date'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' (issue_date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_v_card_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['v_card_to_date']))).'" )';  
	}
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_vehicles where'.$where.' ORDER BY updated_time';
		//$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from tbl_vehicles where '.$where.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		{  
		
		   $result .= '<tr>
						<td>'.$rec->plate_no.'</td>
						<td>'.$rec->Owner.'</td>
						<td>'.$rec->nationality.'</td>
						<td>'. date('d/m/Y', strtotime($rec->issue_date)).'</td>
						<td>'.$rec->issue_place.'</td>
						<td>'. date('d/m/Y', strtotime($rec->expire_date)).'</td>
						<td>'.$rec->model.'</td>
						<td>'.$rec->color.'</td>  
						<td>'.$rec->v_type.'</td>
						<td>'.$rec->origin.'</td>
						<td>'.$rec->passengers.'</td> 
						<td>'.$rec->chassis_no.'</td>
						<td>
						  <a href="?cardlist_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit"></a>
						  <a href="?search_vehicle_no='.$rec->plate_no.'" class="fa fa-print"></a> 
						</td>
					  </tr>';
		}
		//$pagination_data = $_SESSION['pagination_data'];
		// Storing previous statement in session
		$_SESSION['search_card_statement'] = $statement;
		
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='vehicles_card_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
}
// Remove_session_value_of_search_statement 
else if( isset($_POST['action']) &&  $_POST['action'] == 'Remove_session_value_of_search_statement')
{
	unset($_SESSION['search_statement']);
	unset($_SESSION['search_card_statement']);
	return true;
	
	
}
// Get new vehicle plate number 
else if( isset($_POST['action']) &&  $_POST['action'] == 'get_new_vehicle_plate_number')
{
	$sql = "select max(plate_no),right(max(plate_no),char_length(max(plate_no))-2)+1 As NewPlateNo from tbl_vehicles where code ='".$_POST['code']."' limit 3";
	$data = mysqli_query($con, $sql);
		
	$rec = mysqli_fetch_object($data);
	echo json_encode(array('status' => 'yes', 'NewPlateNo' => $rec->NewPlateNo));
	
}



?>