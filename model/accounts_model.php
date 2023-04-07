<?php 
// Config file
require_once('../inc/config.php');

// update record
if(isset($_GET['acc_id']))
{
	$rec_id = base64_decode($_GET['acc_id']);
    $check = mysqli_query($con, 'select id from tbl_account_list where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{
		$sql = 'UPDATE tbl_account_list 
		 		SET
	             acc_no = "'.mysqli_real_escape_string($con, $_POST['acc_no']).'",
				 acc_name = "'.mysqli_real_escape_string($con, $_POST['acc_name']).'",
				 amount = "'.mysqli_real_escape_string($con, $_POST['amount']).'",
				 date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date']))).'",
				 acc_type = "'.mysqli_real_escape_string($con, $_POST['acc_type']).'",
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
	header('location:../index.php?section=acc_list');	
}  
else if(isset($_POST['acc_no']) && isset($_POST['acc_name']) && isset($_POST['amount']))
{   // acc_no acc_name date acc_type amount comments

   //acc_no  acc_name date acc_type amount comments
	$sql = 'INSERT into tbl_account_list
	        (acc_no, acc_name, date, acc_type, amount, comments)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['acc_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['acc_name']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['acc_type']).'",
			 "'.mysqli_real_escape_string($con, $_POST['amount']).'",
			 "'.mysqli_real_escape_string($con, $_POST['comments']).'"
			 )'; 
	//echo $sql;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php?section=acc_list');	
}
else if(isset($_GET['del_acc_id']))  // delete record
{
	$rec_id = base64_decode($_GET['del_acc_id']);
    $check = mysqli_query($con, 'select id from tbl_account_list where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
	if(!empty($check_data))
	{
		 @mysqli_query($con, 'DELETE from tbl_account_list where id = '.$rec_id.'');
		 $_SESSION['success'] = 'Record has been deleted';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php?section=acc_list');	 
}
else if(isset($_GET['acc_t_id']))
{
	$rec_id = base64_decode($_GET['acc_t_id']);
    $check = mysqli_query($con, 'select id from tbl_acc_type where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{
		$sql = 'UPDATE tbl_acc_type 
		 		SET
	             acc_type = "'.mysqli_real_escape_string($con, $_POST['acc_type_title']).'"
				WHERE id = '.$rec_id.'
				'; 
		if(mysqli_query($con, $sql))
			 $_SESSION['success'] = 'Account type has been Updated';
		else	 		 
			 $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';		 
	}
	else	 		 
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';	
	header('location:../index.php?section=acc_list');	
}  
else if(isset($_POST['acc_type_title']) && $_POST['acc_type_title']!= '' && !isset($_GET['acc_t_id'])) // Add account type....
{   
	$sql = 'INSERT into tbl_acc_type
	        (acc_type)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['acc_type_title']).'")'; 
	//echo $sql;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New Account type has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php?section=acc_list');	
}

else if(isset($_GET['del_acc_t_id']))  // delete record
{
	$rec_id = base64_decode($_GET['del_acc_t_id']);
    $check = mysqli_query($con, 'select id from tbl_acc_type where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
	if(!empty($check_data))
	{
		 @mysqli_query($con, 'DELETE from tbl_acc_type where id = '.$rec_id.'');
		 $_SESSION['success'] = 'Account type been deleted';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php?section=acc_list');	 
}
else if(isset($_POST['action']) && $_POST['action'] == 'account_type_ajax_pagination' && isset($_POST['page']))
{
    $pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = $pagination_data['per_page'];; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  
	
	   $result .= '<tr>
					<td>'.$rec->acc_type.'</td>
					<td>
					  <a href="?section=acc_list&acc_t_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
					  </a>
					</td>
					<td>
					  <a href="model/accounts_model.php?del_acc_t_id='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash">
					  </a>
					</td>
				  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='call_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}/// search accounts list section
else if(isset($_POST['s_by_date']) && $_POST['s_by_date'] != '' && isset($_POST['action']) && $_POST['action'] == 'search_account_list_by_date')      // Search records
{
	$where = '';
	if(isset($_POST['s_by_date']) && $_POST['s_by_date'] != '')
	   $where .= ' date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_by_date']))).'" ';
	
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_account_list where'.$where.' ORDER by id DESC ';
		$_SESSION['acc_list_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select * from tbl_account_list where'.$where.' ORDER by id DESC LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		 {
		      if(strlen($rec->comments) > 15)
				  $comment = substr($rec->comments,0,15).'...';
			  else
			      $comment = $rec->comments; 	  
			  $result .= '<tr>
							<td>'.$rec->acc_no.'</td>
							<td>'.$rec->acc_name.'</td>
							<td>'.date('d M, Y', strtotime($rec->date)).'</td>
							<td>'.$rec->acc_type.'</td>
							<td>$'.$rec->amount.'</td>
							<td>'.$comment.'</td>
							<td>
							  <a href="?section=acc_list&acc_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
							  </a>
							</td>
							<td>
							  <a href="model/accounts_model.php?del_acc_id='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash">
							  </a>
							</td>
						  </tr>';
		 }
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='acc_list_ajax_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
} // ajax pagination after search results
else if(isset($_POST['action']) && $_POST['action'] == 'account_list_ajax_pagination' && isset($_POST['page']))
{
    //$pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['acc_list_search_statement']; // Change `records` according to your table name.
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
						<td>'.$rec->acc_no.'</td>
						<td>'.$rec->acc_name.'</td>
						<td>'.date('d M, Y', strtotime($rec->date)).'</td>
						<td>'.$rec->acc_type.'</td>
						<td>$'.$rec->amount.'</td>
						<td>'.$comment.'</td>
						<td>
						  <a href="?section=acc_list&acc_id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
						  </a>
						</td>
						<td>
						  <a href="model/accounts_model.php?del_acc_id='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash">
						  </a>
						</td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='acc_list_ajax_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
} // Get ammount of account   ..  action=get_account_amount_for_receipt&account_name='+account_name,
else if(isset($_POST['action']) && $_POST['action'] == 'get_account_amount_for_receipt' && isset($_POST['account_name']))
{
	if($_POST['account_name'] != '')
	{
		$get_data = mysqli_query($con, 'select amount from tbl_account_list where acc_name LIKE "%'.mysqli_real_escape_string($con, $_POST['account_name']).'%"');
    	$data = @mysqli_fetch_object($get_data);	
		echo $data->amount;
	}
	else
	  echo '';
}
else
{
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../index.php');
}


?>