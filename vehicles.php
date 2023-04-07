<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  
	  $logged_in_user = $_SESSION['logged_in_user_data'];
ini_set('max_execution_time', 600);
	  //  Owner   Birth Date:
	  /*
	  Owner birth_day nationality birth_place mother_name mobile_no email address gender personal_id fees issue_date expire_date plate_no
		plate_type code vehicle origin weight engine_no v_type color hp chassis_no model cylinder comments issue_place
      */
      
	  // Show vehicle record after search....
	   if(isset($_POST['search_vehicle_no']) && $_POST['search_vehicle_no'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where plate_no = '".mysqli_real_escape_string($con, $_POST['search_vehicle_no'])."' ");
			$search_result = mysqli_fetch_object($data);
			if(empty($search_result))
			    $_SESSION['error'] = 'ERROR !  Vehicle with Plate Number '.$_POST['search_vehicle_no'].' is not found.';
			$_GET['section'] = 'edit_renew';
	   }
	   else if(isset($_GET['search_vehicle_no']) && $_GET['search_vehicle_no'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where plate_no = '".mysqli_real_escape_string($con, $_GET['search_vehicle_no'])."' ");
			$search_result = mysqli_fetch_object($data);
			if(empty($search_result))
			    $_SESSION['error'] = 'ERROR !  Vehicle with Plate Number '.$_GET['search_vehicle_no'].' is not found.';
			$_GET['section'] = 'vehicle_search';
	   }
	   else if(isset($_REQUEST['cardlist_id']) && $_REQUEST['cardlist_id'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where plate_no = '".(mysqli_real_escape_string($con, $_REQUEST['cardlist_id']))."' ");
			$search_result_m = mysqli_fetch_object($data);
			if(empty($search_result_m))
			    $_SESSION['error'] = 'ERROR !  Record not available.';
			$_GET['section'] = 'card_list';

	   }
	   else if(isset($_GET['search_card_vehicle_no']) && $_GET['search_card_vehicle_no'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where plate_no = '".mysqli_real_escape_string($con, $_GET['search_card_vehicle_no'])."' ");
			$search_result = mysqli_fetch_object($data);
			if(empty($search_result))
			    $_SESSION['error'] = 'ERROR !  Vehicle with Plate Number '.$_GET['search_card_vehicle_no'].' is not found.';
			$_GET['section'] = 'card_list';
	   }
	   else if(isset($_GET['section']) && $_GET['section'] == 'edit')
	   {
		   $_GET['section'] = 'edit_renew';
	   }

       //
	   unset($_SESSION['search_statement']);
	   unset($_SESSION['search_card_statement']);
	   unset($_SESSION['search_card_statement']);
	   unset($_SESSION['total_pagination_count_card_list']);
       // get least platno
	   $data = mysqli_query($con,"SELECT * FROM tbl_vehicles order by id Desc");
		$vhec_data = mysqli_fetch_object($data);
	   
		
       //.....................
	   // Get all countries 
	  
	  if(!isset($_SESSION['countries_data_session']))
	  { 
		  $countries_data = array();
		  $Countries = mysqli_query($con, 'select * from tbl_country order by name');
		  while($row = @mysqli_fetch_object($Countries)) 
		  {
			  $countries_data[] = $row;
		  }
	  	  $_SESSION['countries_data_session'] = $countries_data;
	  }
	  else
	      $countries_data = $_SESSION['countries_data_session'];
	  // Get V-Type records
	  if(!isset($_SESSION['V_type_data_session']) || isset($search_result))
	  {
		  $V_type_data = array();
		  $V_type_data_array = array();
		  $V_type = mysqli_query($con, 'select * from tbl_vehicle_types');
		  while($row = @mysqli_fetch_object($V_type))
		  {
			  $V_type_data_array[] = $row;
		  }
		  $v_type_option = '';
		  foreach($V_type_data_array as $row){ 
			   if(isset($_SESSION['v_type']) && $row->vehicle_type == $_SESSION['v_type']) 
					$sel = "selected";
				else
					$sel = "";
				
				;
			   $v_type_option .= '<option value="'.$row->vehicle_type.'" '.$sel.' >'.$row->vehicle_type.'</option>';  
		  }
		  $V_type_d = '<select id="text-short" class="edit_v_type_option" size="1"  name="v_type">
						   <option value="">Select V Type</option>
						   '.$v_type_option.'
						 </select>';
		  $_SESSION['V_type_data_session'] = $V_type_d; 
		  $V_type_data = $_SESSION['V_type_data_session'];
	  }
	  else
	      $V_type_data = $_SESSION['V_type_data_session']; 
?>
      <style>
	  .form-inline .form-control {
    	 width: 130px;
	  }
	 </style>

      <div class="right-nav">
        <ul class="nav nav-tabs">
        	<li <?php if(!isset($_GET['section'])) { ?> class="active" <?php } ?>><a href="vehicles.php">New Vehicle</a></li>
            <li <?php if(isset($_GET['section']) && $_GET['section'] == 'edit_renew') { ?> class="active" <?php } ?> ><a  href="?section=edit">Edit-Renew</a></li>
            <li <?php if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') { ?> class="active" <?php } ?>><a  href="?section=vehicle_search">Search Vehicle</a></li>
            <li <?php if(isset($_GET['section']) && $_GET['section'] == 'card_list') { ?> class="active" <?php } ?>><a  href="?section=card_list">Card List</a></li>
            <li style="float: right;">
             <?php if(isset($_SESSION['success'])){ ?>
                <div class="alert alert-success" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;float:right;"><?php echo $_SESSION['success']; ?></div>
              <?php unset($_SESSION['success']); } ?>
              <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert alert-danger" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"><?php echo $_SESSION['error']; ?></div>
              <?php unset($_SESSION['error']);  } ?>
              <div class="alert alert-danger" id="show_error_msg" style="display:none;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
              <div class="alert alert-success" id="show_success_msg" style="display:none;color:#144C15;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
           </li>
        </ul>
        <div class="tab-content">
        	<?php if(!isset($_GET['section'])){ 
				
			?>
                <div id="vehicles" class="tab-pane fade in <?php if(!isset($_GET['section'])) echo 'active'; else echo 'fade'; ?>">
                  <form method="post" action="model/vehicles_model.php" >
                    <div class="form-inline" >
                        <div class="form-group">
                            <label for="text">Receipts No:</label>
                            <input id="receipt_no" type="text" name="search_receipt_no" required="required" placeholder="Receipt No" class="form-control" value="<?php echo isset($_POST['search_vehicle_no']) ? $_POST['search_vehicle_no'] : (isset($_SESSION['receipt_no']) ? $_SESSION['receipt_no'] : '') ;?>" onblur="Search_receipt_data()" />
                            <input type="submit"  value="submit" style="display:none;"  />
                            <div class="fa-stack fa-lg" onclick="Search_receipt_data()">
                                <i class="fa fa-square-o fa-stack-2x"></i>
                                <i class="fa fa-search fa-stack-1x"> </i>
                            </div>
                       </div>
                       <script>
                       function Search_receipt_data()
                       {
                           var recipt = $('#receipt_no').val();
                           //get_receipt_data(recipt);
                           get_receipt_data_vehicle(recipt);
                       }
                       </script>
                   </div>
    
                   <div class="form-inline mar1">
                       <div class="form-group">
                            <label for="text" class="control-label3 col-sm-4">Issue Place:</label>
                            <!--<input id="text-short" type="text" name="issue_place" value="<?php echo  'Mogadishu' ;?>" class="form-control issue_place"/>-->
                            <select id="text-short" size="1" name="issue_place" placeholder="Place" required>
                            <option value="<?php echo isset($ArIssuePlace[0]) ? $ArIssuePlace[0] : '';?>" <?php if(isset($_SESSION['issue_place']) && isset($ArIssuePlace[0]) && $_SESSION['issue_place'] == $ArIssuePlace[0]) echo 'selected'; ?>><?php echo isset($ArIssuePlace[0]) ? $ArIssuePlace[0] : '';?></option>
                             </select>
                             
                       </div>
                   </div>
                   <div class="form-inline mar1">
                       <div class="form-group">
                            <label for="date" class="control-label2 col-sm-4">Fees:</label>
                            <input id="text-short" type="text" name="fees" readonly="readonly"  class="form-control licence_receipt_fee" value="<?php echo isset($_SESSION['fees']) ? $_SESSION['fees'] : ''; ?>" required/>
                       </div>
                       <div class="form-group">
                            <label for="date" class="control-label2 col-sm-4">Issue Date:</label>
                            <input id="" type="text" name="issue_date" readonly="readonly" class="form-control licence_receipt_issueDate "  value="<?php echo isset($_SESSION['issue_date']) ? $_SESSION['issue_date'] : '';?>" required />
                       </div>
                       <div class="form-group">
                            <label for="date" class="control-label2 col-sm-4">Expire Date:</label>
                            <input id="" type="text" name="expire_date" class="form-control expire_date"  value="<?php echo isset($_SESSION['expire_date']) ? $_SESSION['expire_date'] : '';?>" required/>
                       </div>
                       <div class="form-group">
                            <label for="date" class="control-label2 col-sm-4">Owner:</label>
                            <input id="text-long" type="text" name="owner" class="form-control licence_receipt_holder_name"  value="<?php echo isset($_SESSION['owner']) ? $_SESSION['owner'] : '';?>" required/>
                       </div>
                    </div>
    
                    <div class="stack">
                        <div class="row">
                            <div class="col">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="date" class="control-label2 col-sm-4">Birth Date:</label>
                                        <input id="birth_date" type="text" name="birth_date" value="<?php echo isset($_SESSION['birth_date']) ? $_SESSION['birth_date'] : '';?>" class="form-control text-middle" onkeypress="DateFormat(this,event.keyCode)" placeholder="dd-mm-yyyy" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Birth Place:</label>
                                        <input id="text-middle" type="text" name="birth_place" class="form-control" value="<?php echo isset($_SESSION['birth_place']) ? $_SESSION['birth_place'] : '' ;?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Gender:</label>
                                        <select id="text-middle" size="1" name="gender" required>
                                            <option value="Lab" <?php if(isset($_SESSION['gender']) && $_SESSION['gender']=='Lab') echo "selected"; ?>>Lab</option>
                                            <option value="Dhedig" <?php if(isset($_SESSION['gender']) && $_SESSION['gender']=='Dhedig') echo "selected"; ?>>Dhedig</option>
                                        </select>
    
                                    </div>
                                </div>
                            </div>
                            <div class="col2">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                        <?php //$Countries = mysqli_query($con, 'select * from tbl_country order by name'); ?>
                                            <select id="text-middle" size="1" name="nationality" required>
                                               <option value="">Select Country</option>
                                               <?php //while($row = @mysqli_fetch_object($Countries)) { 
                                                foreach($countries_data as $row) { 
                                                    if(isset($_SESSION['nationality']) && $row->name == $_SESSION['nationality'] || $row->name == 'Somali')
                                                        $sel = "selected";
                                                    else
                                                        $sel = "";
                                               ?>
                                                    <option value="<?php echo $row->name; ?>" <?php echo $sel?>><?php echo $row->name; ?></option>
                                               <?php } ?>
                                             </select>
    
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Mother's Name:</label>
                                        <input id="text-middle" type="text" name="mother_name" class="form-control" value="<?php echo isset($_SESSION['mother_name']) ? $_SESSION['mother_name'] : '';?>"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="control-label2 col-sm-4">Personal ID:</label>
                                        <input id="text-middle" type="text" name="personal_id" class="form-control" value="<?php echo isset($_SESSION['personal_id']) ? $_SESSION['personal_id'] : '';?>" required />
                                    </div>
                                </div>
                            </div>
                            <div class="col3">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Mobile No:</label>
                                        <input id="text-middle" type="text" name="mobile_no" class="form-control inch" value="<?php echo isset($_SESSION['mobile_no']) ? $_SESSION['mobile_no'] : '';?>" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="date" class="control-label2 col-sm-4">Address:</label>
                                        <input id="text-middle" type="text" name="address" class="form-control inch" value="<?php echo isset($_SESSION['address']) ? $_SESSION['address'] : '';?>"  required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Email:</label>
                                        <input id="text-middle" type="text" name="email" class="form-control inch" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '';?>" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    
                    <div class="form-inline mar1">
                        <div class="form-group onemargin2">
                            <label for="text" class="control-label2 col-sm-4">Plate Type:</label>
                            <?php $Plate_types = mysqli_query($con, 'select * from tbl_plate_types order by plate_type'); ?>
                            <select id="text-middle" size="1" name="plate_type" required>
                               <option value="">Select Plate Type</option>
                               <?php while($row = @mysqli_fetch_object($Plate_types)) { 
                                if(isset($_SESSION['plate_type']) && $row->plate_type == $_SESSION['plate_type'])
                                    $sel = "selected";
                                else
                                    $sel = "";
                               ?>
                                    <option value="<?php echo $row->plate_type; ?>" <?php echo $sel?>><?php echo $row->plate_type; ?></option>
                               <?php } ?>
                             </select>
                        </div>
                        <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">Code:  </label>
                            <?php $Plate_codes = mysqli_query($con, 'select * from tbl_vehicle_plate_codes order by vehicle_plate_code'); ?>
                            <select id="text-middle" size="1" name="code" onchange="get_veh_new_plate_number(this.value)" required>
                               <option value="">Select Plate Code</option>
                               <?php while($row = @mysqli_fetch_object($Plate_codes)) { 
                                /*if(strlen($row->vehicle_plate_code) == 1)
                                {
                                } else { 
                                }*/
                               ?><!--<optgroup label="<?//=$row->vehicle_plate_code?>"></optgroup>-->
                               <? 					   
                                    if(isset($_SESSION['code']) && $row->vehicle_plate_code == $_SESSION['code'])
                                        $sel = "selected";
                                    else
                                        $sel = "";
                               ?>
                                <option value="<?php echo $row->vehicle_plate_code; ?>" <?php echo $sel?>><?php echo $row->vehicle_plate_code; ?></option>
                               <?php  
                              } ?>
                             </select>
                        </div>
                        <div class="form-group onemargin">
                            <label for="date" class="control-label2 col-sm-4">Plate No: </label>
                            <input name="plate_no" type="text" class="form-control plate_no" style="width: 200px;" id="plate_no"  value="<?php echo isset($_SESSION['plate_no']) ? $_SESSION['plate_no'] : '';?>" maxlength="4" required />
    
                        </div>
    
                    </div>
                    <div class="stack">
                        <div class="row">
                            <div class="col-s">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Vehicle:</label>
                                        <select id="text-short" size="1"  name="vehicle" required>
                                           <option value="Gaari" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='Gaari') echo "selected"; ?>>Gaari</option>
                                           <option value="Mooto" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='Mooto') echo "selected"; ?>>Mooto</option>
                                           <option value="Bajaj" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='Bajaj') echo "selected"; ?>>Bajaj</option>
                                           <option value="isjeed" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='isjeed') echo "selected"; ?>>isjeed</option>
                                           <option value="Cagaf" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='Cagaf') echo "selected"; ?>>Cagaf</option>
                                           <option value="rimoor" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='rimoor') echo "selected"; ?>>rimoor</option>
                                           <option value="kreen" <?php if(isset($_SESSION['vehicle']) && $_SESSION['vehicle']=='kreen') echo "selected"; ?>>kreen</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">V.Type:</label>
                                        <?php echo $V_type_data; ////$V_type = mysqli_query($con, 'select * from tbl_vehicle_types'); ?>
                                         
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Model:</label>
                                        <input id="text-short" type="text" name="model" class="form-control" value="<?php echo isset($_SESSION['model']) ? $_SESSION['model'] : '';?>" required />
                                    </div>
                                </div>
                             </div>
                            <div class="col-s">
                            <div class="form-horizontal">
                            <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">Origin:</label>
                             <?php //$Countries = mysqli_query($con, 'select * from tbl_country order by name'); ?>
                                <select id="text-short" size="1" name="origin" required>
                                   <option value="">Select Origin</option>
                                   <?php //while($row = @mysqli_fetch_object($Countries)) { 
                                   foreach($countries_data as $row) { 
                                   if(isset($_SESSION['origin']) && $row->name == $_SESSION['origin'])
                                        $sel = "selected";
                                    else
                                        $sel = "";
                                    ?>
                                        <option value="<?php echo $row->name; ?>" <?php echo $sel?>><?php echo $row->name; ?></option>
                                   <?php } ?>
                                 </select>
                            </div>
                            <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">Color:  </label>
                            <input id="text-short" type="text" name="color" class="form-control" value="<?php echo isset($_SESSION['color']) ? $_SESSION['color'] :'';?>" required />
                            </div>
                            <div class="form-group">
                            <label for="date" class="control-label2 col-sm-4">Cylinder:</label>
                            <input id="text-short" type="text" name="cylinder" class="form-control" value="<?php echo isset($_SESSION['cylinder']) ? $_SESSION['cylinder'] : '';?>" required />
                            </div>                        
                            </div>
                            </div>
                            <div class="col-s2">
                            <div class="form-horizontal">
                            <div class="col-s last2">
                            <div class="form-horizontal">
                            <div class="form-group">
                            <label for="text"  class="control-label2 col-sm-4">Weight:</label>
                            <input id="text-short" type="text" name="weight" class="form-control" value="<?php echo isset($_SESSION['weight']) ? $_SESSION['weight'] : '';?>" />
                            </div>
                            </div>
                            </div>
                            <div class="col-s last2">
                            <div class="form-horizontal">
                            <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">HP:</label>
                            <input id="text-short" type="text" name="hp" class="form-control" value="<?php echo isset($_SESSION['hp']) ? $_SESSION['hp'] : '';?>" />
                            </div>
                            </div>
                            </div>
                            <div class="col-s last2">
                            <div class="form-horizontal">
                            <div class="form-group">
                            <label for="text"  class="control-label2 col-sm-4">Passengers:</label>
                            <input id="text-short" type="text" name="passengers" class="form-control" value="<?php echo isset($_SESSION['passengers']) ? $_SESSION['passengers'] : '';?>" required  />
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                            <div class="col-s last2" style="margin-left:50px;">
                            <div class="form-horizontal">
                            <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">Engine No:</label>
                            <input id="text-short" style="width:175px;" name="engine_no" type="text" class="22long form-control inch" value="<?php echo isset($_SESSION['engine_no']) ? $_SESSION['engine_no'] : '';?>" required />
                            </div>
                            <div class="form-group">
                            <label for="text" class="control-label2 col-sm-4">Chassis No:    </label>
                            <input id="text-short" style="width:175px;" type="text" required="required" name="chassis_no" class="22long form-control inch" value="<?php echo isset($_SESSION['chassis_no']) ? $_SESSION['chassis_no'] : '';?>"  onblur="this.value=this.value.toUpperCase();" /><!-- onblur="this.value=this.value.toUpperCase();"-->
                            </div>
                            </div>
                            </div>
                            </div>
                            </div>
                    <div class="form-horizontal comm">
                    <div class="form-group">
                    <label for="text" class="control-label col-sm-2 lab">Comments:</label>
                    <div class="col-sm-4">
                    <input id="text-long" type="text" class="form-control" name="comments" value="<?php echo isset($_SESSION['comments']) ? $_SESSION['comments'] : '';?>" />
                    </div>
                    <?php if(isset($user_privileges[2]) && $user_privileges[2]['w'] == 1){ ?>
                        <div class="col4">
                            <a href="javascript:void(0);" onclick="submit_vehicle_form()" class="btn btn-lg btn-default"><span style="color:black" class="glyphicon glyphicon-saved"> Save</span></a>
                            <input type="hidden" value="1" name="add_new_vehicle" />
                            <input type="submit" value="sub" id="veh_sub_btn" style="display:none;" />
                        </div>
                    <?php } ?>    
                    </div>
                    </div>
                  </form>
                   <script>
                    var Plate_no_digits = 4;
                    function submit_vehicle_form()
                    {					
                        if($('.plate_no').val() == '')
                        {
                            $('#plate_no').focus();
                            $('#show_error_msg').show().text('ERROR !  Please enter the plate number.');
                            return false;
                        }
                        if($('.plate_no').val().length != Plate_no_digits)
                        {
                            $('#plate_no').focus();
                            $('#show_error_msg').show().text('ERROR !  Please enter the correct plate number '+Plate_no_digits+' digits.');
                            return false;
                        }  
                        var birthdate	=	$("#birth_date").val();
                        if(birthdate != '')
                        {
                            fnValidateDOB(birthdate);
                        }
                        if($('.licence_receipt_fee').val() != '' &&  $('.licence_receipt_issueDate').val() != '')
                        {
                           $('#veh_sub_btn').trigger('click');
                        }
                        else
                        {
                            $('#receipt_no').focus();
                            $('#show_error_msg').show().text('ERROR !  Some thing wrong, Please check receipt number again.');
                        }
                    }
                    </script>
    
                   </div>
            <?php 
			 }
			?>
           <!-- ????????????????????????????????????????????????????????????
                 **********************************************************
                                   Edit Renew Section
           -->
           <?php if(isset($_GET['section']) && $_GET['section'] == 'edit_renew'){ ?>
                   <div id="edit-renew2" class="tab-pane <?php if(isset($_GET['section']) && $_GET['section'] == 'edit_renew') echo 'active'; else echo 'fade'; ?>">
        
                       <form role="form" class="form-inline" method="post">
                            <div class="form-group">
                                <label for="text">Search by:</label>
                                <input id="search_vehicle_no" type="text" name="search_vehicle_no" required="required" placeholder="Vehicle No" class="form-control" value="<?php echo isset($_POST['search_vehicle_no']) ? $_POST['search_vehicle_no'] : '' ;?>"/>
                                <input type="submit"  value="submit" style="display:none;" id="search_vehicle_no_submit_btn" />
                                <div class="fa-stack fa-lg" onclick="submit_search_vehicle_form()">
                                    <i class="fa fa-square-o fa-stack-2x"></i>
                                    <i class="fa fa-search fa-stack-1x"> </i>
                                </div>
                           </div>
                           <script>
                           function submit_search_vehicle_form()
                           {
                               $('#search_vehicle_no_submit_btn').trigger('click');
                           }
                           </script>
                       </form>
                       <form method="post" action="model/vehicles_model.php" >
                       <div class="form-inline mar1">
                           <div class="form-group">
                                <label for="text" class="control-label3 col-sm-4">Issue Place:</label>
                               <!-- <input id="text-short" type="text" name="issue_place" value="<?php echo isset($search_result->issue_place) ? $search_result->issue_place : 'Mogadishu' ;?>" class="form-control"/>-->
                            <select id="text-short" size="1" name="issue_place" placeholder="Place">
                            <option value="<?php echo $ArIssuePlace[0]?>" <?php if(isset($search_result->issue_place) && $search_result->issue_place == $ArIssuePlace[0]) echo 'selected'; ?>><?php echo $ArIssuePlace[0]?></option>
                                 </select>    
                           </div>
                           <div class="form-group">
                                <label for="text" class="control-label3 col-sm-4">Receipt No:</label>
                                <input id="vehicle_edit_receipt_no" type="text" name="receipt_no" value="<?php echo isset($search_result->receipt_no) ? $search_result->receipt_no : '' ;?>" class="form-control"/>
                           </div>
                           <div class="form-group">
                                <label for="date" class="control-label2 col-sm-4">Issue Date:</label>
                                <input id="vehicle_plate_issue_date" type="text" name="issue_date"  value="<?php echo isset($search_result->issue_date) ? date('d-m-Y', strtotime($search_result->issue_date)) : '';?>" class="form-control" required/>
                           </div>
                       </div>
                       <div class="form-inline mar1">
                           <div class="form-group">
                                <label for="date" class="control-label2 col-sm-4">Fees:</label>
                                <input id="text-short" type="text" name="fees" readonly="readonly" value="<?php echo isset($search_result->fees) ? $search_result->fees : '' ;?>" class="form-control"/>
                           </div>
                           <div class="form-group">
                                <label for="date" class="control-label2 col-sm-4">Renewal Date:</label>
                                <input id="vehicle_plate_renewal_date" type="text" name="renewal_date"  value="<?php echo isset($search_result->renewal_date) ? date('d-m-Y', strtotime($search_result->renewal_date)) : '';?>" class="form-control" />
                           </div>
                           <div class="form-group">
                                <label for="date" class="control-label2 col-sm-4">Expire Date:</label>
                                <input id="vehicle_plate_expire_date" type="text" name="expire_date" value="<?php echo isset($search_result->expire_date) ? date('d-m-Y', strtotime($search_result->expire_date)) : '';?>" class="form-control" required/>
                           </div>
                           <div class="form-group">
                                <label for="date" class="control-label2 col-sm-4">Owner:</label>
                                <input id="text-long" type="text" name="owner" value="<?php echo isset($search_result->Owner) ? $search_result->Owner : '';?>" class="form-control" required/>
                           </div>
                        </div>
        
                        <div class="stack">
                            <div class="row">
                                <div class="col">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="date" class="control-label2 col-sm-4">Birth Date:</label>
                                            <input id="birth_date1" type="text" name="birth_date" class="form-control text-middle" onkeypress="DateFormat(this,event.keyCode)"  value="<?php echo isset($search_result->birth_day) ? date('d-m-Y', strtotime($search_result->birth_day)) : '' ;?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Birth Place:</label>
                                            <input id="text-middle" type="text" name="birth_place" class="form-control" value="<?php echo isset($search_result->birth_place) ? $search_result->birth_place : '' ;?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Gender:</label>
                                            <select id="text-middle" size="1" name="gender" required>
                                                <option value="Lab" <?php if(isset($search_result->gender) && $search_result->gender == 'Lab') echo 'selected'; ?>>Lab</option>
                                                <option value="Dhedig" <?php if(isset($search_result->gender) && $search_result->gender == 'Dhedig') echo 'selected'; ?>>Dhedig</option>
                                            </select>
        
                                        </div>
                                    </div>
                                </div>
                                <div class="col2">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                            <?php //$Countries = mysqli_query($con, 'select * from tbl_country order by name'); ?>
                                                <select id="text-middle" size="1" name="nationality" required>
                                                   <option value="">Select Country</option>
                                                   <?php // while($row = @mysqli_fetch_object($Countries)) { ?>
                                                   <?php foreach($countries_data as $row) { ?>
                                                        <option value="<?php echo $row->name; ?>" <?php if(isset($search_result->nationality) && $search_result->nationality == $row->name) echo 'selected'; ?>><?php echo $row->name; ?></option>
                                                   <?php }  ?>
                                                 </select>
        
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Mother's Name:</label>
                                            <input id="text-middle" type="text" name="mother_name" class="form-control" value="<?php echo isset($search_result->mother_name) ? $search_result->mother_name : '' ;?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="date" class="control-label2 col-sm-4">Personal ID:</label>
                                            <input id="text-middle" type="text" name="personal_id" class="form-control" value="<?php echo isset($search_result->personal_id) ? $search_result->personal_id : '' ;?>" required/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col3">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Mobile No:</label>
                                            <input id="text-middle" type="text" name="mobile_no" class="form-control inch" value="<?php echo isset($search_result->mobile_no) ? $search_result->mobile_no : '' ;?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="date" class="control-label2 col-sm-4">Address:</label>
                                            <input id="text-middle" type="text" name="address" class="form-control inch" value="<?php echo isset($search_result->address) ? $search_result->address : '' ;?>" required/>
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Email:</label>
                                            <input id="text-middle" type="text" name="email" class="form-control inch" value="<?php echo isset($search_result->email) ? $search_result->email : '' ;?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-inline mar1">
                            <div class="form-group onemargin2">
                                <label for="text" class="control-label2 col-sm-4">Plate Type:</label>
                                <?php 
                                $Plate_types = mysqli_query($con, 'select * from tbl_plate_types order by plate_type'); ?>
                                <select id="text-middle" size="1" name="plate_type" required>
                                   <option value="">Select Plate Type</option>
                                   <?php while($row = @mysqli_fetch_object($Plate_types)) 
                                   { ?>
                                        <option value="<?php echo $row->plate_type; ?>" <?php if(isset($search_result->plate_type) && $search_result->plate_type == $row->plate_type) echo 'selected'; ?>><?php echo $row->plate_type; ?></option>
                                   <?php } ?>
                                 </select>
                            </div>
                            <div class="form-group" style="margin-left:18px;">
                                <label for="text" class="control-label2 col-sm-4">Code:  </label>
                                <?php $Plate_code = mysqli_query($con, 'select * from tbl_vehicle_plate_codes order by vehicle_plate_code'); ?>
                                <select id="text-middle" size="1" name="code" onchange="get_veh_new_plate_number_update(this.value)" required>
                                   <option value="">Select Plate Code</option>
                                   <?php while($row = @mysqli_fetch_object($Plate_code)) { ?>
                                        <option value="<?php echo $row->vehicle_plate_code; ?>" <?php if(isset($search_result->code) && $search_result->code == $row->vehicle_plate_code) echo 'selected'; ?>><?php echo $row->vehicle_plate_code; ?></option>
                                   <?php } ?>
                                 </select>
                            </div>                    
                            <div class="form-group onemargin" style="margin-left:12px;">
                                <label for="date" class="control-label2 col-sm-4">Plate No:</label>
                                <?php if(isset($search_result->plate_no) && $search_result->plate_no != '')
                                         $plate_no = filter_var($search_result->plate_no, FILTER_SANITIZE_NUMBER_INT);
                                      else
                                         $plate_no = '';	
                                ?>
                                <input name="plate_no" type="text" style="width: 200px;" class="form-control" id="uplate_no" value="<?php echo isset($plate_no) ? $plate_no : '';?>" maxlength="4" required/>
                            </div>
                        </div>
                        <div class="stack">
                            <div class="row">
                                <div class="col-s">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Vehicle:</label>
                                            <select id="text-short" size="1"  name="vehicle" required>
                                               <option value="Gaari" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'Gaari') echo 'selected'; ?>>Gaari</option>
                                               <option value="Mooto" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'Mooto') echo 'selected'; ?>>Mooto</option>
                                               <option value="Bajaj" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'Bajaj') echo 'selected'; ?>>Bajaj</option>
                                               <option value="isjeed" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'isjeed') echo 'selected'; ?>>isjeed</option>
                                               <option value="Cagaf" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'Cagaf') echo 'selected'; ?>>Cagaf</option>
                                               <option value="rimoor" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'rimoor') echo 'selected'; ?>>rimoor</option>
                                               <option value="kreen" <?php if(isset($search_result->vehicle) && $search_result->vehicle == 'kreen') echo 'selected'; ?>>kreen</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">V.Type:</label>
                                            <?php echo $V_type_data;//$V_type = mysqli_query($con, 'select * from tbl_vehicle_types'); ?>
                                             
                                        </div>
                                        <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Model:</label>
                                            <input id="text-short" type="text" name="model" class="form-control" value="<?php echo isset($search_result->model) ? $search_result->model : '';?>"/>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-s">
                                    <div class="form-horizontal">
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Origin:</label>
                                    <?php //$Countries = mysqli_query($con, 'select * from tbl_country order by name'); ?>
                                        <select id="text-short" size="1" name="origin" required>
                                           <option value="">Select Origin</option>
                                           <?php //while($row = @mysqli_fetch_object($Countries)) { ?>
                                           <?php foreach($countries_data as $row) { ?>
                                                <option value="<?php echo $row->name; ?>" <?php if(isset($search_result->origin) && $search_result->origin == $row->name) echo 'selected'; ?>><?php echo $row->name; ?></option>
                                           <?php } ?>
                                         </select>
                                    </div>
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Color:  </label>
                                    <input id="text-short" type="text" name="color" class="form-control" value="<?php echo isset($search_result->color) ? $search_result->color : '';?>" required/>
                                    </div>
                                    <div class="form-group">
                                    <label for="date" class="control-label2 col-sm-4">Cylinder:</label>
                                    <input id="text-short" type="text" name="cylinder" class="form-control" value="<?php echo isset($search_result->cylinder) ? $search_result->cylinder : '';?>" required/>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-s2">
                                    <div class="form-horizontal">
                                    <div class="col-s last2">
                                    <div class="form-horizontal">
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Weight:</label>
                                    <input id="text-short" type="text" name="weight" class="form-control" value="<?php echo isset($search_result->weight) ? $search_result->weight : '' ;?>"/>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-s last2">
                                    <div class="form-horizontal">
                                    <div class="form-group">
                                    <label for="text"  class="control-label2 col-sm-4">HP:</label>
                                    <input id="text-short" type="text" name="hp" class="form-control" value="<?php echo isset($search_result->hp) ? $search_result->hp : '';?>"/>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="col-s last2">
                                <div class="form-horizontal">
                                    <div class="form-group">
                                <label for="text"  class="control-label2 col-sm-4">Passengers:</label>
                                <input id="text-short" type="text" name="passengers" class="form-control" value="<?php echo isset($search_result->passengers) ? $search_result->passengers : '';?>"  required />
                                </div>
                                </div>
                                </div>
                                    </div>
                                    </div>
                                    <div class="col-s last2" style="margin-left:50px;">
                                    <div class="form-horizontal">
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Engine No:</label>
                                    <input id="text-short" style="width:175px;" name="engine_no" type="text" class="22long form-control inch" value="<?php echo isset($search_result->engine_no) ? $search_result->engine_no : '';?>" required/>
                                    </div>
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Chassis No:    </label>
                                    <?php if(isset($search_result->chassis_no) && $search_result->chassis_no != '')
                                             $chassno = strtoupper($search_result->chassis_no);
                                          else
                                             $chassno = '';	 
                                    ?>
                                    <input id="text-short" style="width:175px;" type="text" name="chassis_no" class="22long form-control inch" value="<?php echo isset($chassno) ? $chassno : '';?>" onblur="this.value=this.value.toUpperCase();" required/><!-- onblur="this.value=this.value.toUpperCase();"-->
                                    <input id="text-short" style="width:175px;" type="hidden" name="hchassis_no" class="22long form-control inch" value="<?php echo $search_result->chassis_no;?>"/><!-- onblur="this.value=this.value.toUpperCase();"-->
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    <div class="form-horizontal comm">
                                    <div class="form-group">
                                    <label for="text" class="control-label col-sm-2 lab">Comments:</label>
                                    <div class="col-sm-4">
                                    <input id="text-long" type="text" class="form-control" name="comments" value="<?php echo isset($search_result->comments) ? $search_result->comments : '';?>"/>
                                    </div>
                                
                                <div class="col4">
                                    <?php if(isset($user_privileges[2]) && $user_privileges[2]['e'] == 1){    ?>
                                    	<a href="javascript:void(0);" onclick="submit_vehicle_update_form()" class="btn btn-lg btn-default"><span style="color:black" class="glyphicon glyphicon-edit"> Save</span></a>
                                    <?php } ?>     
                                    <a href="#" class="btn btn-lg btn-default pop"><span style="color:black" class="glyphicon glyphicon-refresh"> Renew</span></a>
                                     <input type="hidden" value="<?php echo isset($search_result->id) ? $search_result->id : '';?>" name="update_vehicle_record" />
                                     <input type="submit" value="sub" id="veh_update_sub_btn" style="display:none;" />
                                </div>
                                
                            </div>
                                    </div>
                        </form>
                        <script>
                           var vehicle_edit_orignal_receipt_no = '<?php echo isset($search_result->receipt_no) ? $search_result->receipt_no : '' ;?>';
                           function submit_vehicle_update_form()
                           { 
                               /*if($('.plate_no').val() == '')
                                {
                                    $('#uplate_no').focus();
                                    $('#show_error_msg').show().text('ERROR !  Please enter the plate number.');
                                    return false;
                                }
                                if($('.uplate_no').val().length != 4)
                                {
                                    $('#plate_no').focus();
                                    $('#show_error_msg').show().text('ERROR !  Please enter the correct plate number 4 digits.');
                                    return false;
                                }  */
                                var birthdate1	=	$("#birth_date1").val();
                                if(birthdate1 != '')
                                {
                                    fnValidateDOB(birthdate1);
                                }
                                
                                if($("#vehicle_edit_receipt_no").val() == '')
                                { 
                                     $('#show_error_msg').show().text('ERROR !  Please enter receipt number.');
                                     return false;
                                }
                                if(vehicle_edit_orignal_receipt_no != $('#vehicle_edit_receipt_no').val())
                                {
                                    check_vehicle_receipt_no_in_edit($('#vehicle_edit_receipt_no').val());
                                    //alert(check_receipt);
                                    //if(check_receipt)
                                        //$('#licence_update_sub_btn').trigger('click');
                                }
                                else
                                    $('#veh_update_sub_btn').trigger('click');
                                
                           }
                         </script>
                        <!-- //////////////////////////////////
                                POP up  >>>> Renewal
                        -->
                        <div class="overlay">
                            <div class="popup">
                                <div class="closeBtn">
                                    <div class="fa fa-close"></div>
                                </div>
                                <p>Vehicle Renewal Table</p>
                                <div class="alert alert-danger" id="licence_renew_error_msg" style="display:none;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                                <div class="alert alert-success" id="licence_renew_success_msg" style="display:none;color:#144C15;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                                <form role="form" class="form-inline">
                                    <div class="form-group">
                                        <label type="text" style="padding-left: 0px" class="control-label col-sm-6">Vehicle No: </label>
                                        <div class="col-sm-2"><input id="text" type="text" readonly="readonly" class="form-control" value="<?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?>"/></div>
                                        <br/>
                                        <label type="text" style="padding-left: 0px" class="control-label col-sm-6">Owner's Name: </label>
                                        <div class="col-sm-2"><input id="text" type="text" class="form-control" value="<?php echo isset($search_result->Owner) ? $search_result->Owner : '';?>" style="width:300px"/></div>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="success">
                                                <th style="width:80px" class="small-font">Receipt No</th>
                                                <th style="width:60px" class="small-font">Amount </th>
                                                <th class="small-font">Renewal Type</th>
                                                <th class="small-font">Renewal Date</th>
                                                <th class="small-font">Expire Date</th>
                                                <th class="small-font"></th>
                                            </tr>
                                            <tr class="active">
                                              <form method="post" id="uploadForm" action="model/vehicle_renewal_model.php" >
                                                <td><input id="text" type="text" placeholder="10001" name="receipt_no" onkeyup="get_receipt_data_vehicle_renew(this.value);" class="form-control insider receipt_no"/></td>
                                                <td><input id="text" type="text" placeholder="$50" name="amount" readonly="readonly" class="form-control insider licence_renew_fee"/></td>
                                                <td>
                                              	<input id="licence_renew_hide_renewaldate" type="hidden" placeholder="dd-mm-yy" name="licence_renew_hide_renewaldate" required class="form-control insider licence_renew_hide_renewaldate" value="<?php echo isset($search_result->issue_date) ? date('d-m-Y', strtotime($search_result->issue_date)) : (isset($_SESSION['VEHISSDATE']) ? $_SESSION['VEHISSDATE'] : '');?>" />
                                                <input id="licence_renew_hide_expirydate" type="hidden" placeholder="dd-mm-yy" name="licence_renew_hide_expirydate" required class="form-control insider licence_renew_hide_expirydate" value="<?php echo isset($search_result->expiry_date) ? date('d-m-Y', strtotime($search_result->expiry_date)) : (isset($_SESSION['VEHEXPDATE']) ? $_SESSION['VEHEXPDATE'] : ''); ?>"/> 
                                               
                                            <select id="renewal_type" class="text-short" size="1" style="padding:0" name="renewal_type" onchange="Change_vehicle_renewal_type(this.value)">
                                                <option value="0">Select Type</option>
                                                <option value="1">For Expire</option>
                                                <option value="2">For Damage</option>
                                                <option value="3">For Lost</option>
                                                <option value="4">Duplicate book</option> 
                           			<option value="5">Duplicate plate</option>
                                            </select>
                                                </td>
                                                <td>
                                                <input id="renewal_current_date" type="hidden" placeholder="dd-mm-yy" name="renewal_current_date" required class="form-control insider renewal_current_date" value="<?php echo date('d-m-Y');?>" /> 
                                                <input id="issue_date3" type="text" placeholder="dd-mm-yy" name="renewal_date" class="form-control insider licence_renew_issue_date" onkeyup="Change_expire_date_vehicle_renewal(this.value)"  onkeypress="DateFormat(this,event.keyCode)"/></td>
                                                <td><input id="expire_date3" type="text" placeholder="dd-mm-yy" name="expire_date" class="form-control insider licence_renew_expire_date" /></td>
                                                <td><a href="javascript:void(0);" onclick="submit_vehicle_renewal_form()" style="color: green" class="fa fa-save"></a>
                                                    <input type="hidden" name="vehicle_renewal_form_data" value="1"/>
                                                    <input type="hidden" name="vehicle_renewal_plate_no" id="vehicle_renewal_plate_no" value="<?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?>"/>
                                                   
                                                </td>
                                               </form>
                                            </tr>
                                        </thead>
                                        <tbody id="vehicle_renewal_data_area">
        
                                            <?php
                                              if(isset($_POST['search_vehicle_no']))
                                              {
                                                   $rec_id = $_POST['search_vehicle_no'];
                                                   $page = 1;
                                                   $per_page = 5; // Set how many records do you want to display per page.
                                                   $startpoint = ($page * $per_page) - $per_page;
                                                   $statement = "`tbl_vehicle_renewal` where plate_no = '".mysqli_real_escape_string($con, $_POST['search_vehicle_no'])."'  ORDER BY `id` DESC"; // Change `records` according to your table name.
                                                   $licence_renew = mysqli_query($con, "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
                                                   if(mysqli_num_rows($licence_renew) > 0){
        
                                                   while($rec = @mysqli_fetch_object($licence_renew))
                                                   {  // licence_no
                                                       $renewal_type = '';
                                                       if($rec->renewal_type == 1)
                                                           $renewal_type = 'For Expire';
                                                       else	if($rec->renewal_type == 2)
                                                           $renewal_type = 'For Damage';
                                                       else if($rec->renewal_type == 3)
                                                           $renewal_type = 'For Lost';
                                                       else if($rec->renewal_type == 4)
                                                           $renewal_type = 'Duplicate book';
                                                       else if($rec->renewal_type == 5)
                                                           $renewal_type = 'Duplicate plate';
        
        
                                              ?>
                                                    <tr>
                                                        <td><?php echo $rec->receipt_no; ?></td>
                                                        <td>$<?php echo number_format($rec->amount,2); ?></td>
                                                        <td><?php echo $renewal_type; ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($rec->renewal_date)); ?></td>
                                                        <td><?php echo date('d/m/Y', strtotime($rec->expire_date)); ?></td>
                                                        <!--<td><a href="javascript:void(0)" style="color: red" onclick="vehicle_renewal_delete_record('<?php echo $rec->id;?>');" class="fa fa-trash"></a></td>-->
                                                    </tr>
                                               <?php }
                                                   }else{
                                                ?>   <tr><td colspan="6" style="color:red;">No record found</td></tr>
                                                <?php }
                                              }
                                              ?>
                                        </tbody>
                                    </table>
        
                                </div>
                                <div id="licence_renewal_pagination_area">
                                 <?php
                                  if(isset($_POST['search_vehicle_no']))
                                  {
                                 // displaying paginaiton.
                                     $_SESSION['licence_renewal_statement'] = $statement;
                                     echo ajax_pagination($statement,$per_page,$page,$url='vehicle_renewal_pagination', $con);
                                  }
                                ?>
                                </div>
                                 <script>
                                    $("#uploadForm").on('submit',(function(e) {
                                        e.preventDefault();
                                        $.ajax({
                                            url: "model/vehicle_renewal_model.php",
                                            type: "POST",
                                            data:  new FormData(this),
                                            contentType: false,
                                            cache: false,
                                            processData:false,
                                            success: function(data){
                                               if(data == 'yes')
                                               {
                                                   $('#licence_renew_success_msg').show().text('New records added successfully.');
                                                   get_latest_vehicle_renewal_record();
                                                   $('.insider').val('');
                                                   window.setTimeout('location.reload()', 3000);
                                               }
                                               else
                                                  $('#licence_renew_error_msg').show().text('ERROR !  Some thing wrong, please try again.');
                                            },
                                            error: function() {
                                            }
                                       });
                                    }));
                                    function submit_vehicle_renewal_form()
                                    {
                                        var is_error = 0;
                                        if($('.receipt_no').val() == '')
                                        {
                                            $('#licence_renew_error_msg').html('Please Enter Recipt number').show();
                                            is_error = 1;
                                            setTimeout(function(){
                                                 $('#licence_renew_error_msg').html('').hide();
                                            }, 4000);
                                            $('.receipt_no').focus();
                                        }
                                        else if($('#renewal_type').val() == 0)
                                        {
                                            $('#licence_renew_error_msg').html('Please Select Renewal Type').show();
                                            is_error = 1;
                                            setTimeout(function(){
                                                 $('#licence_renew_error_msg').html('').hide();
                                            }, 4000);
                                            $('#renewal_type').focus();
                                        }
                                        
                                        if(is_error == 0)
                                        {
                                            $.ajax({
                                                url:"model/licence_renewal_model.php",
                                                type:'POST',
                                                data:'action=validate_receipt_no&receipt_no='+$('.receipt_no').val(),
                                                beforeSend: function(){
                                                    $('#licence_renew_success_msg').html('').hide();
                                                    $('#licence_renew_error_msg').html('').hide();
                                                },
                                                success:function(result){
                                                    if(result == 'yes')
                                                    {
                                                        //$('#sub_btn_veh_renewal').trigger('click');
                                                        $('#uploadForm').submit();
        
                                                    }
                                                    else if(result == 'no')
                                                    {
                                                        $('#licence_renew_error_msg').show().text('ERROR !  Receipt number not available.');
                                                        $('.receipt_no').focus();
        
                                                    }
                                                }
                                            });
                                        }
                                        else
                                           $('.receipt_no').focus();
        
                                    }
                                    </script>
                      <script>	
                         $(document).ready(function(e) {  
                            $("#expire_date3").val($('#vehicle_plate_expire_date').val());
                        });	
                            function Change_vehicle_renewal_type(val)
                            {
                                var renewaltype		=	$("#renewal_type option:selected" ).val();
                                var hide_issdate	=	$("#licence_renew_hide_renewaldate").val();
                                var hide_expdate	=	$("#licence_renew_hide_expirydate").val();
                                var renewal_date	=	$("#issue_date3").val();
                                var currentdate		=	$("#renewal_current_date").val();
                                 //alert(hide_expdate);
                                
                                if(renewaltype == 1)  // for expire
                                {
                                    //$("#issue_date3").removeAttr('readonly');
                                    $("#issue_date3").attr('readonly','readonly');	
                                    //$("#expire_date3").removeAttr('readonly');
                                    //$("#issue_date3").attr("onkeyup");							
                                    $(".licence_renew_issue_date").val(currentdate);  
                                    Change_expire_date_vehicle_renewal($('#renewal_current_date').val());	
                                }
                                else
                                {	 
                                    //$("#issue_date3").removeAttr("onkeyup");							
                                    $("#issue_date3").attr('readonly','readonly');	
                                    $("#issue_date3").val($('#vehicle_plate_issue_date').val());									
                                                        
                                    $("#expire_date3").attr('readonly','readonly');
                                    $("#expire_date3").val($('#vehicle_plate_expire_date').val());
                                }
                            }
                                
                            function Change_expire_date_vehicle_renewal(val)
                            { 
                                var renewaltype		=	$("#renewal_type option:selected" ).val();
                                
                                var hide_issdate	=	$("#licence_renew_hide_renewaldate").val();
                                var hide_expdate	=	$("#licence_renew_hide_expirydate").val();
                                
                                var dateAr = val.split('-');
                                var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
                                var someDate = new Date(newDate);
                                //alert(someDate);
                                var numberOfDaysToAdd = <?php echo ONEYEAR; ?>; // 2 year 730;//
                                someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
                                
                                if(!isNaN(someDate.getTime()))
                                {
                                    //alert(someDate);
                                    //alert(someDate.getDate());
                                    var day = someDate.getDate();
                                    if (day < 10) 
                                        day = "0" + day;
                                        
                                    var month = someDate.getMonth() + 1;
                                    if (month < 10) {
                                        month = "0" + month;
                                    }
                                    var year = someDate.getFullYear();
                                    newDate = day + '-' + month + '-' + year;
                                    
                                    if(renewaltype == 1)
                                    {
                                        //alert("1");
                                        $(".licence_renew_expire_date").val(newDate);
                                    }
                                    else
                                    {
                                        //alert("2");
                                        $(".licence_renew_issue_date").val(hide_issdate);
                                        $(".licence_renew_expire_date").val(hide_expdate);
                                    }
                                }
                                else
                                    $(".licence_renew_expire_date").val('dd/mm/yy');
                            }
                            
                             $(document).ready(function(e) {
                                $("#issue_date3").attr('readonly','readonly');	
                                $(".licence_renew_issue_date").val($("#renewal_current_date").val()); 
                                Change_expire_date_vehicle_renewal($('#renewal_current_date').val());
                            });
                            </script>
                           </div>
                       </div>
                       
                     </div>
           <?php 
			 }
			?>
            <!-- ????????????????????????????????????????????????????????????
                 **********************************************************
           -->
           <?php if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') { 
		   		// Check permission
				if(isset($user_privileges[2]) && $user_privileges[2]['r'] == 1)
				{
		   ?>
                   <div id="search-vehicle" class="tab-pane <?php if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') echo 'active'; else echo 'fade'; ?>">
                            <?php if(isset($user_privileges[2]) && $user_privileges[2]['r'] == 1){ ?>
                            <div class="search-border">Search by</div>
                            <form role="form" class="form-inline">
                                <div class="form-group">
                                    <label for="text">Number:</label>
                                    <input id="text" type="text" onkeyup="get_v_record_by_number(this.value)" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="number">Name:</label>
                                    <input id="text" type="text" onkeyup="get_v_record_by_name(this.value)" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="number">V.Type:</label>
                                    <input id="text" type="text" onkeyup="get_v_record_by_v_type(this.value)" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="number">Contact:</label>
                                    <input id="text" type="text" onkeyup="get_v_record_by_v_contact(this.value)" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label for="number">Chassis:</label>
                                    <input id="text" type="text" onkeyup="get_v_record_by_v_chassis(this.value)" class="form-control"/>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="success">
                                            <th>Plate No</th>
                                            <th>Owner's Name</th>
                                            <th>Expire Date</th>
					    <th>V.type</th>	
                                            <th>Model</th>
                                            <th>Color</th>
                                            <th>Chassis No</th>
                                            <th>HP</th>
                                            <th></th>
                                        </tr>
                                   </thead>
                                   <tbody id="vechicle_records_area">
                                    <?php
                                     $page = 1;
                                     $per_page = 10; // Set how many records do you want to display per page.
                                     $startpoint = ($page * $per_page) - $per_page;
                                     $statement = "`tbl_vehicles` ORDER BY `id` DESC"; // Change `records` according to your table name.
                                     $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
                                     //$sql = 'SELECT * from tbl_acc_type';
                                     //$data = mysqli_query($con, $sql);
                                     while($rec = mysqli_fetch_object($data))
                                     {   //acc_no  acc_name date acc_type amount comments
                                          /*
                                      Owner birth_day nationality birth_place mother_name mobile_no email address gender
                                      personal_id fees issue_date expire_date plate_no
                                        plate_type code vehicle origin weight engine_no v_type color hp chassis_no
                                        model cylinder comments issue_place
                                      */
                                    ?>
                                         <tr>
                                            <td><?php echo $rec->plate_no;?></td>
                                            <td><?php echo $rec->Owner;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($rec->expire_date));?></td>
					    <td><?php echo $rec->v_type;?></td>
                                            <td><?php echo $rec->model;?></td>
                                            <td><?php echo $rec->color;?></td>
                                            <td><?php echo $rec->chassis_no;?></td>
                                            <td><?php echo $rec->hp;?></td>
                                            <td><a href="?search_vehicle_no=<?php echo $rec->plate_no; ?>" class="fa fa-print"></a></td>
                                         </tr>
                                    <?php // onclick="PrintVehicle('#tab')"
                                     }
                                     if(mysqli_num_rows($data) == 0)
                                     {
                                    ?>
                                          <tr><td colspan="12" align="center"><span style="color:#F00;"> No record found</span></td></tr>
                                    <?php
                                      }
                                    ?>
                                   </tbody>
                                </table>
                                <a href="javascript:void(0);" class="btn btn-lg btn-default" style="display:none;" id="print_vehicle" onclick="PrintVehicle_auto('#tab')"><span class="glyphicon glyphicon-print"> Print </span></a>
                            </div>
                            <style>
                            .page_info { margin: 10px;}
                            .current{
                                color: #fff !important;
                                cursor: default !important;
                                background-color: #337ab7 !important;
                                border-color: #337ab7 !important;
                             }
                            </style>
                            <div id="pagination_area_vehicle">
                            <?php
                             // displaying paginaiton.
                             $pagination_data = array('current_statement' => $statement,
                                                      'per_page' => $per_page,
                                                      'current_page' => $page,
                                                      'db_con' => $con
                                                      );
                             $_SESSION['pagination_data'] = $pagination_data;
                            echo ajax_pagination($statement,$per_page,$page,$url='vehicles_pagination', $con);
                            ?>
                            </div>
                            <?php } ?>
                                                <hr/>
                           <?php if(isset($logged_in_user->id) && $logged_in_user->id == 1){ ?>
                            <!--<div class="upload-csv">
                                    <h4>Upload .csv file to database</h4>
                                <form role="form" class="upload" method="post" action="model/upload_csv.php"  enctype="multipart/form-data">
                                    <input id="file" type="file" name="csv_file_for_vehicles" required="required" class="inputfile"/>
                                    <label for="file" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Select .csv</span></label>
                                    <input id="send" type="submit" name="submit" class="inputfile"/>
                                    <a href="javascript:void(0);" onclick="show_message()" class="btn btn-lg btn-default">
                                        <span class="glyphicon glyphicon-upload"> Upload .csv</span>
                                      </a>
                                    <label for="send" class="btn btn-lg btn-default" id="csv_upload_btn" style="display:none;">Upload</label>
                                    <p style="display:none;" id="csv_msg">CSV file data has been adding in database. It may take few minutes.<br/>
                                    Please Wait......</p>
                                </form>
                            </div>-->
        
        
                            <?php } ?>
                           <!-- <script>
                            function show_message()
                            {
                                $('#csv_upload_btn').trigger('click');
                                if($('#file').val() != '')
                                    $('#csv_msg').show();
                            }
                            </script>-->
                        </div>
           <?php }else{ ?>  
           		   <br/><div class="alert-danger" style="padding: 15px;"> You don't have permission to view this page. </div>
           <?php }
			 }
			?>      
          <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->

          <!-- ///////////////////////////////////////////////////////
                          Card List
          -->
          <?php if(isset($_GET['section']) && $_GET['section'] == 'card_list'){  ?> 
                  <div id="card-list2" class="tab-pane <?php if(isset($_GET['section']) && $_GET['section'] == 'card_list') echo 'active'; else echo 'fade'; ?>">
                        <div class="search-border2">Search by date</div>
                        <form role="form" class="form-inline">
                            <div class="form-group">
                                <label for="text">From Date:</label><input id="by_from_date" onkeyup="get_v_card_record_by_from_date(this.value)" type="text" class="form-control" onkeypress="DateFormat(this,event.keyCode)" />
                            </div>
                            <div class="form-group">
                            <label for="number">To Date:</label><input id="by_to_date" onkeyup="get_v_card_record_by_to_date(this.value)" type="text" class="form-control" onkeypress="DateFormat(this,event.keyCode)"/>
                            </div>
                            <div class="form-group">
                            <label for="number">Name:</label><input id="text" onkeyup="get_v_card_record_by_name(this.value)" type="text" class="form-control"/>
                            </div>
                         </form>
                         <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="success">
                                        <th>Plate No</th>
                                        <th>Owner's Name</th>
                                        <th>Nationality</th>
                                        <th>Date Issued</th>
                                        <th>Place of Issue</th>
                                        <th>Expire Date</th>
                                        <th>Model</th>
                                        <th>Color</th>
                                        <th> Vehicle Type</th>
                                        <th>Origin</th>
                                        <th>Passengers</th>
                                        <th>Chassis No</th>
                                        <th> </th>
                                  </tr>
                                  <tr class="active">
                                      <form method="post" action="model/vehicles_model.php<?php if(!empty($search_result_m)) echo '?cardlist_id='.$_GET['cardlist_id'];?>">
                                        <th><input type="text" name="cl_plate_no" placeholder="Plate No" required="required" value="<?php echo isset($search_result_m->plate_no) ? $search_result_m->plate_no : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_owner" required placeholder="Owner" value="<?php echo isset($search_result_m->Owner) ? $search_result_m->Owner : '' ;?>" class="insider"/></th>
                                        <th><input type="text"  name="cl_nationality" required  placeholder="Nationality" value="<?php echo isset($search_result_m->nationality) ? $search_result_m->nationality : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_issue_date" placeholder="dd-mm-yy" value="<?php echo isset($search_result_m->issue_date) ? date('d-m-Y', strtotime($search_result_m->issue_date)) : '' ;?>" class="insider"/></th>
                                        <th>
                                        <!--<input type="text" name="cl_issue_place" placeholder="Issue Place" value="<?php echo isset($search_result_m->issue_place) ? $search_result_m->issue_place : '' ;?>" class="insider"/>-->
                                 <select id="text-short" size="1" name="cl_issue_place" placeholder="Issue Place">
                                    <option value="<?php echo $ArIssuePlace[0]?>" <?php if(isset($search_result_m->issue_place) && $search_result_m->issue_place == $ArIssuePlace[0]) echo 'selected'; ?>><?php echo $ArIssuePlace[0]?></option>
                                 </select>    
                                        </th>
                                        <th><input type="text" name="cl_expire_date" placeholder="dd-mm-yy" value="<?php echo isset($search_result_m->expire_date) ? date('d-m-Y', strtotime($search_result_m->expire_date)) : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_model" placeholder="Model" value="<?php echo isset($search_result_m->model) ? $search_result_m->model : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_color" placeholder="Color" value="<?php echo isset($search_result_m->color) ? $search_result_m->color : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_v_type" placeholder="V-Type" value="<?php echo isset($search_result_m->v_type) ? $search_result_m->v_type : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_origin" placeholder="Origin" value="<?php echo isset($search_result_m->origin) ? $search_result_m->origin : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_passengers" placeholder="Passengers" value="<?php echo isset($search_result_m->passengers) ? $search_result_m->passengers : '' ;?>" class="insider"/></th>
                                        <th><input type="text" name="cl_chassis_no" required placeholder="Chassis No" value="<?php echo isset($search_result_m->chassis_no) ? $search_result_m->chassis_no : '' ;?>" class="insider"  onblur="this.value=this.value.toUpperCase();"/></th>
                                        <th colspan="2"><a href="javascript:void(0)" onclick="submit_cl_form()" class="glyphicon glyphicon-floppy-disk"></a>
                                            <input type="submit" id="cl_form_sub"  style="display:none;"/>
                                            <input type="hidden" name="cl_form_add" value="1" />
                                        </th>
                                      </form>
                                   </tr>
                                </thead>
                                <tbody id="vechicle_card_records_area">
        
                                 <?php
                                     $page = 1;
                                     $per_page = 10; // Set how many records do you want to display per page.
                                     $startpoint = ($page * $per_page) - $per_page;
                                     $statement = "`tbl_v_cardlist` 
                                                    where DATE(created_datetime) = curdate()
                                                    ORDER BY `trans_id` DESC"; // Change `records` according to your table name.
                                     $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
                                     //echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}"; 
                                    // echo '<br/>Error : '.mysqli_error($con).'<br/>';; 
                                     //$sql = 'SELECT * from tbl_acc_type';
                                     //$data = mysqli_query($con, $sql);
                                     while($rec = mysqli_fetch_object($data))
                                     {   //acc_no  acc_name date acc_type amount comments
                                          /*
                                      Owner birth_day nationality birth_place mother_name mobile_no email address gender
                                      personal_id fees issue_date expire_date plate_no
                                        plate_type code vehicle origin weight engine_no v_type color hp chassis_no
                                        model cylinder comments issue_place
                                      */
                                    ?>
                                         <tr>
                                            <td><?php echo $rec->plate_no;?></td>
                                            <td><?php echo $rec->owner;?></td>
                                            <td><?php echo $rec->nationality;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($rec->date_issue));?></td>
                                            <td><?php echo $rec->place_issued;?></td>
                                            <td><?php echo date('d/m/Y', strtotime($rec->expire_date));?></td>
                                            <td><?php echo $rec->model;?></td>
                                            <td><?php echo $rec->color;?></td>
                                            <td><?php echo $rec->vehicle_type;?></td>
                                            <td><?php echo $rec->origin;?></td>
                                            <td><?php echo $rec->passengers;?></td>
                                            <td><?php echo $rec->chassis_no;?></td>
                                            <td>
                                                <?php if(isset($user_privileges[2]) && $user_privileges[2]['e'] == 1){ ?>
                                                	<a href="?cardlist_id=<?php echo ($rec->plate_no); ?>" class="glyphicon glyphicon-edit"></a>
                                                <?php } ?>    
                                                <a href="?search_card_vehicle_no=<?php echo $rec->plate_no; ?>" class="fa fa-print"></a>
                                            </td>
                                         </tr>
                                    <?php // onclick="PrintVehicle('#tab')"
                                     }
                                     if(mysqli_num_rows($data) == 0)
                                     {
                                    ?>
                                          <tr><td colspan="12" align="center"><span style="color:#F00;"> No record found</span></td></tr>
                                    <?php
                                      }
                                    ?>
                                </tbody>
                            </table>
                            <script>
                            function submit_cl_form()
                            {
                                $('#cl_form_sub').trigger('click');
                            }
                            </script>
                         </div>
                         <style>
                            .page_info { margin: 10px;}
                            .current{
                                color: #fff !important;
                                cursor: default !important;
                                background-color: #337ab7 !important;
                                border-color: #337ab7 !important;
                             }
                            </style>
                            <div id="pagination_card_area_vehicle">
                            <?php
                            // displaying paginaiton.
                             $pagination_data = array('current_statement' => $statement,
                                                      'per_page' => $per_page,
                                                      'current_page' => $page,
                                                      'db_con' => $con
                                                      );
                             $_SESSION['vehicle_card_pagination_data'] = $pagination_data;
                             $_SESSION['vehicle_card_statement'] = $statement;
                             echo ajax_pagination($statement,$per_page,$page,$url='vehicles_card_pagination', $con);
                             
                             
                           // echo ajax_pagination_Card_list(mysqli_num_rows($data_pagination),$per_page,$page,$url='vehicles_card_pagination', $con);
                            ?>
                            </div>
        
        
                         <!--<div class="upload-csv"><h4> Upload .csv file to database </h4><form class="upload"><label for="csv_file_field" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Select .csv</span></label><input id="csv_file_field" style="padding: 0px;" class="form-control inputfile"/><a href="#" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-upload"> Upload .csv</span></a></form></div>-->
                         
                         </div>
          <?php 
			 }
			?>       

          <!-- --------------------------------------------------------- -->
           <?php if(isset($_GET['section']) && ($_GET['section'] == 'vehicle_search' || $_GET['section'] == 'card_list')) { ?>
            <div  id="tab" style="display:none;">
                <?php require_once('inc/header_rpt.php'); ?>
                <h3> <center>Xogta Gaadiidka Iyo Milkilaha</center></h3>
                <div style="padding-left:20px;">
                    <div><strong>Milkilaha:</strong></div>
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="left" style="text-align:left;">
                           <th  align="left" style="padding:5px;text-align:left;">Taariikhda: </th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo date('d M, Y'); ?></td>
                        </tr>

                        <!--<tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Rigistarka:</th>
                           <td align="left" style="padding:5px;text-align:left;"></td>
                        </tr>-->
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Magaca Milkilaha:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->Owner) ? $search_result->Owner : '';?></td>
                        </tr>
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Magaca Hooyada:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->mother_name) ? $search_result->mother_name : '';?></td>
                        </tr>
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Taar. Dhalashada:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->birth_date) ? date('d-m-Y', strtotime($search_result->birth_day)) : '';?></td>
			</tr>
                        <tr>
                           <th align="left" style="padding:5px;text-align:left;">Degaaanka:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->address) ? $search_result->address : '';?></td>
                        </tr>
                        <tr align="left">
                           <th  align="left" style="padding:5px;text-align:left;">Teleefanka:</th>
                           <td align="left" style="padding:5px;text-align:left;" ><?php echo isset($search_result->mobile_no) ? $search_result->mobile_no : '';?></td>
                        </tr>
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Faahfaahin:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->comments) ? $search_result->comments : '';?></td>
                        </tr>

                     </table>
                </div>
                <div style="padding-left:20px;">
                    <div><strong><br />Taargada:</strong></div>
      		<table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Koodka: </th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->plate_type) ? $search_result->plate_type : '';?></td>
                           <th align="left" style="padding:5px;text-align:left;">Lambarka: </th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?></td>
                        </tr>

                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Laga bixiyay:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->issue_date) ? date('d/m/Y', strtotime($search_result->issue_date)) : '';?> </td>
                           <th align="left" style="padding:5px;text-align:left;">Nooca:</th>
                           <td align="left" style="padding:5px;text-align:left;"> <?php echo isset($search_result->code) ? $search_result->code : '';?></td>
                        </tr>
                     </table>

                    <div><strong><br />Gaadiidka:</strong></div>
              	<table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Nooca: </th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->v_type) ? $search_result->v_type : '';?></td>
                           <th align="left" style="padding:5px;text-align:left;">Moodelka: </th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->model) ? $search_result->model : '';?></td>
                        </tr>

                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">Dalka samayay:</th>
                           <td align="left" style="padding:5px;text-align:left;"> <?php echo isset($search_result->origin) ? $search_result->origin : '';?></td>
                           <th align="left" style="padding:5px;text-align:left;">Misaanka:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->weight) ? $search_result->weight : '';?></td>
                        </tr>
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">L.Makiinada:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->engine_no) ? $search_result->engine_no : '';?> </td>
                           <th align="left" style="padding:5px;text-align:left;">Midabka:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->color) ? $search_result->color : '';?> </td>
                        </tr>
                        <tr align="left">
                           <th align="left" style="padding:5px;text-align:left;">L.jaasiga:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->chassis_no) ? $search_result->chassis_no : '';?></td>
                           <th align="left" style="padding:5px;text-align:left;">T.Rakaabka:</th>
                           <td align="left" style="padding:5px;text-align:left;"><?php echo isset($search_result->passengers) ? $search_result->passengers : '';?></td>
                        </tr>
                     </table>
                </div>
                <div style="padding-left:20px;">
                     <div><strong><br />
                     Buuga jadiidinta</strong></div>
              <table style="width:98%;border-top:1px solid #666;">
                        <thead >
                            <tr >
                                <th style="text-align:left;">L.Taargada</th>
                                <th style="text-align:center;">Nooca </th>
                                <th style="text-align:center;">T.Jadiidinta</th>
                                <th style="text-align:center;">T.dhicitaanka</th>
                                <th style="text-align:center;">L.Boonada</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-top:1px solid #666;" colspan="5"></td>
                            </tr>
                            <?php
							 if(isset($_REQUEST['search_vehicle_no']) && $_REQUEST['search_vehicle_no'] != '')
							 {
								$data = mysqli_query($con,"SELECT * FROM tbl_vehicle_renewal where plate_no = '".mysqli_real_escape_string($con, $_REQUEST['search_vehicle_no'])."' ");
								while($row = mysqli_fetch_object($data))
							 	{
							 ?>
                        <tr>
                            <td align="left"><?php echo isset($row->plate_no) ? $row->plate_no : '';?></td>
                            <td align="center"><?php 
							if($row->renewal_type == 1)
								echo   $renewal_type = 'For Expire';
							   else	if($row->renewal_type == 2)
								echo   $renewal_type = 'For Damage';
							   else if($row->renewal_type == 3)
								echo   $renewal_type = 'For Lost';
							   else if($row->renewal_type == 4)
								echo   $renewal_type = 'Duplicate book';	
                               else if($row->renewal_type == 5)
							    echo   $renewal_type = 'Duplicate plate';

												   
							//echo isset($row->renewal_type) ? $row->renewal_type : '';?></td>
                            <td align="center"><?php echo isset($row->renewal_date) ? date('d/m/Y', strtotime($row->renewal_date)) : '';?></td>
                            <td align="center"><?php echo isset($row->expire_date) ? date('d/m/Y', strtotime($row->expire_date)) : '';?></td>
                            <td align="center"><?php echo isset($row->receipt_no) ? $row->receipt_no : '';?></td>
                        </tr>
                            <?php
								}
							}else{
							?>
                              <tr>
                                <td style="color:red;" colspan="5" align="center">No record found</td>
                              </tr>
                            <?php
							}
							?>
                        <tbody>
                     </table>
                </div>

            </div>
           <?php } ?>  
          <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->
           </div>
      </div>

    <script>
	$(document).ready(function(e) {
        <?php if(isset($_GET['search_vehicle_no'])){ ?>
    		//$('#print_licence_cardlist').trigger('click');
			//PrintReports('#tab');
	    <?php } ?>
		<?php if(isset($_GET['search_card_vehicle_no'])){ ?>
    		//$('#print_licence_cardlist').trigger('click');
			PrintReports('#tab');
	    <?php } ?>
    });
	</script>
    <script src="assets/js/functions.js"></script>
 <?php /* ###############
         Footer
	  */
	  include_once('inc/footer.php');
?>
<script> 
$(document).ready(function(e) {
	$( "#birth_date" ).datepicker({		
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, fnValidateDOB(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
	$( "#birth_date1" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, fnValidateDOB(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });	
	$( "#by_from_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_by_from_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#by_to_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_by_to_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
});
$(document).ready(function(e) { 
	<?php if(isset($search_result->v_type)) { ?>
	    
    	$('.edit_v_type_option').val('<?php echo $search_result->v_type; ?>');
	<?php } ?>	
});
 </script>