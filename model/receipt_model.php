<?php 
// Config file
require_once('../inc/config.php');

// update record
if(isset($_GET['id']))
{  
	$rec_id = base64_decode($_GET['id']);
    $check = mysqli_query($con, 'select id from tbl_receipts where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))
	{  // receipt_no = "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
		$user_data = $_SESSION['logged_in_user_data'];
		$sql = 'UPDATE tbl_receipts 
		 		SET
	             received_from = "'.mysqli_real_escape_string($con, $_POST['received_from']).'",
				 receipt_no = "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
				 amount = "'.mysqli_real_escape_string($con, $_POST['amount']).'",
				 for_opt = "'.mysqli_real_escape_string($con, $_POST['for_opt']).'",
				 comments = "'.mysqli_real_escape_string($con, $_POST['comments']).'",
				 date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date']))).'",
				 updatedBy = '.$user_data->id.'
				WHERE id = '.$rec_id.'
				'; 
		if(mysqli_query($con, $sql))
			 $_SESSION['success'] = 'Record has been Updated';
		else	 		 
			 $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';		 
	}
	else	 		 
		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';	
	header('location:../index.php');	
}
else if(isset($_POST['receipt_no']) && isset($_POST['received_from']) && isset($_POST['amount']))
{   
	$user_data = $_SESSION['logged_in_user_data'];
	$sql = 'INSERT into tbl_receipts
	        (receipt_no, date,  received_from, amount, for_opt,  comments, createdBy, updatedBy)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['date']))).'",
			 "'.mysqli_real_escape_string($con, $_POST['received_from']).'",
			 "'.mysqli_real_escape_string($con, $_POST['amount']).'",
			 "'.mysqli_real_escape_string($con, $_POST['for_opt']).'",
			  "'.mysqli_real_escape_string($con, $_POST['comments']).'",
			  '.$user_data->id.',
			  '.$user_data->id.'
			 )'; 
	//echo $sql;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	     $_SESSION['success'] = 'New record has been added';
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php');	
}
else if(isset($_GET['delid']))  // delete record
{
	$rec_id = base64_decode($_GET['delid']);
    $check = mysqli_query($con, 'select id,status from tbl_receipts where id = '.$rec_id.' ');
    $check_data = @mysqli_fetch_object($check);
	if(!empty($check_data))
	{		 
		 if($check_data->status == 1)
		 {		 
		 	@mysqli_query($con, 'DELETE from tbl_receipts where id = '.$rec_id.' and status = 1');
		 	$_SESSION['success'] = 'Record has been deleted';
		}
		else
		{
			$_SESSION['error'] = 'ERROR ! Receipt number used already!';
		}
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../index.php');	 
}   /// search section
else if(isset($_POST['search_name']) || isset($_POST['s_receipt_no']) || isset($_POST['s_from_date']) || isset($_POST['s_to_date']))      // Search records
{
	$where = '';
	if(isset($_POST['search_name']) && $_POST['search_name'] != '')
	   $where .= ' r.received_from LIKE "%'.mysqli_real_escape_string($con, $_POST['search_name']).'%" ';
	if(isset($_POST['s_receipt_no']) && $_POST['s_receipt_no'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' r.receipt_no LIKE "%'.mysqli_real_escape_string($con, $_POST['s_receipt_no']).'%" ';  
	}
	if(isset($_POST['s_from_date']) && $_POST['s_from_date'] != '' && isset($_POST['s_to_date']) && $_POST['s_to_date'] != '')
	{
	   if($where != '')
	      $where .=' AND ';	
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$statement = ' tbl_receipts r
					  left join tbl_users u
					   on u.id = r.updatedBy
					  where'.$where.' ';
		$_SESSION['receipt_search_statement'] = $statement;
		$page = 1;
		$per_page = 10; // Set how many records do you want to display per page.
		$startpoint = ($page * $per_page) - $per_page;
		$sql = 'select r.*,u.username from '.$statement.'  LIMIT '.$startpoint.' , '.$per_page.' ';
		$data = mysqli_query($con, $sql);
		
		while($rec = mysqli_fetch_object($data))
		 {
		      if(strlen($rec->comments) > 15)
				  $comment = substr($rec->comments,0,15).'...';
			  else
			      $comment = $rec->comments; 	
			  if($rec->status == 1)
			     $del_btn = '<a href="model/receipt_model.php?delid='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash"></a>';    
			  else
			     $del_btn = '';	
			  $result .= '<tr>
							<td>'.$rec->receipt_no.'</td>
							<td>'.date('d M, Y', strtotime($rec->date)).'</td>
							<td>'.$rec->received_from.'</td>
							<td>'.$rec->for_opt.'</td>  
							<td>$'.$rec->amount.'</td>
							<td>'.$rec->username.'</td>
							<td>
							  <a href="?id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
							  </a>
							</td>
							<td>
							  '.$del_btn.'
							</td>
						  </tr>';
		 }
		 $paginaton = ajax_pagination($statement,$per_page,$page,$url='receipt_ajax_pagination', $con);
		 echo json_encode(array('result' => $result, 'pagination' => $paginaton));
	}
	else
		echo '';
} // ajax pagination after search results
else if(isset($_POST['action']) && $_POST['action'] == 'receipt_ajax_pagination' && isset($_POST['page']))
{
    //$pagination_data = $_SESSION['pagination_data'];	
	$page = $_POST['page'];
	$per_page = 10; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['receipt_search_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT r.*,u.username FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{
		  if(strlen($rec->comments) > 15)
			  $comment = substr($rec->comments,0,15).'...';
		  else
			  $comment = $rec->comments;
		  if($rec->status == 1)
			 $del_btn = '<a href="model/receipt_model.php?delid='.base64_encode($rec->id).'" onclick="return confirm(\'Are you sure, you want to delete this record ?\');" class="glyphicon glyphicon-trash"></a>';    
		  else
			 $del_btn = '';	   	  
		  $result .= '<tr>
						<td>'.$rec->receipt_no.'</td>
						<td>'.date('d-m-y', strtotime($rec->date)).'</td>
						<td>'.$rec->received_from.'</td>
						<td>'.$rec->for_opt.'</td>  
						<td>$'.$rec->amount.'</td>
						<td>'.$rec->username.'</td>
						<td>
						  <a href="?id='.base64_encode($rec->id).'" class="glyphicon glyphicon-edit">
						  </a>
						</td>
						<td>
						  '.$del_btn.'
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
else if(isset($_POST['action']) && $_POST['action'] == 'validate_receipt_no' && isset($_POST['receipt_no']) && $_POST['receipt_no'] != '')
{
	$check = mysqli_query($con, 'select id from tbl_receipts where receipt_no = '.mysqli_real_escape_string($con,$_POST['receipt_no']).'');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))	
	     echo 'yes';
	else 
	     echo 'no'; 	  
}
else
{
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../index.php');
}


?>