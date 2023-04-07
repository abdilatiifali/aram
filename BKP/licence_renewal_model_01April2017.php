<?php 
// Config file
require_once('../inc/config.php');
if(isset($_POST['action']) && $_POST['action'] == 'validate_receipt_no' && isset($_POST['receipt_no']) && $_POST['receipt_no'] != '')
{
	$check = mysqli_query($con, 'select * from tbl_receipts where receipt_no = '.mysqli_real_escape_string($con,$_POST['receipt_no']).' and status = 1 ');
    $check_data = @mysqli_fetch_object($check);
    if(!empty($check_data))	
	     echo 'yes';
	else 
	     echo 'no'; 	  
}
else if(isset($_POST['licence_renewal_form_data']) && isset($_POST['licence_renewal_licence_no']) && $_POST['licence_renewal_licence_no'] != '')
{
	//licence_no receipt_no amount renewal_type renewal_date expire_date 
	//licence_renewal_licence_no receipt_no  amount renewal_type renewal_date expire_date 
	$sql = 'INSERT into tbl_licence_renewal
	        (licence_no, receipt_no, amount, renewal_type, renewal_date, expire_date, username)
			VALUES
			("'.mysqli_real_escape_string($con, $_POST['licence_renewal_licence_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['receipt_no']).'",
			 "'.mysqli_real_escape_string($con, $_POST['amount']).'",
			 "'.mysqli_real_escape_string($con, $_POST['renewal_type']).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['renewal_date']))).'",
			 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expire_date']))).'",
			 "'.$_SESSION['USERNAME'].'",
			 )'; 
	//echo $sql;
	//mysqli_query($con, $sql); exit;		 
	if(mysqli_query($con, $sql))
	{
		 mysqli_query($con, "Update tbl_driver_detail 
		 					set
							   issue_date =  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['renewal_date'])))."',
							   expiry_date =  '".date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expire_date'])))."',
							   updated_time = '".date('Y-m-d')."',
							   status = 1
							where
							    licence_no = '".mysqli_real_escape_string($con, $_POST['licence_renewal_licence_no'])."'
							");	   
		 // update used receipt status in receipt table
		 mysqli_query($con, "update tbl_receipts
		 					 set
							   status = 0
							 where 
							 	receipt_no = '".mysqli_real_escape_string($con,$_POST['receipt_no'])."' 
						     ");					
	     echo 'yes';
	}
	else	 		 
	     echo 'No';
}
// ajax pagination of licence renewal
else if(isset($_POST['action']) && $_POST['action'] == 'licence_ajax_pagination_renewal_list' && isset($_POST['page']))
{
    $page = $_POST['page'];
	$per_page = 5; // Set how many records do you want to display per page.
	$startpoint = ($page * $per_page) - $per_page;
	$statement = $_SESSION['licence_renewal_statement'];
	//$statement = $pagination_data['current_statement']; // Change `records` according to your table name.
	//$con = $pagination_data['db_con'];
	$data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");		
	$result = '';	 
	while($rec = mysqli_fetch_object($data))
	{  //      
		  $renewal_type = '';
		   if($rec->renewal_type == 1)
			   $renewal_type = 'For Expire';
		   else	if($rec->renewal_type == 2)
			   $renewal_type = 'For Damage';
		   else if($rec->renewal_type == 3)
			   $renewal_type = 'For Lost';
		   	   	
		  $result .= '<tr>
						<td>'.$rec->receipt_no.'</td>
						<td>'.number_format($rec->amount,2).'</td> 
						<td>'.$renewal_type.'</td>
						<td>'.date('d/m/Y', strtotime($rec->renewal_date)).'</td>
						<td>'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
						<td><a href="javascript:void(0)" style="color: red" onclick="licence_renewal_delete_record('.$rec->id.');" class="fa fa-trash"></a></td>
					  </tr>';
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_renewal_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
}
// Get latest data of licence renewal....
else if(isset($_POST['action']) && $_POST['action'] == 'latest_date_for_licence_renewal' && isset($_POST['licence_no']) && $_POST['licence_no'] != '')
{
    $page = 1;
    $per_page = 5; // Set how many records do you want to display per page.
    $startpoint = ($page * $per_page) - $per_page;
    $statement = "`tbl_licence_renewal` where licence_no = '".mysqli_real_escape_string($con, $_POST['licence_no'])."'  ORDER BY `id` DESC"; // Change `records` according to your table name.
    $licence_renew = mysqli_query($con, "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
    $result = '';	
	if(mysqli_num_rows($licence_renew) > 0)
	{
		while($rec = mysqli_fetch_object($licence_renew))
		{  //      
			  $renewal_type = '';
			   if($rec->renewal_type == 1)
				   $renewal_type = 'For Expire';
			   else	if($rec->renewal_type == 2)
				   $renewal_type = 'For Damage';
			   else if($rec->renewal_type == 3)
				   $renewal_type = 'For Lost';	
			  $result .= '<tr>
							<td>'.$rec->receipt_no.'</td>
							<td>'.number_format($rec->amount,2).'</td> 
							<td>'.$renewal_type.'</td>
							<td>'.date('d/m/Y', strtotime($rec->renewal_date)).'</td>
							<td>'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
							<td><a href="javascript:void(0)" style="color: red" onclick="licence_renewal_delete_record('.$rec->id.');" class="fa fa-trash"></a></td>
						  </tr>';
		}
	}
	else
	{
	    $result = '<tr><td colspan="6" style="color:red;">No record found</td></tr>';	
	}
	$paginaton = ajax_pagination($statement,$per_page,$page,$url='licence_renewal_pagination', $con);
	echo json_encode(array('result' => $result, 'pagination' => $paginaton));
} // delete record...
else if(isset($_POST['action']) && $_POST['action'] == 'licence_renewal_delete_record' && isset($_POST['recordID']) && $_POST['recordID'] != '')
{
	$check = mysqli_query($con, 'delete from tbl_licence_renewal where id = '.mysqli_real_escape_string($con,$_POST['recordID']).'');
    $check_data = @mysqli_fetch_object($check);
    echo 'yes';
		  
}
else
{
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../licence.php');
}


?>