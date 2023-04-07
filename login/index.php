<?php @session_start();
include_once('../inc/config.php');
if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] != '' && $_POST['password'] != '')
{
	$check = mysqli_query($con, 'select * from tbl_users
								 where
								 	username = "'.mysqli_real_escape_string($con, $_POST['username']).'"
								 AND
								 	password = "'.base64_encode((mysqli_real_escape_string($con, $_POST['password']))).'"
								 AND status = 1	
								 ');

	$check_data = mysqli_fetch_object($check);

//print_r($check_data->password);

	if(!empty($check_data))
	{
	     $_SESSION['user_logged_in'] = true;
		 $_SESSION['logged_in_user_data'] = $check_data;
		 $_SESSION['USERNAME']	= $check_data -> username;
		 // Get user privileges

		 $u_privilege = mysqli_query($con, 'select * from tbl_user_permissions where user_id = '.$check_data->id.' ');
		 while($rec = mysqli_fetch_object($u_privilege))
		 {
			 $privileges[$rec->module]['r'] =  $rec->R;
			 $privileges[$rec->module]['w'] =  $rec->W;
			 $privileges[$rec->module]['e'] =  $rec->E;
		 }
		 $_SESSION['logged_in_user_privileges'] = $privileges;
		 header('location:../index.php');
		 die();
	}
	else
		$_SESSION['error'] = 'ERROR ! Invalid username and password';
}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login
    </title>
    <link rel="stylesheet" href="assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/main.css">
  </head>
  <body>
    <div id="navbar">
      <img src="assets/img/login-logo.jpg"/>
      <div id="container">
        <br/>
        <div id="login-right">

          <div class="login-margin">
          </div>
          <form method="post" autocomplete="on">
            <h2>Login</h2>
          <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success" style="padding:2px;margin-top:2px;margin-bottom:0px;float:right;"><?php echo $_SESSION['success']; ?></div>
          <?php unset($_SESSION['success']); } ?>
          <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger" style="color:#F00;padding:2px;margin-top:2px;margin-bottom:0px;"><?php echo $_SESSION['error']; ?></div>
          <?php unset($_SESSION['error']);  } ?>
            <div class="username">
              <label>Username
              </label>
              <input name="username" type="text" required autofocus class="short"/>
            </div>
            <div class="pass">
              <label>Password
              </label>
              <input name="password" type="password" required class="short"/>
            </div>
            <br/>
            <div class="log-foot">
              <input type="checkbox" id="login" value="Keep me signed in"/>
              <label for="login">Keep me signed in
              </label>
              <br/>
              <button type="submit" name="login" class="btn-signin fa fa-sign-in">  Login
              </button>
            </div>
          </form>
        </div>
        <div id="login-left">
          <img src="assets/img/login-pic.png"/>
        </div>
        <div class="clear">
        </div>
        <footer>All Rights Reserved Somasoft Solutions | Copyright © 2016
        </footer>
      </div>
    </div>
  </body>
</html>
