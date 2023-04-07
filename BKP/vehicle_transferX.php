<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];

	  //  Owner   Birth Date:
	  /*
	  Owner birth_day nationality birth_place mother_name mobile_no email address gender personal_id fees issue_date expire_date plate_no
		plate_type code vehicle origin weight engine_no v_type color hp chassis_no model cylinder comments issue_place
      */

	  // Show vehicle record after search....
	   if(isset($_REQUEST['search_vehicle_no']) && $_REQUEST['search_vehicle_no'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where plate_no = '".mysqli_real_escape_string($con, $_REQUEST['search_vehicle_no'])."' ");
			$search_result = mysqli_fetch_object($data);
			if(empty($search_result))
			    $_SESSION['error'] = 'ERROR !  Vehicle with Plate No '.$_REQUEST['search_vehicle_no'].' is not found.';
	   }



?>

<script>   
/*$(function() {
	$( "#record_from_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_by_from_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#record_to_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_by_to_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
});*/
 </script>
        <div class="right-nav">
            <ul class="nav nav-tabs">
            	<li class="active"><a data-toggle="tab" href="#vehicle-transfer">Vehicle</a></li>
                <li <?php if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') { ?> class="active" <?php } ?>><a data-toggle="tab" href="#search-vehicle">Search Vehicle</a></li>
                <li><a data-toggle="tab" href="#card-list3">Card List</a></li>
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
                <?php /*?><div id="vehicle-transfer" class="tab-pane fade in active" style="display:none;">
                    <form role="form" class="form-inline"><div class="form-group"><label for="text">Search by:</label><input id="text" type="text" placeholder="Chassis No" class="form-control"/><div class="fa-stack fa-lg"><i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-search fa-stack-1x"> </i></div></div></form><form role="form" class="form-inline mar1"><div class="form-group"><label for="text" class="control-label3 col-sm-4">Issue Place:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Receipts No:</label><input id="text-short" type="text" class="form-control"/></div></form><form role="form" class="form-inline mar1"> <div class="form-group"><label for="date" class="control-label2 col-sm-4">Fees:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Issue Date:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Expire Date:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Owner:</label><input id="text-long" type="text" class="form-control"/></div></form><div class="stack"><div class="row"><div class="col"><form role="form" class="form-horizontal"><div class="form-group"><label for="date" class="control-label2 col-sm-4">Birth Date:</label><input id="text-middle" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Birth Place:</label><input id="text-middle" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Gender:</label><input id="text-middle" type="text" class="form-control"/></div></form></div><div class="col2"><form role="form" class="form-horizontal"><div class="form-group"><label for="text" class="control-label2 col-sm-4">Nationality:</label><input id="text-middle" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Mother's Name:</label><input id="text-middle" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Personal ID:</label><input id="text-middle" type="text" class="form-control"/></div></form></div><div class="col3"><form role="form" class="form-horizontal"><div class="form-group"><label for="text" class="control-label2 col-sm-4">Mobile No:</label><input id="text-middle" type="text" class="form-control inch"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Address:</label><input id="text-middle" type="text" class="form-control inch"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Email:</label><input id="text-middle" type="text" class="form-control inch"/></div></form></div></div></div>
                    <form role="form" class="form-inline mar1"> <div class="form-group onemargin"><label for="date" class="control-label2 col-sm-4">Plate No:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group onemargin2"><label for="text" class="control-label2 col-sm-4">Plate Type:</label><input id="text-middle" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Code:  </label><input id="text-middle" type="text" class="form-control inch"/></div></form><div class="stack"><div class="row"><div class="col-s"><form role="form" class="form-horizontal"><div class="form-group"><label for="text" class="control-label2 col-sm-4">Vehicle:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">V.Type:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Model:</label><input id="text-short" type="text" class="form-control"/></div></form></div><div class="col-s"><form role="form" class="form-horizontal"><div class="form-group"><label for="text" class="control-label2 col-sm-4">Origin:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Color:  </label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="date" class="control-label2 col-sm-4">Cylinder:</label><input id="text-short" type="text" class="form-control"/></div></form></div><div class="col-s2"><form role="form" class="form-horizontal">               <div class="form-group"><label for="text" style="width:60px" class="control-label2 col-sm-4">Weight:</label><input id="text-short" type="text" class="form-control"/></div><div class="form-group"><label for="text" style="width:60px" class="control-label2 col-sm-4">HP:</label><input id="text-short" type="text" class="form-control"/></div></form></div><div class="col-s last2"><form role="form" class="form-horizontal"><div class="form-group"><label for="text" class="control-label2 col-sm-4">Engine No:</label><input id="text-short" type="text" style="width:175px" class="form-control inch"/></div><div class="form-group"><label for="text" class="control-label2 col-sm-4">Chassis No:    </label><input id="text-short" type="text" style="width:175px" class="form-control inch"/></div></form></div></div></div><form role="form" class="form-horizontal comm"><div class="form-group"><label for="text" class="control-label col-sm-2 lab">Comments:</label><div class="col-sm-4"><input id="text-long" type="text" class="form-control"/></div>


                    <div class="col4"><a href="#" class="btn btn-lg btn-default pop"><span style="color:black" class="fa fa-exchange"> Transfer</span></a></div>
                    </div></form>
                  </div><?php */?>
                  <!-- ----------------------------- -->
         <?php if(isset($user_privileges[6]) && ($user_privileges[6]['w'] == 1 || $user_privileges[6]['e'] == 1 )){ ?>
         <div id="vehicle-transfer" class="tab-pane fade in active <?php //if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') echo 'fade'; else echo 'active'; ?>">
            <?php //if(isset($user_privileges[2]) && $user_privileges[2]['r'] == 1)
			{ ?>
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

               <form role="form" class="form-inline mar1">
               	   <div class="form-group">
               	   		<label for="text" class="control-label3 col-sm-4">Issue Place:</label>
                       <!-- <input id="text-short" type="text" value="<?php echo isset($search_result->issue_place) ? $search_result->issue_place : '' ;?>" class="form-control"/>-->
                        <select id="text-short" size="1" name="issue_place" placeholder="Place">
                            <option value="<?php echo $ArIssuePlace[0]?>" <?php if(isset($search_result->issue_place) && $search_result->issue_place == $ArIssuePlace[0]) echo 'selected'; ?>><?php echo $ArIssuePlace[0]?></option>
                         </select>  
                   </div>
                   <div class="form-group">
               	   		<label for="text" class="control-label3 col-sm-4">Receipt No:</label>
                        <input id="text-short" type="text" value="<?php echo isset($search_result->receipt_no) ? $search_result->receipt_no : '' ;?>" class="form-control"/>
                   </div>
               </form>
               <form role="form" class="form-inline mar1">
               	   <div class="form-group">
                   		<label for="date" class="control-label2 col-sm-4">Fees:</label>
                        <input id="text-short" type="text" value="<?php echo isset($search_result->fees) ? $search_result->fees : '' ;?>" class="form-control"/>
                   </div>
                   <div class="form-group">
                   		<label for="date" class="control-label2 col-sm-4">Issue Date:</label>
                        <input id="text-short" type="text" value="<?php echo isset($search_result->issue_date) ? date('d/m/Y', strtotime($search_result->issue_date)) : '';?>" class="form-control"/>
                   </div>
                   <div class="form-group">
                   		<label for="date" class="control-label2 col-sm-4">Expire Date:</label>
                        <input id="text-short" type="text" value="<?php echo isset($search_result->expire_date) ? date('d/m/Y', strtotime($search_result->expire_date)) : '';?>" class="form-control"/>
                   </div>
                   <div class="form-group">
                   		<label for="date" class="control-label2 col-sm-4">Owner:</label>
                        <input id="text-long" type="text" value="<?php echo isset($search_result->Owner) ? $search_result->Owner : '';?>" class="form-control"/>
                   </div>
                </form>
                
				
				
				
                <div class="stack">
                	<div class="row">
                    	<div class="col">
                        	<form role="form" class="form-horizontal">
                            	<div class="form-group">
                                	<label for="date" class="control-label2 col-sm-4">Birth Date:</label>
                                    <input id="birth_date" name="birth_date" type="text" class="form-control datepick text-middle" onkeypress="DateFormat(this,event.keyCode)" value="<?php echo isset($search_result->birth_day) ? $search_result->birth_day : '' ;?>"/>
                                </div>
                                <div class="form-group">
                                	<label for="text" class="control-label2 col-sm-4">Birth Place:</label>
                                    <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->birth_place) ? date('d/m/Y', strtotime($search_result->birth_place )): '' ;?>"/>
                                </div>
                                <div class="form-group">
                                	<label for="text" class="control-label2 col-sm-4">Gender:</label>
                                    <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->gender) ? $search_result->gender : '' ;?>"/>
                                </div>
                            </form>
                        </div>
                        <div class="col2">
                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                    <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->nationality) ? $search_result->nationality : '' ;?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Mother's Name:</label>
                                    <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->mother_name) ? $search_result->mother_name : '' ;?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="control-label2 col-sm-4">Personal ID:</label>
                                    <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->personal_id) ? $search_result->personal_id : '' ;?>"/>
                                </div>
                            </form>
                        </div>
						
                        <div class="col3" >
                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Mobile No:</label>
                                    <input id="text-middle" type="text" class="form-control inch" value="<?php echo isset($search_result->mobile_no) ? $search_result->mobile_no : '' ;?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="date" class="control-label2 col-sm-4">Address:</label>
                                    <input id="text-middle" type="text" class="form-control inch" value="<?php echo isset($search_result->address) ? $search_result->address : '' ;?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Email:</label>
                                    <input id="text-middle" type="text" class="form-control inch" value="<?php echo isset($search_result->email) ? $search_result->email : '' ;?>"/>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <form role="form" class="form-inline mar1">
                    <div class="form-group onemargin" >
                        <label for="date" class="control-label2 col-sm-4">Plate No:</label>
                        <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?>"/>
                    </div>
                    <div class="form-group onemargin2">
                        <label for="text" class="control-label2 col-sm-4" >Plate Type:</label>
                        <input id="text-middle" type="text" class="form-control" value="<?php echo isset($search_result->plate_type) ? $search_result->plate_type : '';?>"/>
                    </div>
                    <div class="form-group" >
                        <label for="text" class="control-label2 col-sm-4">Code:  </label>
                        <input id="text-middle" type="text" class="form-control"  value="<?php echo isset($search_result->code) ? $search_result->code : '';?>"/>
                    </div>
                </form>
				<!--  ////////////////////////////////////// -->
				
                <div class="stack">
                    <div class="row">
                        <div class="col-s">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Vehicle:</label>
                                    <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->vehicle) ?$search_result->vehicle : '';?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">V.Type:</label>
                                     <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->v_type) ? $search_result->v_type : '';?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Model:</label>
                                    <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->model) ? $search_result->model : '';?>"/>
                                </div>
                            </div>
                         </div>
                        <div class="col-s">
                        <div class="form-horizontal">
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4">Origin:</label>
                         <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->origin) ? $search_result->origin : '';?>"/>
                        </div>
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4">Color:  </label>
                        <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->color) ? $search_result->color : '';?>"/>
                        </div>
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Cylinder:</label>
                        <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->cylinder) ? $search_result->cylinder : '';?>"/>
                        </div>                        
                        </div>
                        </div>
                        <div class="col-s2">
                        <div class="form-horizontal">
                        <div class="col-s last2">
                        <div class="form-horizontal">
                        <div class="form-group">
                        <label for="text"  class="control-label2 col-sm-4">Weight:</label>
                        <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->weight) ? $search_result->weight : '' ;?>"/>
                        </div>
                        </div>
                        </div>
                        <div class="col-s last2">
                        <div class="form-horizontal">
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4">HP:</label>
                        <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->hp) ? $search_result->hp : '';?>"/>
                        </div>
                        </div>
                        </div>
                        <div class="col-s last2">
                        <div class="form-horizontal">
                        <div class="form-group">
                        <label for="text"  class="control-label2 col-sm-4">Passengers:</label>
                        <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->passengers) ? $search_result->passengers : '';?>"/>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                        <div class="col-s last2" style="margin-left:60px;">
                        <div class="form-horizontal">
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4">Engine No:</label>
                        <input id="text-short" style="width:175px;" type="text" class="22long form-control inch" value="<?php echo isset($search_result->engine_no) ? $search_result->engine_no : '';?>"/>
                        </div>
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4">Chassis No:    </label>
                        <input id="text-short" style="width:175px;"type="text" class="22long form-control inch" value="<?php echo isset($search_result->chassis_no) ? $search_result->chassis_no : '';?>"/>
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
                
				<!-- ////////////////////////////////////// 
                <div class="stack">
                    <div class="row">
                        <div class="col-s">
                            <form role="form" class="form-horizontal">
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Vehicle:</label>
                                    <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->vehicle) ?$search_result->vehicle : '';?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">V.Type:</label>
                                    <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->v_type) ? $search_result->v_type : '';?>"/>
                                </div>
                                <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Model:</label>
                                    <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->model) ? $search_result->model : '';?>"/>
                                </div>
                            </form>
                                            </div>
                                            <div class="col-s">
                                            <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Origin:</label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->origin) ? $search_result->origin : '';?>"/>
                                            </div>
                                            <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Color:  </label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->color) ? $search_result->color : '';?>"/>
                                            </div>
                                            <div class="form-group">
                                            <label for="date" class="control-label2 col-sm-4">Cylinder:</label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->cylinder) ? $search_result->cylinder : '';?>"/>
                                            </div>
                                            </form>
                                            </div>
                                            <div class="col-s">
                                            <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                            <label for="text" style="width:60px;" class="control-label2 col-sm-4">Weight:</label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->weight) ? $search_result->weight : '' ;?>"/>
                                            </div>
                                            <div class="form-group">
                                            <label for="text" style="width:60px;" class="control-label2 col-sm-4">HP:</label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->hp) ? $search_result->hp : '';?>"/>
                                            </div>
											<div class="form-group">
                                            <label for="text" style="width:60px;" class="control-label2 col-sm-4">Passengers:</label>
                                            <input id="text-short" type="text" class="form-control" value="<?php echo isset($search_result->passengers) ? $search_result->passengers : '';?>"/>
                                            </div>
                                            </form>
                                            </div>
                                            <div class="col-s last2">
                                            <form role="form" class="form-horizontal">
                                            <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Engine No:</label>
                                            <input id="text-short" style="width:175px;" type="text" class="22long form-control inch" value="<?php echo isset($search_result->engine_no) ? $search_result->engine_no : '';?>"/>
                                            </div>
                                            <div class="form-group">
                                            <label for="text" class="control-label2 col-sm-4">Chassis No:    </label>
                                            <input id="text-short" style="width:175px;"type="text" class="22long form-control inch" value="<?php echo isset($search_result->chassis_no) ? $search_result->chassis_no : '';?>"/>
                                            </div>
                                            </form>
                                            </div>
                                            </div>
                                            </div>
                                            
					-->						
											<form role="form" class="form-horizontal comm">
                                            <div class="form-group">
                                            <label for="text" class="control-label col-sm-2 lab">Comments:</label>
                                            <div class="col-sm-4">
                                            <input id="text-long" type="text" class="form-control" value="<?php echo isset($search_result->comments) ? $search_result->comments : '';?>"/>
                                            </div>
                                            <div class="col4"><a href="#" class="btn btn-lg btn-default pop"><span style="color:black" class="fa fa-exchange"> Transfer</span></a></div>
                                            </div>
                                            </form>


                                      <?php } ?>

                                <!-- -------------------------  -------------------------
                                      -------- -       Transfer History ---------------
                                     ----------------------------------------------------
                                -->
                                <?php if(isset($_REQUEST['search_vehicle_no']) && $_REQUEST['search_vehicle_no'] != ''){ ?>
								<h3> Transfer History</h3>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr class="success">
                                                <th>Date</th>
                                                <th>Plate No</th>
                                                <th>Chassis No</th>
                                                <th>Color</th>
                                                <th>V. Type</th>
                                                <th>Owner's Name</th>
                                                <th>Contact</th>
                                                <th>Address</th>
                                            </tr>
                                       </thead>
                                       <tbody id="vechicle_t_records_area">
                                        <?php
                                         $page = 1;
                                         $per_page = 10; // Set how many records do you want to display per page.
                                         $startpoint = ($page * $per_page) - $per_page;
                                         $statement = "`tbl_vehicle_transfer` where plate_no = '".(isset($_REQUEST['search_vehicle_no']) ? $_REQUEST['search_vehicle_no'] : '')."' ORDER BY `id` DESC"; // Change `records` according to your table name.
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
                                                <td><?php echo date('d/m/Y', strtotime($rec->issue_date));?></td>
                                                <td><?php echo $rec->plate_no;?></td>
                                                <td><?php echo $rec->chassis_no;?></td>
                                                <td><?php echo isset($search_result->color) ? $search_result->color : '';?></td>
                                                <td><?php echo isset($search_result->v_type) ? $search_result->v_type : '';?></td> 
                                                <td><?php echo $rec->Owner;?></td>  
                                                <td><?php echo $rec->mobile_no;?></td>
                                                <td><?php echo $rec->address;?></td>
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
								<div id="pagination_area_vehicle_t">
								<?php
								 // displaying paginaiton.
								 $pagination_data = array('current_statement' => $statement,
														  'per_page' => $per_page,
														  'current_page' => $page,
														  'db_con' => $con,
														  'v_color' => (isset($search_result->color) ? $search_result->color : ''),
														  'v_v_type' => (isset($search_result->v_type) ? $search_result->v_type : '')  
														  );
								 $_SESSION['pagination_t_data'] = $pagination_data;
								echo ajax_pagination($statement,$per_page,$page,$url='vehicles_transfer_history_pagination', $con);
								?>
								</div>    
                                <?php } ?>
                                <div class="overlay">
                                   <form method="post" action="model/vehicles_transfer_model.php" >
                                    <div class="popup">
                                        <div class="closeBtn">
                                            <div class="fa fa-close"></div>
                                        </div>
                                        <div class="form-inline">
                                            <p>New Owners Details</p>
                                            <div class="alert alert-danger" id="show_error_msg" style="display:none;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                    						<div class="alert alert-success" id="show_success_msg" style="display:none;color:#144C15;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group short-label">
                                                <label for="text" class="control-label3 col-sm-4">Plate No:</label>
                                                <input id="text-short" type="text" name="plate_no" readonly class="form-control v_t_palte_no" value="<?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?>"/>
                                            </div>
                                            <div class="form-group short-label">
                                                <label for="date" class="control-label2 col-sm-4">Chassis No:</label>
                                                <input id="text-middle" type="text" name="chassis_no" readonly class="form-control v_t_chassis_no" value="<?php echo isset($search_result->chassis_no) ? $search_result->chassis_no : '';?>"/>
                                            </div>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group short-label">
                                                <label for="text" class="control-label3 col-sm-4">Receipt No:</label>
                                                <input id="text-short" type="text" name="receipt_no" required onkeyup="get_receipt_data(this.value);" class="form-control"/>
                                            </div>
                                            <div class="form-group short-label">
                                                <label for="date" class="control-label2 col-sm-4">Amount:</label>
                                                <input id="text-short" type="text" name="amount" required readonly="readonly" class="form-control licence_receipt_fee"/>
                                            </div>
                                            <div class="form-group short-label">
                                                <label for="date" class="control-label2 col-sm-4">Date:</label>
                                                <input id="text-short" type="text" name="date" required readonly class="form-control licence_receipt_issueDate"/>
                                            </div>
                                        </div>
                                        <div class="stack">
                                            <div class="row">
                                                <div style="margin-right:135px" class="col">
                                                    <div class="form-horizontal">
                                                        <div class="form-group">
                                                            <label for="date" class="control-label2 col-sm-4">Owner's Name:</label>
                                                            <br/>
                                                            <input id="text-long" type="text" name="owner" required class="form-control licence_receipt_holder_name"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Gender:</label>
                                                            <br/>
                                                            <select id="text-short" name="gender"  size="1">
                                                                <option value="Lab">Lab</option>
                                                				<option value="Dhedig">Dhedig</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Issue Place:</label><br/>
                                                           <!-- <input id="text-short" type="text" name="issue_place" required class="form-control" value="Mogadishu"/>-->
                                                            <select id="text-short" size="1" name="issue_place" placeholder="Place">
                            <option value="<?php echo $ArIssuePlace[0]?>"><?php echo $ArIssuePlace[0]?></option>
                         </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Mother's Name:</label><br/>
                                                            <input id="text-long" type="text" name="mother_name" required  class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Date of Birth:</label>
                                                            <br/>
                                                            <input id="birth_date" type="text" name="birth_date" required class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Place of Birth:</label><br/>
                                                            <input id="text-short" type="text" name="birth_place" required class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                                        <br/>
                                                            <?php $Countries = mysqli_query($con, 'select * from tbl_country'); ?>
                                                            <select id="text-middle" size="1" name="nationality" required>
                                                               <option value="">Select Country</option>
                                                               <?php while($row = @mysqli_fetch_object($Countries)) { ?>
                                                                    <option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                                               <?php } ?>
                                                             </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Personal ID:</label><br/>
                                                            <input id="text-short" type="text" name="personal_id" class="form-control"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-horizontal">
                                                        <div class="form-group">
                                                            <label for="date" class="control-label2 col-sm-4">Contacts:</label><br/>
                                                            <input id="text-long" type="text" name="contact_no" required class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Address:</label><br/>
                                                            <input id="text-long" type="text" name="address" required class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="text" class="control-label2 col-sm-4">Email:</label><br/>
                                                            <input id="text-long" type="text" name="email" class="form-control"/>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col4">
                                                            	<a href="javascript:void(0);" onClick="submit_vehicl_trans_form()" class="btn btn-lg btn-default pop"><span style="color:black" class="glyphicon glyphicon-plus"> Save</span></a>
                                                             	<input type="submit" value="sub" id="veh_tran_sub_btn" style="display:none;"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                   </form>
                                </div>
                                <script>
								function submit_vehicl_trans_form()
								{

									if($('.v_t_chassis_no').val() != '' &&  $('.v_t_palte_no').val() != '')
									{
										if($('.licence_receipt_fee').val() != '' &&  $('.licence_receipt_issueDate').val() != '')
										{
											$('#veh_tran_sub_btn').trigger('click');
										}
										else
											$('#show_error_msg').show().text('ERROR !  Some thing wrong, Please check receipt number again.');
									}
									else
									   $('#show_error_msg').show().text('ERROR !  Some thing wrong, Please search vehicle again...');
								}
								</script>

                    </div>
         <?php } ?>
         
          <!-- Search vehicle transfer -->
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
                    </form>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="success">
                                    <th>Plate No</th>
                                    <th>Owner's Name</th>
                                    <th>Nationality</th>
                                    <th>Place of Issue</th>
                                    <th>Expire Date</th>
                                    <th>Model</th>
                                    <th>Color</th>
                                    <th>Chassis No</th>
                                    <th>Engine No</th>
                                </tr>
                           </thead>
                           <tbody id="vechicle_records_area">
                            <?php
                             $page = 1;
                             $per_page = 10; // Set how many records do you want to display per page.
                             $startpoint = ($page * $per_page) - $per_page;
                             $statement = "`tbl_vehicle_transfer` ORDER BY `id` DESC"; // Change `records` according to your table name.
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
                                    <td><?php echo $rec->nationality;?></td>
                                    <td><?php echo $rec->issue_place;?></td>
                                    <td><?php echo date('d/m/Y', strtotime($rec->expire_date));?></td>
                                    <td><?php echo $rec->model;?></td>
                                    <td><?php echo $rec->color;?></td>
                                    <td><?php echo $rec->chassis_no;?></td>
                                    <td><?php echo $rec->engine_no;?></td>
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
          <!-- END Search vehicle transfer -->
          
         <?php if(isset($user_privileges[6]) && ($user_privileges[6]['w'] == 1 || $user_privileges[6]['e'] == 1 || $user_privileges[6]['r'] == 1)){ ?>
                <div id="card-list3" class="tab-pane fade">
                	<div class="search-border2">Search by date</div>
                    	<form role="form" class="form-inline">
                        	<div class="form-group">
                            	<label for="text">From Date:</label><input id="record_from_date" placeholder="dd-mm-yyyy" type="text" onkeyup="get_v_card_record_from_date(this.value)" class="form-control" onkeypress="DateFormat(this,event.keyCode)"/>
                            </div>
                            <div class="form-group">
                            	<label for="number">To Date:</label><input id="record_to_date" placeholder="dd-mm-yyyy" type="text" onkeyup="get_v_card_record_to_date(this.value)" class="form-control" onkeypress="DateFormat(this,event.keyCode)"/>
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
                                        <th>Year</th>
                                        <th>Origin</th>
                                        <th>Chassis No</th>
                                        <th> </th>
                                    </tr>
                                </thead>
                                <tbody id="vechicle_records_area">
                                	<?php /*?><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><a href="" class="fa fa-save"></a></td></tr><?php */?>
                                <?php
								 $page = 1;
								 $per_page = 10; // Set how many records do you want to display per page.
								 $startpoint = ($page * $per_page) - $per_page;
								 $statement = "`tbl_vehicles` where status = 1 and updated_time > DATE_SUB(NOW(), INTERVAL 7 day)  group by plate_no ORDER BY  updated_time "; // Change `records` according to your table name.
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
										<td><?php echo $rec->nationality;?></td>
										<td><?php echo date('d/m/Y', strtotime($rec->issue_date));?></td>
										<td><?php echo $rec->issue_place;?></td>
										<td><?php echo date('d/m/Y', strtotime($rec->expire_date));?></td>
										<td><?php echo $rec->model;?></td>
										<td><?php echo $rec->color;?></td>
										<td></td>
										<td><?php echo $rec->origin;?></td>
										<td><?php echo $rec->chassis_no;?></td>
										<td><a href="?section=vehicle_search&search_vehicle_no=<?php echo $rec->plate_no; ?>" class="fa fa-print"></a></td>
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

                </div>
          <?php } ?>
                  <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->
          
                <div  id="tab" style="display:none;">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <div style="font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y  h:i:sa'); ?></div>
                </div>
                <h3> <center>Vehicle details </center></h3>
                <div style="padding-left:20px;">
                    <h5>Vehicle owner details:</h5>
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th style="padding:5px;">Date: </th>
                           <td style="padding:5px;"></td>
                        </tr>

                        <tr >
                           <th style="padding:5px;">Registration:</th>
                           <td style="padding:5px;"> </td>
                        </tr>
                        <tr >
                           <th style="padding:5px;">Owner name:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->Owner) ? $search_result->Owner : '';?></td>
                        </tr>
                        <tr>
                           <th style="padding:5px;">Gender:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->gender) ? $search_result->gender : '';?></td>
                        </tr>
                        <tr>
                           <th style="padding:5px;">Nationality:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->nationality) ? $search_result->nationality : '';?></td>
                        </tr>
                        <tr>
                           <th style="padding:5px;">Address:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->address) ? $search_result->address : '';?></td>
                        </tr>
                        <tr>
                           <th  style="padding:5px;">Email:</th>
                           <td style="padding:5px;" ><?php echo isset($search_result->email) ? $search_result->email : '';?></td>
                        </tr>
                        <tr>
                           <th style="padding:5px;">Comments:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->comments) ? $search_result->comments : '';?></td>
                        </tr>

                     </table>
                </div>
                <div style="padding-left:20px;">
                    <h5>Car plate details:</h5>
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th style="padding:5px;">Type: </th>
                           <td style="padding:5px;"><?php echo isset($search_result->plate_type) ? $search_result->plate_type : '';?></td>
                           <th style="padding:5px;">Number: </th>
                           <td style="padding:5px;"><?php echo isset($search_result->plate_no) ? $search_result->plate_no : '';?></td>
                        </tr>

                        <tr >
                           <th style="padding:5px;">Issued in:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->issue_date) ? date('d/m/Y', strtotime($search_result->issue_date)) : '';?> </td>
                           <th style="padding:5px;">Code:</th>
                           <td style="padding:5px;"> <?php echo isset($search_result->code) ? $search_result->code : '';?></td>
                        </tr>
                     </table>

                     <h5>Vehicle details:</h5>
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th style="padding:5px;">Type: </th>
                           <td style="padding:5px;"><?php echo isset($search_result->v_type) ? $search_result->v_type : '';?></td>
                           <th style="padding:5px;">Model: </th>
                           <td style="padding:5px;"><?php echo isset($search_result->model) ? $search_result->model : '';?></td>
                        </tr>

                        <tr >
                           <th style="padding:5px;">Country of origin:</th>
                           <td style="padding:5px;"> <?php echo isset($search_result->origin) ? $search_result->origin : '';?></td>
                           <th style="padding:5px;">Weight:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->weight) ? $search_result->weight : '';?></td>
                        </tr>
                        <tr >
                           <th style="padding:5px;">Engine No:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->engine_no) ? $search_result->engine_no : '';?> </td>
                           <th style="padding:5px;">Color:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->color) ? $search_result->color : '';?> </td>
                        </tr>
                        <tr >
                           <th style="padding:5px;">Chassis No:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->chassis_no) ? $search_result->chassis_no : '';?></td>
                           <th style="padding:5px;">Passengers:</th>
                           <td style="padding:5px;"></td>
                        </tr>
                     </table>
                </div>
                <div style="padding-left:20px;">
                     <h5>Vehicle renewals history</h5>

                     <table style="width:98%;border-top:1px solid #666;">
                        <thead >
                            <tr >
                                <th style="text-align:left;">Plate No</th>
                                <th style="text-align:center;">Renewal type </th>
                                <th style="text-align:center;">Last renewal</th>
                                <th style="text-align:center;">Expire date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="border-top:1px solid #666;" colspan="4"></td>
                            </tr>
                            <?php
							 if(isset($_POST['search_vehicle_no']) && $_POST['search_vehicle_no'] != '')
							 {
								$data = mysqli_query($con,"SELECT * FROM tbl_receipts where vehicle_no = '".mysqli_real_escape_string($con, $_POST['search_vehicle_no'])."' ");
								while($row = mysqli_fetch_object($data))
							 	{
							 ?>
                                    <tr >
                                        <td align="left"><?php echo isset($row->vehicle_no) ? $row->vehicle_no : '';?></td>
                                        <td align="center"><?php echo isset($row->for_opt) ? $row->for_opt : '';?></td>
                                        <td align="center"><?php echo isset($row->date) ? date('d/m/Y', strtotime($row->date)) : '';?></td>
                                        <td align="center"><?php echo isset($row->expire_date) ? date('d/m/Y', strtotime($row->expire_date)) : '';?></td>
                                    </tr>
                            <?php
								}
							}else{
							?>
                              <tr>
                                <td style="color:red;" colspan="4" align="center">No record found</td>
                              </tr>
                            <?php
							}
							?>
                        <tbody>
                     </table>
                </div>

            </div>
            </div>
         </div>

<?php /* ###############
         Footer
	  */
	  include_once('inc/footer.php');
?>
<script>   
$(function() {
	$( "#birth_date" ).datepicker({
		yearRange: '0:+20',
		minDate: 'today',
		//maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true 
	});
	$( "#record_from_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_from_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#record_to_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_v_card_record_to_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true 
	});
	
});
 </script>