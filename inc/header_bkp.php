<?php
// check user is logged in or not....
if(!isset($_SESSION['user_logged_in']))
{
	header('location:login/index.php');
	die();
}
require_once("constants.php");
echo $issueplace[1];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title><?php echo TITLE;?></title>
    <meta name="viewport" content="width=device-width">
    <link href="assets/css/bootstrap-combined.no-icons.min.css" rel="stylesheet">
    <link href="assets/css/font-awesome.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" >
    <!--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
-->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" >
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
	<script src="assets/js/jquery.min.js"></script>

  <!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">-->
   <link rel="stylesheet" href="assets/calendar/jquery.datepicker.css">
   <script src="assets/calendar/jquery.datepicker.js"></script>
   
    <link rel="stylesheet" href="assets/css/main.css">
    <style>
	.page_info { margin: 10px;}
	.current{
		color: #fff !important;
		cursor: default !important;
		background-color: #337ab7 !important;
		border-color: #337ab7 !important;
	 }
	</style>
  </head>
  <body>

    <div class="fluid">
      <header class="navbar-fixed-top">
        <span class="logo">
          <a href="#">
            <img src="assets/img/logo-flag.png"/>
          </a>
          <a href="#">
            <img src="assets/img/logo2.jpg"/>
          </a>
        </span>

      </header>
     <?php $user_privileges = $_SESSION['logged_in_user_privileges'];
	      // echo '<pre>'; print_r($_SESSION['logged_in_user_data']); exit;
	  ?>
      <div id="leftWrapper">
        <div id="listView" class="list">
          <div class="toggler">
            <div class="fa fa-navicon">
            </div>
          </div>
          <?php if(isset($user_privileges[1]) && ( $user_privileges[1]['r'] == 1 || $user_privileges[1]['w'] == 1 || $user_privileges[1]['e'] == 1)){ ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'index.php'){ ?>  class="list-item-active" <?php } ?>>
            <a href="index.php">Receipts
              <div class="fa fa-file-text-o">
              </div>
            </a>
          </li>
          <?php } ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'licence.php'){ ?>  class="list-item-active" <?php } ?>>
          	<a href="licence.php">Licence
            	<div class="fa fa-list-alt"></div>
            </a>
          </li>
          <?php if(isset($user_privileges[2]) && ( $user_privileges[2]['r'] == 1 || $user_privileges[2]['w'] == 1 || $user_privileges[2]['e'] == 1)){ ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'vehicles.php'){ ?>  class="list-item-active" <?php } ?>>
            <a href="vehicles.php">Vehicles
              <div class="fa fa-car">
              </div>
            </a>
          </li>
          <?php } ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'vehicle_transfer.php'){ ?>  class="list-item-active" <?php } ?>>
          	<a href="vehicle_transfer.php">Vehicle Transfer<div class="fa fa-exchange"></div></a>
          </li>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'traffic.php'){ ?>  class="list-item-active" <?php } ?>>
          	<a href="traffic.php">Traffic Fines<div class="fa fa-navicon"></div></a>
          </li>
          <?php if(isset($user_privileges[3]) && ( $user_privileges[3]['r'] == 1 || $user_privileges[3]['w'] == 1 || $user_privileges[3]['e'] == 1)){ ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'users.php'){ ?>  class="list-item-active" <?php } ?>>
            <a href="users.php">
              <div class="fa fa-user">
              </div>Users & Masters
            </a>
          </li>
          <?php } ?>
          <?php if(isset($user_privileges[4]) && ( $user_privileges[4]['r'] == 1 || $user_privileges[4]['w'] == 1 || $user_privileges[4]['e'] == 1)){ ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'reports.php'){ ?>  class="list-item-active" <?php } ?>>
            <a href="reports.php">
              <div class="fa fa-laptop">
              </div>Reports & Statistics
            </a>
          </li>
          <?php } ?>
          <li <?php if(basename($_SERVER['PHP_SELF']) == 'settings.php'){ ?>  class="list-item-active" <?php } ?>>
            <a href="settings.php">Setting
              <div class="fa fa-car">
              </div>
            </a>
          </li>
          <li class="last-child">
            <a href="logout.php">
              <div class="fa fa-power-off">
              </div>Logout
            </a>
          </li>
        </div>
      </div>
