<?php 
// Config file
require_once('../inc/config.php');

// Updateing user accounts
if(isset($_GET['id']) && isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != '' && isset($_POST['curpass']))
{   
	// Check validity of current password of logged in user / admin..
	if(isset($_POST['curpass']))
	{
		// validation of password...
		$logged_in_user = $_SESSION['logged_in_user_data'];
		if(strlen($logged_in_user->location) == 15)
			$p = $logged_in_user->password;
		else
			$p = base64_decode($logged_in_user->password);
		
		if($_POST['curpass'] == $p)
		{
			$is_admin_valid = 1;
		}
		else
		    $is_admin_valid = 0;
		//......................
		//   ...
		
		// if admin password is valid..  
		if($is_admin_valid == 1)
		{    
			
			$rec_id = base64_decode($_GET['id']);
			$check = mysqli_query($con, 'select id from tbl_users where id = '.$rec_id.'');
			$check_data = @mysqli_fetch_object($check);
			if(!empty($check_data))
			{  
				if(strlen($_POST['location']) == 15)
				    $password = mysqli_real_escape_string($con, $_POST['password']);
				else
				    $password = base64_encode(mysqli_real_escape_string($con, $_POST['password']));	
				$sql = 'UPDATE tbl_users 
						SET
						 username = "'.mysqli_real_escape_string($con, $_POST['username']).'",
						 password = "'.$password.'",
						 date_created = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['datecreated']))).'",
						 expire_date = "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiredate']))).'",
						 location = "'.mysqli_real_escape_string($con, $_POST['location']).'",
						 status = "'.mysqli_real_escape_string($con, $_POST['status']).'"
						WHERE id = '.$rec_id.'
						'; 
				//mysqli_query($con, $sql); exit;		 
				if(mysqli_query($con, $sql))
				{
					$user_id = $rec_id;
					// delete preivious records..
					if(isset($_POST['is_privileges']) && $_POST['is_privileges'] == 1 && $logged_in_user->id ==1)
					{   
						@mysqli_query($con, 'DELETE from tbl_user_permissions where user_id = '.$rec_id.'');
						for($i = 1; $i <= 7; $i++)
						{  //         
							if($i == 1)
							{
								$r = isset($_POST['receipt_r']) ?  mysqli_real_escape_string($con, $_POST['receipt_r']) : 0;
								$w = isset($_POST['receipt_w']) ?  mysqli_real_escape_string($con, $_POST['receipt_w']) : 0;
								$e = isset($_POST['receipt_e']) ?  mysqli_real_escape_string($con, $_POST['receipt_e']) : 0;
							}
							else if($i == 2)
							{
								$r = isset($_POST['vehicle_r']) ?  mysqli_real_escape_string($con, $_POST['vehicle_r']) : 0;
								$w = isset($_POST['vehicle_w']) ?  mysqli_real_escape_string($con, $_POST['vehicle_w']) : 0;
								$e = isset($_POST['vehicle_e']) ?  mysqli_real_escape_string($con, $_POST['vehicle_e']) : 0;
							}
							else if($i == 3)
							{
								$r = isset($_POST['users_r']) ?  mysqli_real_escape_string($con, $_POST['users_r']) : 0;
								$w = isset($_POST['users_w']) ?  mysqli_real_escape_string($con, $_POST['users_w']) : 0;
								$e = isset($_POST['users_e']) ?  mysqli_real_escape_string($con, $_POST['users_e']) : 0;
							}
							else if($i == 4)
							{
								$r = isset($_POST['reports_r']) ?  mysqli_real_escape_string($con, $_POST['reports_r']) : 0;
								$w = isset($_POST['reports_w']) ?  mysqli_real_escape_string($con, $_POST['reports_w']) : 0;
								$e = isset($_POST['reports_e']) ?  mysqli_real_escape_string($con, $_POST['reports_e']) : 0;
							}
							else if($i == 5)
							{
								$r = isset($_POST['licence_r']) ?  mysqli_real_escape_string($con, $_POST['licence_r']) : 0;
								$w = isset($_POST['licence_w']) ?  mysqli_real_escape_string($con, $_POST['licence_w']) : 0;
								$e = isset($_POST['licence_e']) ?  mysqli_real_escape_string($con, $_POST['licence_e']) : 0;
							}
							else if($i == 6)
							{
								$r = isset($_POST['v_transfer_r']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_r']) : 0;
								$w = isset($_POST['v_transfer_w']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_w']) : 0;
								$e = isset($_POST['v_transfer_e']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_e']) : 0;
							}
							else if($i == 7)
							{
								$r = isset($_POST['fines_r']) ?  mysqli_real_escape_string($con, $_POST['fines_r']) : 0;
								$w = isset($_POST['fines_w']) ?  mysqli_real_escape_string($con, $_POST['fines_w']) : 0;
								$e = isset($_POST['fines_e']) ?  mysqli_real_escape_string($con, $_POST['fines_e']) : 0;
							}
							
							// insert data into user permission table
							if(isset($r) && isset($w) && isset($e))
							{
								$u_p = 'INSERT into tbl_user_permissions
										(user_id, R, W, E, module)
										VALUES
										("'.$user_id.'",
										 "'.$r.'",
										 "'.$w.'",
										 "'.$e.'",
										 "'.$i.'"
										 )';
								mysqli_query($con, $u_p);
							}
						}
					}
					$_SESSION['success'] = 'User record has been Updated';
				}
				else	 		 
					$_SESSION['error'] = 'ERROR ! Something wrong, please try again.1';	
			
			}
			else	 		 
	     		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.2';
		}
		else	 		 
	  		$_SESSION['error'] = 'ERROR ! You password is invalid..';
	}
	else	 		 
	  $_SESSION['error'] = 'ERROR ! Please enter your password..';
	  
	header('location:../users.php');  
	die();
}
// Creating User accounts
if(isset($_POST['username']) && $_POST['username'] != '' && isset($_POST['password']) && $_POST['password'] != '' && isset($_POST['curpass']) && !isset($_GET['id']))
{
	
	// Check validity of current password of logged in user / admin..
	if(isset($_POST['curpass']))
	{
		// validation of password...
		$logged_in_user = $_SESSION['logged_in_user_data'];
		if(strlen($logged_in_user->location) == 15)
			$p = $logged_in_user->password;
		else
			$p = base64_decode($logged_in_user->password);
		if($_POST['curpass'] == $p)
		{
			$is_admin_valid = 1;
		}
		else
		    $is_admin_valid = 0;
		//   ...
		// if admin password is valid..  
		if($is_admin_valid == 1)
		{  
			//echo strlen($_POST['location']); exit;
			if(strlen($_POST['location']) == 15)
				$password = mysqli_real_escape_string($con, $_POST['password']);
			else
				$password = base64_encode(mysqli_real_escape_string($con, $_POST['password']));
			$sql = 'INSERT into tbl_users
					(username, password, date_created, expire_date, location, status)
					VALUES
					("'.mysqli_real_escape_string($con, $_POST['username']).'",
					 "'.$password.'",
					 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['datecreated']))).'",
					 "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['expiredate']))).'",
					 "'.mysqli_real_escape_string($con, $_POST['location']).'",
					 "'.mysqli_real_escape_string($con, $_POST['status']).'"
					 )'; 
			//echo $sql;
			//mysqli_query($con, $sql); exit;		 
			if(mysqli_query($con, $sql))
			{   // licence_r   v_transfer_r  fines_r
				$user_id = mysqli_insert_id($con);
				for($i = 1; $i <= 7; $i++)
				{  //         
					if($i == 1)
					{
						$r = isset($_POST['receipt_r']) ?  mysqli_real_escape_string($con, $_POST['receipt_r']) : 0;
						$w = isset($_POST['receipt_w']) ?  mysqli_real_escape_string($con, $_POST['receipt_w']) : 0;
						$e = isset($_POST['receipt_e']) ?  mysqli_real_escape_string($con, $_POST['receipt_e']) : 0;
					}
					else if($i == 2)
					{
						$r = isset($_POST['vehicle_r']) ?  mysqli_real_escape_string($con, $_POST['vehicle_r']) : 0;
						$w = isset($_POST['vehicle_w']) ?  mysqli_real_escape_string($con, $_POST['vehicle_w']) : 0;
						$e = isset($_POST['vehicle_e']) ?  mysqli_real_escape_string($con, $_POST['vehicle_e']) : 0;
					}
					else if($i == 3)
					{
						$r = isset($_POST['users_r']) ?  mysqli_real_escape_string($con, $_POST['users_r']) : 0;
						$w = isset($_POST['users_w']) ?  mysqli_real_escape_string($con, $_POST['users_w']) : 0;
						$e = isset($_POST['users_e']) ?  mysqli_real_escape_string($con, $_POST['users_e']) : 0;
					}
					else if($i == 4)
					{
						$r = isset($_POST['reports_r']) ?  mysqli_real_escape_string($con, $_POST['reports_r']) : 0;
						$w = isset($_POST['reports_w']) ?  mysqli_real_escape_string($con, $_POST['reports_w']) : 0;
						$e = isset($_POST['reports_e']) ?  mysqli_real_escape_string($con, $_POST['reports_e']) : 0;
					}
					else if($i == 5)
					{
						$r = isset($_POST['licence_r']) ?  mysqli_real_escape_string($con, $_POST['licence_r']) : 0;
						$w = isset($_POST['licence_w']) ?  mysqli_real_escape_string($con, $_POST['licence_w']) : 0;
						$e = isset($_POST['licence_e']) ?  mysqli_real_escape_string($con, $_POST['licence_e']) : 0;
					}
					else if($i == 6)
					{
						$r = isset($_POST['v_transfer_r']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_r']) : 0;
						$w = isset($_POST['v_transfer_w']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_w']) : 0;
						$e = isset($_POST['v_transfer_e']) ?  mysqli_real_escape_string($con, $_POST['v_transfer_e']) : 0;
					}
					else if($i == 7)
					{
						$r = isset($_POST['fines_r']) ?  mysqli_real_escape_string($con, $_POST['fines_r']) : 0;
						$w = isset($_POST['fines_w']) ?  mysqli_real_escape_string($con, $_POST['fines_w']) : 0;
						$e = isset($_POST['fines_e']) ?  mysqli_real_escape_string($con, $_POST['fines_e']) : 0;
					}
					
					// insert data into user permission table
					if(isset($r) && isset($w) && isset($e))
					{
						$u_p = 'INSERT into tbl_user_permissions
								(user_id, R, W, E, module)
								VALUES
								("'.$user_id.'",
								 "'.$r.'",
								 "'.$w.'",
								 "'.$e.'",
								 "'.$i.'"
								 )';
						mysqli_query($con, $u_p);
					}
				}
				$_SESSION['success'] = 'New User record has been added';
		    }
			else	 		 
	     		$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
		}
		else	 		 
	  		$_SESSION['error'] = 'ERROR ! You password is invalid..';
	}
	else	 		 
	  $_SESSION['error'] = 'ERROR ! Please enter your password..';
	  
	header('location:../users.php');  
}
else if(isset($_GET['delid']))  // delete record
{
	$rec_id = base64_decode($_GET['delid']);
    $check = mysqli_query($con, 'select id from tbl_users where id = '.$rec_id.'');
    $check_data = @mysqli_fetch_object($check);
	if(!empty($check_data))
	{
		 @mysqli_query($con, 'DELETE from tbl_user_permissions where user_id = '.$rec_id.'');
		 @mysqli_query($con, 'DELETE from tbl_users where id = '.$rec_id.'');
		 $_SESSION['success'] = 'Record has been deleted';
	}
	else	 		 
	     $_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
	header('location:../users.php');	 
}
else
{
	$_SESSION['error'] = 'ERROR ! Something wrong, please try again.';
    header('location:../users.php');
}








?>