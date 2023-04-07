<?php 
// Config file
require_once('../inc/config.php');

// addd vehicle type
if(isset($_POST['add_v_type']))
{
	$sql = "INSERT into tbl_vehicle_types
			 (vehicle_type)
		    values
			 ('".mysqli_real_escape_string($con, $_POST['v_type'])."')
			";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');				 	 
}  // addd vehicle origin //   
else if(isset($_POST['add_v_origin']))
{
	$sql = "INSERT into tbl_v_origin
			 (name)
		    values
			 ('".mysqli_real_escape_string($con, $_POST['v_origin'])."')
			";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');				 	 
}   
// addd plate type //   
else if(isset($_POST['add_plate_type']))
{
	$sql = "INSERT into tbl_plate_types
			 (plate_type)
		    values
			 ('".mysqli_real_escape_string($con, $_POST['plate_type'])."')
			";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');				 	 
}    
// addd plate code //   
else if(isset($_POST['add_plate_code']))
{
	$sql = "INSERT into tbl_vehicle_plate_codes
			 (vehicle_plate_code, digits)
		    values
			 ('".mysqli_real_escape_string($con, $_POST['plate_code'])."', '".mysqli_real_escape_string($con, $_POST['digits'])."')
			";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');				 	 
}       
// addd nationality //   
else if(isset($_POST['add_nationality']))
{
	$sql = "INSERT into tbl_country
			 (name)
		    values
			 ('".mysqli_real_escape_string($con, $_POST['nationality'])."')
			";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');				 	 
}

// delete vehicle type record
else if(isset($_GET['del_v_type']))
{
	$sql = "delete from tbl_vehicle_types where id = ".$_GET['del_v_type']."";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'Record has been deleted';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');		
}
// delete vehicle type origin
else if(isset($_GET['del_v_origin']))
{
	$sql = "delete from tbl_v_origin where country_id = ".$_GET['del_v_origin']."";
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'Record has been deleted';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');		
}
// delete vehicle type record
else if(isset($_GET['del_nationality']))
{
	$sql = "delete from tbl_country where country_id = ".$_GET['del_nationality']."";
	
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'Record has been deleted';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');		
}  
// delete plate code
else if(isset($_GET['del_plate_code']))
{
	$sql = "delete from tbl_vehicle_plate_codes where id = ".$_GET['del_plate_code']."";
	
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'Record has been deleted';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');		
}
// delete plate type
else if(isset($_GET['del_plate_type']))
{
	$sql = "delete from tbl_plate_types where id = ".$_GET['del_plate_type']."";
	
	if(mysqli_query($con, $sql))
	 	 $_SESSION['success'] = 'Record has been deleted';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	$_SESSION['master_section']	= 'master'; 
	header('location:../users.php');		
}
// Ajax Pagination
else if(isset($_POST['action']) && $_POST['action'] == 'user_master_v_type_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['users_master_v_type_pagination_data']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->vehicle_type.'</td>
					<td><a href="model/master_model.php?del_v_type='.$rec->id.'" onclick="return confirm(\'Are you sure to delete ?\');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='user_master_v_type_pag', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}  // user_master_v_origin_ajax_pagination
// Ajax Pagination
else if(isset($_POST['action']) && $_POST['action'] == 'user_master_v_origin_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['users_master_v_origin_pagination_data']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->name.'</td>
					<td><a href="model/master_model.php?del_v_origin='.$rec->country_id.'" onclick="return confirm(\'Are you sure to delete ?\');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='user_master_v_origin_pag', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}  
else if(isset($_POST['action']) && $_POST['action'] == 'user_master_p_type_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['users_master_plate_type_pagination_data']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->plate_type.'</td>
					<td><a href="model/master_model.php?del_plate_type='.$rec->id.'" onclick="return confirm(\'Are you sure to delete ?\');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='user_master_plate_type_pag', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
} 

else if(isset($_POST['action']) && $_POST['action'] == 'user_master_p_code_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['users_master_plate_code_pagination_data']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->vehicle_plate_code.'</td>
					<td>'.$rec->digits.'</td> 
					<td><a href="model/master_model.php?del_plate_code='.$rec->id.'" onclick="return confirm(\'Are you sure to delete ?\');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='user_master_p_code_pag', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}

else if(isset($_POST['action']) && $_POST['action'] == 'user_master_nationality_ajax_pagination' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['users_master_nationality_pagination_data']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->name.'</td>
					<td><a href="model/master_model.php?del_nationality='.$rec->country_id.'" onclick="return confirm(\'Are you sure to delete ?\');" class="glyphicon glyphicon-trash"></a></td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='user_master_nationality_pag', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}































?>