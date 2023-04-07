<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];
?>
<style>
.pagination .page_info {display:none;}

</style>
<script>   
$(function() {
	$( "#text-short" ).datepicker({
		yearRange: '0:+20',
		minDate: 'today',
		//maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
});
 </script>
 <?php 
     if(isset($_GET['view']) && $_GET['view']	== 'user')
	      unset($_SESSION['master_section']);
     if(!isset($_GET['view']) || $_GET['view'] == '') 
         $_GET['view'] = 'user';	
		  
	   
 ?>
<div class="right-nav">
	<ul class="nav nav-tabs">
    	<li <?php if(!isset($_SESSION['master_section']) &&  (isset($_GET['view']) && $_GET['view'] == 'user')  ){ ?>class="active"<?php } ?>>
        	<a  href="?view=user">User Profile</a>
        </li>
        <li <?php if((isset($_SESSION['master_section']) && $_SESSION['master_section'] == 'master') ||  (isset($_GET['view']) && $_GET['view'] == 'master')){ ?>class="active"<?php } ?>><a  href="?view=master">Master</a></li>
        <li style="float: right;">
		 <?php if(isset($_SESSION['success'])){ ?>
            <div class="alert alert-success" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;float:right;"><?php echo $_SESSION['success']; ?></div>
          <?php unset($_SESSION['success']); } ?>
          <?php if(isset($_SESSION['error'])){ ?>
            <div class="alert alert-danger" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"><?php echo $_SESSION['error']; ?></div>
          <?php unset($_SESSION['error']);  } ?>
        </li>
    </ul>
    <div class="tab-content">
    	<div id="profile" class="tab-pane <?php if(!isset($_SESSION['master_section']) &&  (isset($_GET['view']) && $_GET['view'] == 'user')) echo 'in active'; else echo 'fade'; ?>">
            <?php
			   // Edit...
			   if(isset($_GET['id']))
			   {
				   $rec_id = base64_decode($_GET['id']);
				   $check = mysqli_query($con, 'select * from tbl_users where id = '.$rec_id.'');
				   $check_data = @mysqli_fetch_object($check);
				   //if(empty($check_data))
				       //$_SESSION['error'] = 'ERROR ! Record not available.';
			   }
	        ?>
            <?php if(isset($user_privileges[3]) && ($user_privileges[3]['w'] == 1 || ($user_privileges[3]['e'] == 1 && isset($_GET['id'])))){ ?>
        	<form role="form" id="add_new_user_form"  action="model/users_model.php<?php if(!empty($check_data)) echo '?id='.$_GET['id'];?>" method="post">
                <div class="form-inline" style="margin: 15px 0 20px;">
                    <div class="form-group custom">
                        <label for="date" class="control-label2 col-sm-4">Date Created:</label>
                        <input id="text-short" type="text" name="datecreated" onkeyup="Change_expire_date(this.value)" required class="form-control datepick" onkeypress="DateFormat(this,event.keyCode)"  value="<?php echo isset($check_data->date_created) ? date('d-m-Y', strtotime($check_data->date_created)) : date('d-m-Y'); ?>" />
                    </div>
                    <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Expire Date:</label>
                        <input id="text-short" type="text" name="expiredate" required class="form-control expiry_date datepick1" onkeypress="DateFormat(this,event.keyCode)"  value="<?php echo isset($check_data->expire_date) ? date('d-m-Y', strtotime($check_data->expire_date)) : date('d-m-Y', strtotime("+90 Day")); ?>"/>
                    </div>
                </div>
                <div class="form-inline" style="margin: 15px 0 20px;">
                    <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Current Password:</label>
                        <input id="text-short" type="password" name="curpass" required class="form-control"/>
                        <span class="desc">Enter your current password to modify your personal information</span>
                    </div>
                </div>
                <script>
				function Change_expire_date(val)
				{
					//alert(val);
					//alert($('.expiry_date').val());
					var dateAr = val.split('-');
					var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
					var someDate = new Date(newDate);
					//alert(someDate);
					var numberOfDaysToAdd = 90;
					someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
					if(!isNaN(someDate.getTime())){

						//alert(someDate);
						//alert(someDate.getDate());
						var day = someDate.getDate();
						var month = someDate.getMonth() + 1;
						if (month < 10) {
							month = "0" + month;
						}
						var year = someDate.getFullYear();
						newDate = day + '-' + month + '-' + year;
						$(".expiry_date").val(newDate);
					}
					else
					    $(".expiry_date").val('dd-mm-yy');


				}

				</script>
                <div class="stack">
                    <div class="row">
                        <div class="col">
                            <div class="form-horizontal" style="margin: 0 0 20px;">
                                <div class="form-group">
                                    <label for="date" class="control-label2 col-sm-4">Username: </label>
                                    <input id="text-middle" type="text" name="username" required="required" class="form-control" value="<?php echo isset($check_data->username) ? $check_data->username :''; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Password:</label>
                                    <input id="text-middle" <?php if(isset($check_data->password)){ ?> type="text" <?php }else{ ?> type="password" <?php } ?> name="password" required="required" class="form-control" value="<?php echo isset($check_data->password) ? base64_decode($check_data->password) : ''; ?>"/>
                                </div>
                            </div>
                        </div>
                        <div class="col2">
                            <div class="form-horizontal" style="margin: 0 0 20px;">
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Location:</label>
                                    <input id="text-middle" type="text" name="location" class="form-control" value="<?php echo isset($check_data->location) ? $check_data->location : ''; ?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Status:</label>
                                    <select id="text-middle" size="1" name="status">
                                        <option value="1" <?php if(isset($check_data->status) && $check_data->status == 1) echo 'selected'; ?>>Active</option>
                                        <option value="0" <?php if(isset($check_data->status) && $check_data->status == 0) echo 'selected'; ?>>Disabled</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col3">
                            <a href="javascript:void(0);" onclick="add_new_user()" class="btn btn-lg btn-default"> <span class="glyphicon glyphicon-user"> Add</span></a>
                            <?php if(isset($logged_in_user->id) && $logged_in_user->id == 1){ ?>
                            	<a href="#" class="btn btn-lg btn-default" onclick="PrintReports('#users_report_tab')"><span class="glyphicon glyphicon-print"  > Print</span></a>
                            <?php } ?>
                            <a href="users.php" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-remove"> Cancel</span></a>
                        </div>
                    </div>
                </div>
                <div style="float: left" class="table-responsive">
                    <?php
					   // Edit...
					   $user_permissions = array();
					   if(isset($_GET['id']))
					   {
						   $rec_id = base64_decode($_GET['id']);
						   $get_u_p = mysqli_query($con, 'select * from tbl_user_permissions where user_id = '.$rec_id.'');
						   while($rec = @mysqli_fetch_object($get_u_p))
						   {
							   $user_permissions[$rec->module]['r'] =  $rec->R;
							   $user_permissions[$rec->module]['w'] =  $rec->W;
							   $user_permissions[$rec->module]['e'] =  $rec->E;
						   }
						   //echo '<pre>'; print_r( $user_permissions); exit;
						   //if(empty($check_data))
							   //$_SESSION['error'] = 'ERROR ! Record not available.';
					   }

					if(isset($logged_in_user->id) && $logged_in_user->id == 1){
					?>

                    <table class="table table-bordered">
                        <thead>
                            <tr class="success">
                                <th rowspan="2" class="col-md-4">Module </th>
                                <th colspan="3">User Privileges</th>
                            </tr>
                            <tr class="success">
                                <th>R</th>
                                <th>W</th>
                                <th>E</th>
                            </tr>
                            <tr>
                                <td>Receipts Module</td>
                                <td><input type="checkbox" name="receipt_r" value="1" <?php if(!empty($user_permissions[1]) && $user_permissions[1]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="receipt_w" value="1" <?php if(!empty($user_permissions[1]) && $user_permissions[1]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="receipt_e" value="1" <?php if(!empty($user_permissions[1]) && $user_permissions[1]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>Licence Module</td>
                                <td><input type="checkbox" name="licence_r" value="1" <?php if(!empty($user_permissions[5]) && $user_permissions[5]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="licence_w" value="1" <?php if(!empty($user_permissions[5]) && $user_permissions[5]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="licence_e" value="1" <?php if(!empty($user_permissions[5]) && $user_permissions[5]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>Vehicles Module</td>
                                <td><input type="checkbox" name="vehicle_r" value="1" <?php if(!empty($user_permissions[2]) && $user_permissions[2]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="vehicle_w" value="1" <?php if(!empty($user_permissions[2]) && $user_permissions[2]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="vehicle_e" value="1" <?php if(!empty($user_permissions[2]) && $user_permissions[2]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>V.Transfer Module</td>
                                <td><input type="checkbox" name="v_transfer_r" value="1" <?php if(!empty($user_permissions[6]) && $user_permissions[6]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="v_transfer_w" value="1" <?php if(!empty($user_permissions[6]) && $user_permissions[6]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="v_transfer_e" value="1" <?php if(!empty($user_permissions[6]) && $user_permissions[6]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>Traffic Fines Module</td>
                                <td><input type="checkbox" name="fines_r" value="1" <?php if(!empty($user_permissions[7]) && $user_permissions[7]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="fines_w" value="1" <?php if(!empty($user_permissions[7]) && $user_permissions[7]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="fines_e" value="1" <?php if(!empty($user_permissions[7]) && $user_permissions[7]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>Users Module</td>
                                <td><input type="checkbox" name="users_r" value="1" <?php if(!empty($user_permissions[3]) && $user_permissions[3]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="users_w" value="1" <?php if(!empty($user_permissions[3]) && $user_permissions[3]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="users_e" value="1" <?php if(!empty($user_permissions[3]) && $user_permissions[3]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                            <tr>
                                <td>Reports Module</td>
                                <td><input type="checkbox" name="reports_r" value="1" <?php if(!empty($user_permissions[4]) && $user_permissions[4]['r'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="reports_w" value="1" <?php if(!empty($user_permissions[4]) && $user_permissions[4]['w'] == 1) echo 'checked';?>/></td>
                                <td><input type="checkbox" name="reports_e" value="1" <?php if(!empty($user_permissions[4]) && $user_permissions[4]['e'] == 1) echo 'checked';?>/></td>
                            </tr>
                        </thead>
                    </table>
                    <input type="hidden" name="is_privileges" value="1" />
                    <?php } ?>
                    </div>
                    <input type="submit" value="submit" style="display:none;" id="submit_form"/>

            <?php } ?>
            <script>

			</script>
            <?php if(isset($user_privileges[3]) && $user_privileges[3]['r'] == 1 ){ ?>

            <div style="float: right" class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr class="success">
                            <th colspan="4">Users</th>
                            <th colspan="2">Action</th>
                        </tr>
                        <tr class="success">
                            <th>Date Created</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Expire</th>
                            <th>E</th>
                            <th>D</th>
                        </tr>
                        <?php
						 $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
						 if ($page <= 0) $page = 1;

						 $per_page = 10; // Set how many records do you want to display per page.

						 $startpoint = ($page * $per_page) - $per_page;

						 $statement = "`tbl_users` "; // Change `records` according to your table name.

						 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
						 //$sql = 'SELECT * from tbl_receipts';
						 //$data = mysqli_query($con, $sql);
						 while($rec = mysqli_fetch_object($data))
						 {
						?>
							<tr>
								<td><?php echo date('d M, Y', strtotime($rec->date_created));?></td>
                                <td><?php echo $rec->username;?></td>
								<td><?php echo $rec->status == 1 ? 'Active' : 'Disabled';?></td>
                                <td><?php echo date('d M, Y', strtotime($rec->expire_date));?></td>
                                <?php if(isset($user_privileges[3]) && $user_privileges[3]['e'] == 1 ){ ?>
                                    <td><a href="?id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit"></a></td>
                                    <td><?php if($rec->id != 1){ ?>
                                        <a href="model/users_model.php?delid=<?php echo base64_encode($rec->id); ?>" onclick="return confirm('Are you sure, you want to delete this user ?');" class="glyphicon glyphicon-trash"></a>
                                        <?php } ?>
                                    </td>
                                 <?php }else{ ?>
                                     <td></td><td></td>
                                 <?php } ?>
							</tr>
						<?php
						 }
						?>
                    </thead>
               </table>
               <style>
				.page_info { margin: 10px;}
				.current{
					color: #fff !important;
					cursor: default !important;
					background-color: #337ab7 !important;
					border-color: #337ab7 !important;
				 }
				</style>
				<div id="users_records_pagination">
				<?php
				 // displaying paginaiton.
					echo pagination($statement,$per_page,$page,$url='?view=user&', $con);
				?>
				</div>
             </div>
             </form>
            <?php } ?>
            <!-- --------------------------------- -->
            <div style="width:100%;display:none;" id="users_report_tab">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Users Report</h3>
                    <div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d/m/Y'); ?></div>
                </div>
               <div style="padding-left:20px;width:98%;margin-top:20px;">
                    <table align="center" style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr style="padding:10px;">
                           <th rowspan="2" style="padding:5px;">User name</th>
                           <th rowspan="2" style="padding:5px;">Modules </th>
                           <th colspan="3" style="padding:5px;">Privileges </th>
                        </tr>
                        <tr align="center">
                                 <th>R</th>
                                 <th>W</th>
                                 <th>E</th>
                       </tr>

                        <tbody id="">
                        <?php  $user_permissions = '';
						   $get_u_p = mysqli_query($con, 'select u.username, u_p.* from tbl_users u
						   								  left join tbl_user_permissions u_p
														  on u_p.user_id = u.id
														  ');
						   while($rec = @mysqli_fetch_object($get_u_p))
						   {
							   $user_permissions[$rec->username][$rec->module]['r'] =  $rec->R;
							   $user_permissions[$rec->username][$rec->module]['w'] =  $rec->W;
							   $user_permissions[$rec->username][$rec->module]['e'] =  $rec->E;
						   }
						   foreach($user_permissions as $username=>$modules)
						   {
						?>

                               <?php  $counter = 1;
							   		 foreach($modules as $key=>$value)
							         {
									     if($counter == 1){
								?>
                                              <tr align="center" style="padding:10px;">
                                                 <td rowspan="4"> <?php echo $username; ?>  </td>
                                <?php     }

								?>
                                           <td style="padding:10px;">
                                           <?php if(isset($key) && $key == 1) echo 'Receipts Module';
                                                 else if(isset($key) && $key == 2) echo 'Vehicles Module';
                                                 else if(isset($key) && $key == 3) echo 'Users Module';
                                                 else if(isset($key) && $key == 4) echo 'Reports Module';

                                           ?>
                                           </td>
                                           <td style="padding:10px;"><?php if(!empty($value) && $value['r'] == 1) echo 'Yes'; else echo 'No';?></td>
                                           <td style="padding:10px;"><?php if(!empty($value) && $value['w'] == 1) echo 'Yes'; else  echo 'No';?></td>
                                           <td style="padding:10px;"><?php if(!empty($value) && $value['e'] == 1) echo 'Yes'; else echo 'No';?></td>
                                        </tr>
                                        <?php if($counter < count($modules)){  ?>
                                        	<tr  align="center" style="padding:10px;">
                                        <?php } ?>
                                <?php   $counter++;
								       }
								?>

                         <?php
						   }
						 ?>
                        </tbody>
                     </table>

                </div>

            </div>
      	</div>

        <div id="user-master" class="tab-pane <?php if((isset($_SESSION['master_section']) && $_SESSION['master_section'] == 'master') ||  (isset($_GET['view']) && $_GET['view'] == 'master')) echo 'in active'; else echo 'fade'; ?>">
        	<div class="table-responsive" style="float:left;width:40%;">
            	<table class="table table-bordered">
                	<thead>
                    	<tr class="success">
                        	<th>Vehicle Type</th>
                            <th> </th>
                        </tr>
                        <tr class="active">
                         <form method="post" action="model/master_model.php" >
                        	<th><input type="text" required="required" name="v_type" class="insider"/></th>
                        	<th> <a href="javascript:void(0);" onclick="submit_master_form('v_type_sub_btn');" class="glyphicon glyphicon-check"></a>
                            	<input type="submit" name="add_v_type" id="v_type_sub_btn" style="display:none;"/>
                            </th>
                         </form>
                        </tr>
                     </thead>
                     <tbody id="u_m_v_type_area">
						 <?php
                         $per_page = 10; // Set how many records do you want to display per page.

                         $startpoint = ($page * $per_page) - $per_page;

                         $statement = "`tbl_vehicle_types` order by vehicle_type "; // Change `records` according to your table name.

                         $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
                         //$sql = 'SELECT * from tbl_receipts';
                         //$data = mysqli_query($con, $sql);
                         while($rec = mysqli_fetch_object($data))
                         {
                        ?>
                            <tr>
                                <td><?php echo $rec->vehicle_type; ?></td>
                                <td><a href="model/master_model.php?del_v_type=<?php echo $rec->id; ?>" onclick="return confirm('Are you sure to delete ?');" class="glyphicon glyphicon-trash"></a></td>
                            </tr>
                        <?php
                        }
                        ?>
                   </tbody>
             </table>
             <div id="users_master_v_type_pagination">
				<?php
				 // displaying paginaiton.
					 $_SESSION['users_master_v_type_pagination_data'] = $statement;
                 	echo ajax_pagination($statement,$per_page,$page,$url='user_master_v_type_pag', $con);
				?>
			 </div>
         </div><?php /*?><div class="table-responsive" style="float:left;">
         	<table class="table table-bordered">
            	<thead>
                	<tr class="success">
                    	<th>Vehicle Origin</th>
                        <th> </th>
                    </tr>
                    <tr class="active">
                    	<form method="post" action="model/master_model.php" >
                        	<th><input type="text" required="required" name="v_origin" class="insider"/></th>
                        	<th> <a href="javascript:void(0);" onclick="submit_master_form('v_origin_sub_btn');" class="glyphicon glyphicon-check"></a>
                            	<input type="submit" name="add_v_origin" id="v_origin_sub_btn" style="display:none;"/>
                            </th>
                         </form>
                    </tr>
                 </thead>
                 <tbody id="u_m_v_origin_area">
                 	<?php
					 $per_page = 10; // Set how many records do you want to display per page.

					 $startpoint = ($page * $per_page) - $per_page;

					 $statement = "`tbl_v_origin` order by name "; // Change `records` according to your table name.

					 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
					 //$sql = 'SELECT * from tbl_receipts';
					 //$data = mysqli_query($con, $sql);
					 while($rec = mysqli_fetch_object($data))
					 {
					?>
						<tr>
							<td><?php echo $rec->name; ?></td>
							<td><a href="model/master_model.php?del_v_origin=<?php echo $rec->country_id; ?>" onclick="return confirm('Are you sure to delete ?');" class="glyphicon glyphicon-trash"></a></td>
						</tr>
					<?php
					}
					?>
                 </tbody>
             </table>
             <div id="users_master_v_origin_pagination">
				<?php
				 // displaying paginaiton.
					 $_SESSION['users_master_v_origin_pagination_data'] = $statement;
                 	echo ajax_pagination($statement,$per_page,$page,$url='user_master_v_origin_pag', $con);
				?>
			 </div>
         </div><?php */?><div class="table-responsive" style="float:left;">
         	<table class="table table-bordered">
            	<thead>
                	<tr class="success">
                    	<th>Plate Type</th>
                        <th> </th>
                    </tr>
                    <tr class="active">
                    	<form method="post" action="model/master_model.php" >
                        	<th><input type="text" required="required" name="plate_type" class="insider"/></th>
                        	<th> <a href="javascript:void(0);" onclick="submit_master_form('plate_type_sub_btn');" class="glyphicon glyphicon-check"></a>
                            	<input type="submit" name="add_plate_type" id="plate_type_sub_btn" style="display:none;"/>
                            </th>
                         </form>
                    </tr>
                </thead>
                 <tbody id="u_m_p_type_area">
                 	<?php
					 $per_page = 10; // Set how many records do you want to display per page.

					 $startpoint = ($page * $per_page) - $per_page;

					 $statement = "`tbl_plate_types` order by plate_type "; // Change `records` according to your table name.

					 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
					 //$sql = 'SELECT * from tbl_receipts';
					 //$data = mysqli_query($con, $sql);
					 while($rec = mysqli_fetch_object($data))
					 {
					?>
						<tr>
							<td><?php echo $rec->plate_type; ?></td>
							<td><a href="model/master_model.php?del_plate_type=<?php echo $rec->id; ?>" onclick="return confirm('Are you sure to delete ?');" class="glyphicon glyphicon-trash"></a></td>
						</tr>
					<?php
					}
					?>
                 </tbody>
             </table>
             <div id="users_master_p_type_pagination">
				<?php
				 // displaying paginaiton.
					 $_SESSION['users_master_plate_type_pagination_data'] = $statement;
                 	echo ajax_pagination($statement,$per_page,$page,$url='user_master_plate_type_pag', $con);
				?>
			 </div>
         </div><div class="table-responsive" style="float:left;">
         	<table class="table table-bordered">
            	<thead>
                	<tr class="success">
                    	<th>Plate Code</th>
                        <th>Digits</th>
                        <th> </th>
                    </tr>
                    <tr class="active">
                    	<form method="post" action="model/master_model.php" >
                        	<th><input type="text" required="required" name="plate_code" class="insider"/></th>
                            <th><input type="text" required="required" name="digits" class="insider"/></th>
                        	<th> <a href="javascript:void(0);" onclick="submit_master_form('plate_code_sub_btn');" class="glyphicon glyphicon-check"></a>
                            	<input type="submit" name="add_plate_code" id="plate_code_sub_btn" style="display:none;"/>
                            </th>
                         </form>
                    </tr>

                 </thead>
                 <tbody id="u_m_p_code_area">
                 	<?php
					 $per_page = 10; // Set how many records do you want to display per page.

					 $startpoint = ($page * $per_page) - $per_page;

					 $statement = "`tbl_vehicle_plate_codes` order by vehicle_plate_code "; // Change `records` according to your table name.

					 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
					 //$sql = 'SELECT * from tbl_receipts';
					 //$data = mysqli_query($con, $sql);
					 while($rec = mysqli_fetch_object($data))
					 {
					?>
						<tr>
							<td><?php echo $rec->vehicle_plate_code; ?></td>
                            <td><?php echo $rec->digits; ?></td>
							<td><a href="model/master_model.php?del_plate_code=<?php echo $rec->id; ?>" onclick="return confirm('Are you sure to delete ?');" class="glyphicon glyphicon-trash"></a></td>
						</tr>
					<?php
					}
					?>
                 </tbody>
             </table>
             <div id="users_master_p_code_pagination">
				<?php
				 // displaying paginaiton.
					 $_SESSION['users_master_plate_code_pagination_data'] = $statement;
                 	echo ajax_pagination($statement,$per_page,$page,$url='user_master_p_code_pag', $con);
				?>
			 </div>
         </div><div class="table-responsive" style="float:left;">
         	<table class="table table-bordered">
            	<thead>
                	<tr class="success">
                    	<th>Nationality</th>
                        <th> </th>
                    </tr>
                    <tr class="active">
                    	<form method="post" action="model/master_model.php" >
                        	<th><input type="text" required="required" name="nationality" class="insider"/></th>
                        	<th> <a href="javascript:void(0);" onclick="submit_master_form('nationality_sub_btn');" class="glyphicon glyphicon-check"></a>
                            	<input type="submit" name="add_nationality" id="nationality_sub_btn" style="display:none;"/>
                            </th>
                        </form>
                    </tr>
                </thead>
                 <tbody id="u_m_nationality_area">
                 	<?php
					 $per_page = 10; // Set how many records do you want to display per page.

					 $startpoint = ($page * $per_page) - $per_page;

					 $statement = "`tbl_country` order by name "; // Change `records` according to your table name.

					 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
					 //$sql = 'SELECT * from tbl_receipts';
					 //$data = mysqli_query($con, $sql);
					 while($rec = mysqli_fetch_object($data))
					 {
					?>
						<tr>
							<td><?php echo $rec->name; ?></td>
							<td><a href="model/master_model.php?del_nationality=<?php echo $rec->country_id; ?>" onclick="return confirm('Are you sure to delete ?');" class="glyphicon glyphicon-trash"></a></td>
						</tr>
					<?php
					}
					?>
                 </tbody>
             </table>
             <div id="users_master_nationality_pagination">
				<?php
				 // displaying paginaiton.
					 $_SESSION['users_master_nationality_pagination_data'] = $statement;
                 	echo ajax_pagination($statement,$per_page,$page,$url='user_master_nationality_pag', $con);
				?>
			 </div>
          </div>
        </div>

    </div>
    <script>
	function submit_master_form(btn_id)
	{
		$('#'+btn_id).trigger('click');
	}
	</script>
</div>

<?php /* ###############
         Footer
	  */
	  include_once('inc/footer.php');
?>
