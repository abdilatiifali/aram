<?php @session_start();
	unset($_SESSION['user_logged_in']);
	unset($_SESSION['logged_in_user_data']);
	unset($_SESSION['logged_in_user_privileges']);
	@session_destroy();
	header('location:index.php');
	die(); 
?>