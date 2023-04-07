<?php /* ###############
         Header
	  */
	  
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];
	   // Edit...
	   if(isset($_POST['licence_no']))
	   {
		   $rec_id = $_POST['licence_no'];
		   $check = mysqli_query($con, 'select * from tbl_driver_detail where licence_no = "'.mysqli_real_escape_string($con, $_POST['licence_no']).'" ');
		   $check_data = @mysqli_fetch_object($check);
		   if(empty($check_data))
			   $_SESSION['error'] = 'ERROR ! Record not available.';
		   $_SESSION['licence_section'] = 'edit_licence';
	   }
	   // print -- Card list
	   if(isset($_GET['print_licence_no']))
	   {
		   $rec_id = $_GET['print_licence_no'];
		   $check = mysqli_query($con, 'select * from tbl_driver_detail where licence_no = "'.mysqli_real_escape_string($con, $_GET['print_licence_no']).'" ');
		   $search_result = @mysqli_fetch_object($check);

		 /* if(isset($search_result->image) && $search_result->image != '' && file_exists("uploads/users_licence/".$search_result->image)){
					copy('uploads/users_licence/'.$search_result->image, 'D:\g\\'.$search_result->image);
			}else {
                     copy('assets/img/user-big.png', 'D:\g\user-big.png');
              } */
		   $_SESSION['licence_data'] = $search_result;
		   if(empty($search_result))
			   $_SESSION['error'] = 'ERROR ! Record not available.';
		   $_SESSION['licence_section'] = 'card_list';
		   if($_SESSION['is_licence_ready'] == '')
		       $_SESSION['is_licence_ready'] = 0;
			// get setting values..
			$setting = mysqli_query($con, "SELECT * FROM tbl_settings where id = 1");
			$setting_data = @mysqli_fetch_object($setting);
	   }
	   // print -- search list
	   if(isset($_GET['licence_search_id']))
	   {
		   $rec_id = $_GET['licence_search_id'];
		   $check = mysqli_query($con, 'select * from tbl_driver_detail where licence_no = "'.mysqli_real_escape_string($con, $_GET['licence_search_id']).'" ');
		   $search_result = @mysqli_fetch_object($check);
		   if(empty($search_result))
			   $_SESSION['error'] = 'ERROR ! Record not available.';
		   $_SESSION['licence_section'] = 'search_list';
	   }
	   if(isset($_GET['cardId']))
	       $_SESSION['licence_section'] = 'card_list';

	   // Get last licence no 	//max(receipt_no) + 1
	   $licence = mysqli_query($con, "select max(licence_no)+1 as mrecid from tbl_driver_detail order by id DESC");
	   $licence_data = @mysqli_fetch_object($licence);
	 //  echo '<pre>'; print_r($licence_data); exit;
	   unset($_SESSION['search_licence_card_statement']);
	   if(isset($_GET['is_licence']))
	        unset($_SESSION['licence_section']);
	   if(isset($_GET['edit_licence']))
	        $_SESSION['licence_section'] = 'edit_licence';

?>
    <style>
	#gallery img{ width:120px; height:160px;}
	#pictures_2 img{ width:120px; height:160px;}
	.form-inline .form-control {
    	width: 130px;
	}
	</style>
    <div class="right-nav">
      	<ul class="nav nav-tabs">
            <li <?php if(!isset($_SESSION['licence_section']) ){ ?>class="active"<?php } ?>>
            	<a  href="?is_licence=1" >New Licence</a>
            </li>
            <li <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'edit_licence'){ ?>class="active"<?php } ?>>
            	<a  href="?edit_licence=1" id="ascsss">Edit-Renew</a>
            </li>
            <li <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'search_list'){ ?>class="active"<?php } ?>><a data-toggle="tab" href="#search-licence">Search Licence</a></li>
            <li <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'card_list'){ ?>class="active"<?php } ?> ><a data-toggle="tab" href="#card-list">Card List</a></li>
            <li style="float: right;">
             <?php if(isset($_SESSION['success'])){ ?>
                <div class="alert alert-success" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;float:right;"><?php echo $_SESSION['success']; ?></div>
              <?php unset($_SESSION['success']); } ?>
              <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert alert-danger" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"><?php echo $_SESSION['error']; ?></div>
              <?php unset($_SESSION['error']);  } ?>
              <div class="alert alert-danger" id="show_error_msg" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
              <div class="" id="show_print_btn" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
           </li>
        </ul>
        <div class="tab-content">
            <?php if(isset($user_privileges[5]) && ($user_privileges[5]['w'] == 1 )){ ?>
        	<div id="licence" class="tab-pane fade  <?php if(!isset($_SESSION['licence_section']) && $_SESSION['licence_section'] != 'card_list' && $_SESSION['licence_section'] != 'edit_licence') echo 'in active'; else echo 'fade'; ?>">
                <form method="post" action="model/licence_model.php" enctype="multipart/form-data">                
                    <div class="form-inline" style="margin-bottom:20px;">
                        <div class="form-group" >
                            <label for="text">Receipt No:</label><input id="text" onkeyup="get_receipt_data(this.value);" name="receipt_no" required="required" type="text" class="form-control"/>
                        </div>
                        <div class="form-group"><label for="date">Fees:</label><input id="text" name="fees" readonly="readonly" required="required" type="text" class="form-control licence_receipt_fee"/></div>
                        <div class="form-group"><label for="date">Holder's Name:</label><input id="text-long" readonly name="name" required="required" type="text" class="form-control licence_receipt_holder_name"/></div>
                    </div>
                    <div class="form-inline" style="margin: 0 0 20px;">
                        <div class="form-group"><label for="text">Licence No:</label>
                        <input id="text-short" name="licence_no" required="required" type="text" class="form-control licence_no" value="<?php echo isset($licence_data->licence_no) ? $licence_data->licence_no : $licence_data->mrecid; ?>"/></div>
                        <div class="form-group"><label for="date">Place of Issue:</label>
                        <select id="text-short" size="1" name="issue_place" required="required" >
                        <?php foreach($ArIssuePlace as $key => $value){
								if($_SESSION['issue_place'] == $value)
									$sel	= "selected = 'selected' ";
								else
									$sel	=	"";	
                            	echo "<option value='$value' $sel>$value</option>";
                            } ?>
                         </select>                       
                        <!--<input id="text-short" name="issue_place" type="text" class="form-control issue_place" value="Mogadishu"/>-->
                        </div>
                        <div class="form-group"><label for="date">Date of Issue:</label><input id="issue_date1" name="issue_date" onkeyup="Change_expire_date(this.value)" required="required" type="text" class="form-control text-short licence_receipt_issueDate" placeholder="dd-mm-yy" onkeypress="DateFormat(this,event.keyCode)"/></div>
                        <div class="form-group"><label for="date">Expire Date:</label>
                        <input id="expiry_date" name="expiry_date" required="required" type="text" class="form-control expire_date text-short" placeholder="dd-mm-yy"/></div>
                    </div>
                    <script>
					function Change_expire_date(val)
					{
						//alert($('.expiry_date').val());
						var dateAr = val.split('-');
						var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
						var someDate = new Date(newDate);
						//alert(someDate);
						var numberOfDaysToAdd =  <?=THREEYEAR?>; //3 year and for 2 years 730; //
						someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
						if(!isNaN(someDate.getTime())){

							//alert(someDate);
							//alert(someDate.getDate());
							var day = someDate.getDate();
							if (day < 10) 
								day = "0" + day;
							var month = someDate.getMonth() + 1;
							//alert(day);
							if (month < 10) {
								month = "0" + month;
							}
							var year = someDate.getFullYear();
							newDate = day + '-' + month + '-' + year;
							$(".expire_date").val(newDate);
						}
						else
							$(".expire_date").val('dd/mm/yy');
					}

					</script>
                    <div class="stack">
                        <div class="row">
                            <div class="col" id="gallery" style="text-align:center">
                            	<img src="assets/img/user-big.png"/>

                            </div>

                            <div class="col2">
                                <div class="form-horizontal" style="margin: 0 0 20px;">
                                    <div class="form-group">
                                    	<label for="text" class="control-label2 col-sm-4">Gender:</label>
                                        <div class="col-sm-4">
                                        	<select id="text-middle" size="1" name="gender">
                                            	<option value="1">Lab</option>
                                                <option value="2">Dhedig</option>
                                             </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <label for="text" class="control-label2 col-sm-4">Mother's Name:</label>
                                    <div class="col-sm-4"><input id="text-middle" type="text" name="mother_name" class="form-control"/></div>
                                    </div>
                                    <div class="form-group">
                                    	<label for="text" class="control-label2 col-sm-4">Date of Birth:</label>
                                    	<div class="col-sm-5">
                                        <input id="birth_date" type="text" name="birth_date" required="required" class="form-control text-short"  onkeypress="DateFormat(this,event.keyCode)"  /></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Place of Birth:</label>
                                        <div class="col-sm-4"><input id="text-middle" type="text" name="birth_place" class="form-control" required="required" /></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                        <div class="col-sm-4">
                                        <?php $Countries = mysqli_query($con, 'select * from tbl_country'); ?>
				   							<select id="text-middle" size="1" name="nationality" required="required" >
                                               <option value="">Select Country</option>
                                               <?php while($row = @mysqli_fetch_object($Countries)) { ?>
                                                	<option value="<?php echo $row->name; ?>"><?php echo $row->name; ?></option>
                                               <?php } ?>
                                             </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col3">
                                <div class="form-horizontal" style="margin: 0 0 20px;">
                                     <div class="form-group" style="margin-bottom:10px;">
                                        <label for="text" class="control-label2 col-sm-4">Residence Address:</label>
                                        <div class="col-sm-4"><input id="text-long" type="text" name="address" required class="form-control"/></div>
                                     </div>
                                     <div class="form-group" style="margin-bottom:10px;"><label for="text" class="control-label2 col-sm-4">Email Address:</label><div class="col-sm-4"><input id="text-long" type="text" name="email" class="form-control"/></div></div>
                                     <div class="form-group" style="margin-bottom:10px;"><label for="text" class="control-label2 col-sm-4">Contacts:</label><div class="col-sm-4"><input id="text-long" type="text" name="contact_no" required="required" class="form-control"/></div></div>
                                     <div class="form-group" style="margin-bottom:10px;"><label for="text" class="control-label2 col-sm-4">Personal ID:</label><div class="col-sm-4"><input id="text-long" type="text" name="personal_id" class="form-control"/></div></div>
                                     <div class="form-group" style="margin-bottom:10px;"><label for="text" class="control-label2 col-sm-4">Upload Picture:</label>
                                         <div class="col-sm-4">
                                         	<label for="fileinput" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Upload</span></label>
                                            <!--name="csv_file_for_receipts"-->
                 		   					<input id="fileinput" name="image" type="file" accept="image/*"   required class="form-control inputfile" style="padding: 0px;" />
                                         </div>

                                     </div>


                                </div>
                            </div>
                         </div>
                    </div>
                    <div class="form-inline" style="margin-bottom:20px;">
                        <div class="table-responsive">Authorized vehicles:
                            <table class="table table-bordered">
                                <thead>
                                    <tr><th><input id="check1" name="vehicle_types[]" value="A" type="checkbox" /><label for="check1" class="for-check"><img src="assets/img/class-a.png"/></label></th>
                                    <th><input id="check2" name="vehicle_types[]" value="A1" type="checkbox"/><label for="check2" class="for-check"><img src="assets/img/class-a1.png"/></label></th>
                                    <th><input id="check3" name="vehicle_types[]" value="B" type="checkbox"/><label for="check3" class="for-check"><img src="assets/img/class-b.png"/></label></th>
                                    <th><input id="check4" name="vehicle_types[]" value="C" type="checkbox"/><label for="check4" class="for-check"><img src="assets/img/class-c.png"/></label></th>
                                    <th><input id="check5" name="vehicle_types[]" value="C1" type="checkbox"/><label for="check5" class="for-check"><img src="assets/img/class-c1.png"/></label></th>
                                    <th><input id="check6" name="vehicle_types[]" value="D" type="checkbox"/><label for="check6" class="for-check"><img src="assets/img/class-d.png"/></label></th>
                                    <th><input id="check7" name="vehicle_types[]" value="E" type="checkbox"/><label for="check7" class="for-check"><img src="assets/img/class-e.png"/></label></th>
                                    <th><input id="check8" name="vehicle_types[]" value="F" type="checkbox"/><label for="check8" class="for-check"><img src="assets/img/class-f.png"/></label></th>
                                    <th><input id="check9" name="vehicle_types[]" value="G" type="checkbox"/><label for="check9" class="for-check"><img src="assets/img/class-g.png"/></label></th>
                                    </tr>
                                </thead>
                                <tbody><tr><td>A</td><td>A1</td><td>B</td><td>C</td><td>C1</td><td>D</td><td>E</td><td>F</td><td>G</td></tr></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="text" class="control-label2 col-sm-2">Comments:</label>
                            <div class="col-sm-4">
                                <input id="text-long" name="comments" type="text" class="form-control"/>
                                <input type="submit" value="submit" style="display:none;" id="licence_submit_btn" />
                            </div>
                            <div class="col4">
                                <a href="javascript:void(0);" class="btn btn-lg btn-default" onclick="submit_form_btn()"><span class="glyphicon glyphicon-saved"> Save</span></a>
                            </div>
                        </div>
                    </div>
                    <script>
					function submit_form_btn()
					{
						if($("input:checked").length == 0)
						{
							 $('#show_error_msg').show().text('ERROR !  Please select the vehicle type.');
							 return false;
						}
						if($('.nationality').val() == '')
						{
							$('#show_error_msg').show().text('ERROR !  Please select the nationality.');
							$('.nationality').focus();
							return false;
						}
						if($('.birth_date').val() == '')
						{
							$('#show_error_msg').show().text('ERROR !  Please enter the date of birth.');
							$('.birth_date').focus();
							return false;
						}
						var birth_date	=	$("#birth_date").val();
						if(birth_date != '')
						{
							fnValidateDOB(birth_date);
						}
						if($('.licence_receipt_fee').val() != '' &&  $('.licence_receipt_holder_name').val() != '')
						{
							$.ajax({
								url: 'model/licence_model.php',
								type:'POST',
								data: 'action=licence_validation_check&licence_no='+$('.licence_no').val(),
								beforeSend: function(){

								},
								success: function(result){
									if(result == 'yes')
									{
										$('#show_error_msg').show().text('ERROR !  Licence number already exists.');
										$('.licence_no').focus();

									}
									else
									{
										$('#licence_submit_btn').trigger('click');

									}
								}
							});
						}
						else
						    $('#show_error_msg').show().text('ERROR !  Some thing wrong, Please check receipt number again.');
					}
					</script>
                </form>
            </div>
            <?php } ?>
            <?php if(isset($user_privileges[5]) && ($user_privileges[5]['e'] == 1 )){ ?>
            <div id="edit-renew" class="tab-pane <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'edit_licence') echo 'in active'; else echo 'fade'; ?>">
            <form role="form" class="form-inline" id="search_licence_no" method="post" >
            <div class="form-group">
            <label for="text">Licence No:</label>
            <input id="text" type="text" name="licence_no" required="required" value="<?php echo isset($_POST['licence_no']) ? $_POST['licence_no'] : '';?>" class="form-control"/>
            <input type="submit" value="sub" id="search_licn_sub_btn" style="display:none;"/>
            <div class="fa-stack fa-lg" >
               <a href="javascript:void(0);"  onclick="submit_search_form()">
            	<i class="fa fa-square-o fa-stack-2x"></i><i class="fa fa-search fa-stack-1x"></i>
               </a>
            </div></div>
            <script>
			function submit_search_form()
			{
			    $('#search_licn_sub_btn').trigger('click');
			}
			</script>
            </form>
            <form method="post" action="model/licence_model.php" enctype="multipart/form-data">
                <div class="form-inline" style="margin-bottom:20px;">
                    <div class="form-group">
                        <label for="text">Place of Issue:</label>
                        <select id="text-short" size="1" name="issue_place">
                        <?php foreach($ArIssuePlace as $key => $value){
								if($check_data->issue_place == $value)
									$sel	= "selected = 'selected' ";
								else
									$sel	=	"";	
                            	echo "<option value='$value' $sel>$value</option>";
                            } ?>
                         </select>  
                         
                        <!--<input id="text-short" type="text"  class="form-control" name="issue_place" value="<?php echo isset($check_data->issue_place) ? $check_data->issue_place : ''; ?>"/>-->
                        <input id="text" type="hidden" name="licence_no" required="required" value="<?php echo isset($_POST['licence_no']) ? $_POST['licence_no'] : '';?>" class="form-control"/>
                    </div>
                    <div class="form-group">
                        <label for="date">Date of Issue:</label>
                        <input id="issue_date" type="text" class="form-control text-short" name="issue_date" value="<?php echo isset($check_data->issue_date) ? date('d-m-Y', strtotime($check_data->issue_date)) : ''; ?>" onkeyup="Change_expire_date(this.value)" onkeypress="DateFormat(this,event.keyCode)" required="required" />
                    </div>
                    <div class="form-group">
                        <label for="date">Expire Date:</label>
                        <input id="licence_renew_expire_date1" type="text" class="form-control text-short" name="expiry_date" value="<?php echo isset($check_data->expiry_date) ? date('d-m-Y', strtotime($check_data->expiry_date)) : ''; ?>" onkeypress="DateFormat(this,event.keyCode)" required="required" />
                    </div>
                </div>
                <div class="stack">
                    <div class="row">
                        <div class="col" id="pictures_2" style="text-align:center;">
                           <?php if(isset($check_data->image) && $check_data->image != '' && file_exists("uploads/users_licence/".$check_data->image)){ ?>
						  		 <img src="<?php echo "uploads/users_licence/".$check_data->image; ?>" style="width:118px;height:159px;"/>

                           <?php }else { ?>
                                 <img src="assets/img/user-big.png"/>
                           <?php } ?>
                           <input id="text-middle"  type="hidden" name="licence_user_prev_image" value="<?php echo isset($check_data->image) ? $check_data->image : ''; ?>" >
                         </div>
                        <div class="col5">
                            <div class="form-horizontal" style="margin-bottom:20px;">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Holder's Name:</label>
                                    <div class="col-sm-4"><input id="text-middle" type="text" name="name" class="form-control" value="<?php echo isset($check_data->name) ? $check_data->name : ''; ?>" required="required" /></div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Gender:</label>
                                    <div class="col-sm-4">
                                        <select id="text-middle" size="1" name="gender">
                                            <option value="1" <?php if(isset($check_data->gender) && $check_data->gender == 1) echo 'selected'; ?>>Lab</option>
                                            <option value="2" <?php if(isset($check_data->gender) && $check_data->gender == 2) echo 'selected'; ?>>Dhedig</option>
                                        </select>
                                     </div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Mother's Name:</label>
                                    <div class="col-sm-4">
                                    <input id="text-middle" type="text" class="form-control" name="mother_name" value="<?php echo isset($check_data->mother_name) ? $check_data->mother_name : ''; ?>"/>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Date of Birth:</label>
                                    <div class="col-sm-5"><input id="birth_date1" type="text" name="birth_date" class="form-control text-short" value="<?php echo isset($check_data->date_birth) ? date('d-m-Y', strtotime($check_data->date_birth)) : ''; ?>" onkeypress="DateFormat(this,event.keyCode)"/></div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Place of Birth:</label>
                                    <div class="col-sm-4">
                                    <input id="text-middle" type="text" class="form-control" name="birth_place" value="<?php echo isset($check_data->birth_place) ? $check_data->birth_place : ''; ?>"/></div>
                                    </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Nationality:</label>
                                    <div class="col-sm-4">
                                    <?php $Countries = mysqli_query($con, 'select * from tbl_country'); ?>
                                        <select id="text-middle" size="1" name="nationality" required="required" >
                                           <option value="">Select Country</option>
                                           <?php while($row = @mysqli_fetch_object($Countries)) { ?>
                                                <option value="<?php echo $row->name; ?>" <?php if(isset($check_data->nationality) && $check_data->nationality == $row->name) echo 'selected'; ?>><?php echo $row->name; ?></option>
                                           <?php } ?>
                                         </select>
                                     </div>
                                </div>
                            </div>
                        </div>
                        <div class="col3">
                            <div class="form-horizontal" style="margin-bottom:20px;">
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Residence Address:</label>
                                    <div class="col-sm-4"><input id="text-long" type="text" name="address" required="required" class="form-control" value="<?php echo isset($check_data->address) ? $check_data->address : ''; ?>"/></div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Email Address:</label>
                                    <div class="col-sm-4"><input id="text-long" type="text" name="email" class="form-control" value="<?php echo isset($check_data->email) ? $check_data->email : ''; ?>"/></div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Contacts:</label>
                                    <div class="col-sm-4">
                                    <input id="text-long" type="text" class="form-control" name="contact_no" value="<?php echo isset($check_data->contact_no) ? $check_data->contact_no : ''; ?>" />
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;">
                                    <label for="text" class="control-label2 col-sm-4">Personal ID:</label>
                                    <div class="col-sm-4"><input id="text-long" type="text" name="personal_id" class="form-control" value="<?php echo isset($check_data->personal_id) ? $check_data->personal_id : ''; ?>"/></div>
                                </div>
                                <div class="form-group" style="margin-bottom:10px;"><label for="text" class="control-label2 col-sm-4">Upload Picture:</label>
                                     <div class="col-sm-4">
                                        <label for="licence_piture" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Upload</span></label><!-- name="csv_file_for_receipts"-->
                                        <input id="licence_piture" name="image" type="file" accept="image/*"   class="form-control inputfile" style="padding: 0px;" />
                                     </div>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-inline" style="margin-bottom:20px;">
                    <div class="table-responsive">Authorized vehicles:
                    <table class="table table-bordered">
                    <thead>
                    <tr>
                    <th>
                    <input id="check10" name="vehicle_types[]" value="A" type="checkbox"  <?php if(isset($check_data->vehicle_types) && in_array("A", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/>
                    <label for="check10" class="for-check"><img src="assets/img/class-a.png"/></label>
                    </th>
                    <th><input id="check12" name="vehicle_types[]" value="A1" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("A1", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check12" class="for-check"><img src="assets/img/class-a1.png"/></label></th>
                    <th><input id="check13" name="vehicle_types[]" value="B" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("B", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check13" class="for-check"><img src="assets/img/class-b.png"/></label></th>
                    <th><input id="check14" name="vehicle_types[]" value="C" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("C", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check14" class="for-check"><img src="assets/img/class-c.png"/></label></th>
                    <th><input id="check15" name="vehicle_types[]" value="C1" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("C1", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check15" class="for-check"><img src="assets/img/class-c1.png"/></label></th>
                    <th><input id="check16" name="vehicle_types[]" value="D" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("D", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check16" class="for-check"><img src="assets/img/class-d.png"/></label></th>
                    <th><input id="check17" name="vehicle_types[]" value="E" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("E", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check17" class="for-check"><img src="assets/img/class-e.png"/></label></th>
                    <th><input id="check18" name="vehicle_types[]" value="F" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("F", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check18" class="for-check"><img src="assets/img/class-f.png"/></label></th>
                    <th><input id="check19" name="vehicle_types[]" value="G" type="checkbox" <?php if(isset($check_data->vehicle_types) && in_array("G", explode(",",$check_data->vehicle_types))) echo 'checked'; ?>/><label for="check19" class="for-check"><img src="assets/img/class-g.png"/></label></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr><td>A</td><td>A1</td><td>B</td><td>C</td><td>C1</td><td>D</td><td>E</td><td>F</td><td>G</td></tr></tbody>
                    </table>
                    </div>
                </div>
                <div class="form-horizontal" >
                    <div class="form-group">
                        <label for="text" class="control-label2 col-sm-2">Comments:</label>
                        <div class="col-sm-4"><input id="text-long" type="text" name="comments" class="form-control" value="<?php echo isset($check_data->comments) ? $check_data->comments : ''; ?>"/></div>
                        <div class="col4">
                        <a href="javascript:void(0);" onclick="update_licence_form()" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-saved"> Save</span></a>
                        <a href="#" class="btn btn-lg pop btn-default"><span class="glyphicon glyphicon-refresh"> Renew</span></a>
                        </div>
                    </div>
                    <input type="hidden" value="<?php echo isset($check_data->id) ? $check_data->id : ''; ?>" name="update_licence" />
                    <input type="submit" value="sub" id="licence_update_sub_btn" style="display:none;" />
                </div>
            </form>
            <script>
			function update_licence_form()
			{				
				if($('.nationality').val() == '')
				{
					$('#show_error_msg').show().text('ERROR !  Please select the nationality.');
					$('.nationality').focus();
					return false;
				}
				if($("input:checked").length == 0)
				{
					 $('#show_error_msg').show().text('ERROR !  Please select the vehicle type.');
					 return false;
				}
				if($("nationality").val == '')
				{
					 $('#show_error_msg').show().text('ERROR !  Please select the nationality.');
					 return false;
				}
				var birthdate1	=	$("#birth_date1").val();
				if(birthdate1 != '')
				{
					fnValidateDOB(birthdate1);
				}
				$('#licence_update_sub_btn').trigger('click');
			}
			</script>
            <div class="overlay">
                <div class="popup">
                    <div class="closeBtn">
                    	<div class="fa fa-close">
                    </div></div>
                    <p>Licence Renewal Table</p>
                    <div class="alert alert-danger" id="licence_renew_error_msg" style="display:none;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                    <div class="alert alert-success" id="licence_renew_success_msg" style="display:none;color:#144C15;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
                    <form role="form" class="form-inline">
                        <div class="form-group">
                        	<label type="text" style="padding-left: 0px" class="control-label col-sm-6">Licence No: </label>
                        	<div class="col-sm-2">
                            	<input id="text" type="text" class="form-control" readonly="readonly"  value="<?php echo isset($check_data->licence_no) ? $check_data->licence_no : ''; ?>"/>
                            </div>
                        	<br/>
                            <label type="text" style="padding-left: 0px" class="control-label col-sm-6">Holder's Name: </label>
                            <div class="col-sm-2">
                            	<input id="text" type="text" class="form-control" readonly value="<?php echo isset($check_data->name) ? $check_data->name : ''; ?>" style="width:300px"/>
                            </div>
                        </div>
                    </form>
                    <div class="table-responsive">

                    <table class="table table-bordered">
                    <thead>
                    <tr class="success">
                    	<th class="small-font">Receipt No</th>
                        <th class="small-font">Amount</th>
                        <th class="small-font">Renewal Type</th>
                        <th class="small-font">Renewal Date</th>
                        <th class="small-font">Expire Date</th>
                        <th class="small-font"></th>
                        <tr class="active">                       
                           <form method="post" id="uploadForm" action="model/licence_renewal_model.php" >
                        	<td><input id="text" type="text" placeholder="10001" name="receipt_no" onkeyup="get_receipt_data_licence_renew(this.value);" required="required" class="form-control insider receipt_no"/></td>
                            <td><input id="text" type="text" placeholder="$50" name="amount" readonly="readonly" required class="form-control insider licence_renew_fee"/></td>
                            <td>
                            <input id="licence_renew_hide_renewaldate" type="hidden" placeholder="dd-mm-yy" name="licence_renew_hide_renewaldate" required class="form-control insider licence_renew_hide_renewaldate" value="<?php echo isset($check_data->issue_date) ? date('d-m-Y', strtotime($check_data->issue_date)) : $_SESSION['VEHISSDATE']; ?>" />
                                        <input id="licence_renew_hide_expirydate" type="hidden" placeholder="dd-mm-yy" name="licence_renew_hide_expirydate" required class="form-control insider licence_renew_hide_expirydate" value="<?php echo isset($check_data->expiry_date) ? date('d-m-Y', strtotime($check_data->expiry_date)) : $_SESSION['VEHEXPDATE']; ?>"/> 
                                <select id="renewal_type" class="text-short" size="1" name="renewal_type" required placeholder="Renew" style="padding:0;" onchange="Change_licence_renewal_type(this.value);">
                                    <option value="1">For Expire</option>
                                    <option value="2">For Damage</option>
                                    <option value="3">For Lost</option>
                                </select>
                            </td>
                            <td>       
                            
    <input id="renewal_current_date" type="hidden" placeholder="dd-mm-yy" name="renewal_current_date" required class="form-control insider renewal_current_date" value="<?php echo date('d-m-Y');?>" />           
                            <input id="issue_date3" type="text" placeholder="dd-mm-yy" name="renewal_date" onkeyup="Change_expire_date_licence_renewal(this.value)" required class="form-control insider licence_renew_issue_date" value="<?php echo date('d-m-Y');?>" onkeypress="DateFormat(this,event.keyCode)" /></td>
                            <td><input id="expire_date4" type="text" placeholder="dd-mm-yy" name="expire_date" required class="form-control insider licence_renew_expire_date" value="<?php echo $_SESSION['VEHEXPDATE'];?>" readonly="readonly"/>
                            </td>
                            <td><a href="javascript:void(0);" onclick="submit_licence_renewal_form()" style="color: green" class="fa fa-save"></a>
                            	<input type="hidden" name="licence_renewal_form_data" value="1"/>
                                <input type="hidden" name="licence_renewal_licence_no" id="licence_renewal_licence_no" value="<?php echo isset($check_data->licence_no) ? $check_data->licence_no : ''; ?>"/>
                                <input type="submit" value="submit" id="sub_btn_licence_renewal" style="display:none;"/>
                            </td>
                           </form>
                        </tr>
                    </tr>
                    </thead>
                    <tbody id="licence_renewal_data_area">

                      <?php
					  if(isset($_POST['licence_no']))
					  {
						   $rec_id = $_POST['licence_no'];
						   $page = 1;
						   $per_page = 5; // Set how many records do you want to display per page.
						   $startpoint = ($page * $per_page) - $per_page;
						   $statement = "`tbl_licence_renewal` where licence_no = '".mysqli_real_escape_string($con, $_POST['licence_no'])."'  ORDER BY `id` DESC"; // Change `records` according to your table name.
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
					  ?>
                            <tr>
                                <td><?php echo $rec->receipt_no; ?></td>
                                <td>$<?php echo number_format($rec->amount,2); ?></td>
                                <td><?php echo $renewal_type; ?></td>
                                <td><?php echo date('d/m/Y', strtotime($rec->renewal_date)); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($rec->expire_date)); ?></td>
                                <td><a href="javascript:void(0)" style="color: red" onclick="licence_renewal_delete_record('<?php echo $rec->id;?>');" class="fa fa-trash"></a></td>
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
                     // displaying paginaiton.
                     $_SESSION['licence_renewal_statement'] = $statement;
                     echo ajax_pagination($statement,$per_page,$page,$url='licence_renewal_pagination', $con);
                    ?>
                    </div>
                </div>
                <script>
				$("#uploadForm").on('submit',(function(e) {
					e.preventDefault();
					$.ajax({
						url: "model/licence_renewal_model.php",
						type: "POST",
						data:  new FormData(this),
						contentType: false,
						cache: false,
						processData:false,
						success: function(data){
						   if(data == 'yes')
						   {
							   $('#licence_renew_success_msg').show().text('New records added successfully.');
							   get_latest_licence_renewal_record();
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
				function submit_licence_renewal_form()
				{	
					if($('.receipt_no').val() != '')
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
									$('#sub_btn_licence_renewal').trigger('click');

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
					function Change_licence_renewal_type(val)
					{
						var renewaltype		=	$("#renewal_type option:selected" ).val();
						var hide_issdate	=	$("#licence_renew_hide_renewaldate").val();
						var hide_expdate	=	$("#licence_renew_hide_expirydate").val();
						var renewal_date	=	$("#issue_date3").val();
						var currentdate		=	$("#renewal_current_date").val();
						//alert(renewal_date);
						
						if(renewaltype == 1)
						{
							//$("#issue_date3").removeAttr('readonly');
							$("#issue_date3").attr('readonly','readonly');	
							//$("#expire_date3").removeAttr('readonly');
							//$("#issue_date3").attr("onkeyup");							
							$(".licence_renew_issue_date").val(currentdate);
							Change_expire_date_licence_renewal(currentdate);	
						}
						else
						{	
							//$("#issue_date3").removeAttr("onkeyup");							
							$("#issue_date3").attr('readonly','readonly');	
							$("#issue_date3").val(hide_issdate);									
												
							$("#expire_date4").attr('readonly','readonly');
							$("#expire_date4").val(hide_expdate);
						}
					}
						
					function Change_expire_date_licence_renewal(val)
					{						
						var renewaltype		=	$("#renewal_type option:selected" ).val();
						
						var hide_issdate	=	$("#licence_renew_hide_renewaldate").val();
						var hide_expdate	=	$("#licence_renew_hide_expirydate").val();
						
						var dateAr = val.split('-');
						var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
						var someDate = new Date(newDate);
						//alert(someDate);
						var numberOfDaysToAdd = <?=THREEYEAR?>; // 2 year 730;//
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
					

					</script>                   
                
            </div>
            </div>
            <?php } ?>
            <?php if(isset($user_privileges[5]) && ($user_privileges[5]['r'] == 1 )){ ?>
            <div id="search-licence" class="tab-pane <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'search_list') echo 'in active'; else echo 'fade'; ?>">
            <div class="search-border">Search by</div>
            <form role="form" class="form-inline">
            <div class="form-group">
            <label for="text">Name:</label><input id="text" type="text" onkeyup="get_l_record_by_name(this.value);" class="form-control"/>
            </div>
            <div class="form-group"><label for="number">Licence:</label><input id="text" type="text" onkeyup="get_l_record_by_no(this.value);" class="form-control"/></div>
            <div class="form-group"><label for="number">Nationality:</label><input id="text" type="text" onkeyup="get_l_record_by_nationality(this.value);" class="form-control"/></div>
            <div class="form-group"><label for="number">Contact:</label><input id="text" type="text" onkeyup="get_l_record_by_contact(this.value);" class="form-control"/></div>
            </form>
            <div class="table-responsive">
            <table class="table table-bordered">
            	<thead>
                	<tr class="success">
                    	<th>Licence No</th>
                        <th>Holder's Name</th>
                        <th>Nationality</th>
                        <th>Date of Birth</th>
                        <th>Place of Issue</th>
                        <th>Date of Issue</th>
                        <th>Expire Date</th>
                        <th>Vehicle Type</th>
                        <th>PR</th>
                    </tr>
                </thead>
                <tbody id="licence_record_area">
                <?php
				 $page = 1;
				 $per_page = 10; // Set how many records do you want to display per page.
				 $startpoint = ($page * $per_page) - $per_page;
				 $statement = "`tbl_driver_detail` ORDER BY `id` DESC"; // Change `records` according to your table name.
				 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
				 //$sql = 'SELECT * from tbl_acc_type';
				 //$data = mysqli_query($con, $sql);
				 if(mysqli_num_rows($data) > 0){
				 while($rec = mysqli_fetch_object($data))
				 {   //acc_no  acc_name date acc_type amount comments
				?>
                	<tr>
                    	<td><?php echo $rec->licence_no;?></td>
                        <td><?php echo $rec->name;?></td>
                        <td><?php echo $rec->nationality;?></td>
                        <td><?php echo date('d/m/Y', strtotime($rec->date_birth));?></td>
                        <td><?php echo $rec->issue_place;?></td>
                        <td><?php echo date('d/m/Y', strtotime($rec->issue_date));?></td>
                        <td><?php echo date('d/m/Y', strtotime($rec->expiry_date));?></td>
                        <td><?php echo $rec->vehicle_types;?></td>
                        <td><a href="?licence_search_id=<?php echo $rec->licence_no; ?>" class="fa fa-print"></a></td>
                   </tr>
                <?php }
				   }else{
				?>   <tr><td colspan="9" style="color:red;">No record found</td></tr>
                <?php } ?>
                </tbody>
            </table>
            <div id="licence_pagination_area">
            <?php
			 // displaying paginaiton.
			 $pagination_data = array('current_statement' => $statement,
			 						  'per_page' => $per_page,
									  'current_page' => $page,
									  'db_con' => $con
									  );
			 $_SESSION['pagination_data'] = $pagination_data;
			 echo ajax_pagination($statement,$per_page,$page,$url='licence_pagination', $con);
 			?>
            </div>
            </div>
            <?php if(isset($logged_in_user->id) && $logged_in_user->id == 1){ ?>
                  <!--  <div class="upload-csv">
							<h4>Upload .csv file to database</h4>
                        <form role="form" class="upload" method="post" action="model/upload_csv_data.php"  enctype="multipart/form-data">
                            <input id="file" type="file" name="csv_file_for_licence" required="required" class="inputfile"/>
                            <label for="file" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Select .csv</span></label>
                            <input id="send" type="submit" name="submit" class="inputfile"/>
                            <a href="javascript:void(0);" onclick="show_message()" class="btn btn-lg btn-default">
                                <span class="glyphicon glyphicon-upload"> Upload .csv</span>
                              </a>
                            <label for="send" class="btn btn-lg btn-default" id="csv_upload_btn" style="display:none;">Upload</label>
                            <p style="display:none;" id="csv_msg">CSV file data has been adding in database. It may take few minutes.<br/>
                            Please Wait......</p>
                        </form>
                    </div>

                   <script>
                    function show_message()
                    {
                        $('#csv_upload_btn').trigger('click');
						if($('#file').val() != '')
                            $('#csv_msg').show();
                    }
                    </script>-->
                    
                    <?php } ?>

            </div> 

            <div id="card-list" class="tab-pane <?php if(isset($_SESSION['licence_section']) && $_SESSION['licence_section'] == 'card_list') echo 'in active'; else echo 'fade'; ?>">
            <div class="search-border2">Search by date</div>
            <form role="form" class="form-inline"><div class="form-group"><label for="text">From Date:</label><input id="by_from_date" type="text" onkeyup="get_l_record_by_from_date(this.value);" class="form-control" placeholder="dd-mm-yy"/></div>
            <div class="form-group"><label for="number">To Date:</label><input id="by_to_date" type="text" onkeyup="get_l_record_by_to_date(this.value);" class="form-control" placeholder="dd-mm-yy"/></div>
            </form>
            <?php
			if(isset($_GET['cardId']))
		    {
			   $rec_id = base64_decode($_GET['cardId']);
			   $check = mysqli_query($con, 'select * from tbl_driver_detail where id = "'.mysqli_real_escape_string($con, $rec_id).'" ');
			   $card_data = @mysqli_fetch_object($check);

		    }
			?>
            <div class="table-responsive">
            	<table class="table table-bordered">
                	<thead>
                    	<tr class="success">
                            <th></th>
                        	<th>Licence No</th>
                            <th>Holder's Name</th>
                            <th>Nationality</th>
                            <th>Date of Birth</th>
                            <th>Place of Issue</th>
                            <th>Date of Issue</th>
                            <th>Expire Date</th>
                            <th>Vehicle Type</th>
                            <th>E</th>
                            <th>Del</th>
                        </tr>
                        <?php if(isset($user_privileges[5]) && ($user_privileges[5]['w'] == 1 || $user_privileges[5]['e'] == 1 )){ ?>
                        <tr class="active">
                          <form method="post" action="model/licence_model.php<?php if(isset($_GET['cardId']) && $_GET['cardId'] !=''){ ?>?cardId=<?php echo $rec_id; ?><?php  } ?>">
                        	<td></td>
                            <td><input type="text" placeholder="123" name="licence_no" required="required" class="insider" value="<?php echo isset($card_data->licence_no) ? $card_data->licence_no : (isset($licence_data->licence_no) ? $licence_data->licence_no + 1 : '1');?>"/></td>
                            <td><input type="text" placeholder="Holders name" name="name" required class="insider" value="<?php echo isset($card_data->name) ? $card_data->name : '';?>"/></td>
                            <td><input type="text" placeholder="Nationality" name="nationality" required class="insider" value="<?php echo isset($card_data->nationality) ? $card_data->nationality : '';?>"/></td>
                            <td><input type="text" placeholder="dd-mm-yy" name="date_birth" required class="insider" value="<?php echo isset($card_data->date_birth) ? date('d-m-Y', strtotime($card_data->date_birth)) : '';?>"/></td>
                            <td>
                            <!--<input type="text" placeholder="Place" name="issue_place"  class="insider" value="<?php echo isset($card_data->issue_place) ? $card_data->issue_place : 'Mogadishu';?>"/>-->
                            <select id="text-short" size="1" name="issue_place" placeholder="Place">
                            <?php foreach($ArIssuePlace as $key => $value){
								if($card_data->issue_place == $value)
									$sel	= "selected = 'selected' ";
								else
									$sel	=	"";	
                            	echo "<option value='$value' $sel>$value</option>";
                            } ?>
                         </select>
                            </td>
                            <td><input type="text" id="issue_date2" placeholder="dd-mm-yy" name="issue_date" onkeyup="Change_expire_date_card(this.value)" required class="insider" value="<?php echo isset($card_data->issue_date) ? date('d-m-Y', strtotime($card_data->issue_date)) : '';?>" onkeypress="DateFormat(this,event.keyCode)"/></td>
                            <td><input type="text" id="expire_date" placeholder="dd-mm-yy" name="expiry_date" required class="insider" value="<?php echo isset($card_data->expiry_date) ? date('d-m-Y', strtotime($card_data->expiry_date)) : '';?>" onkeypress="DateFormat(this,event.keyCode)"/></td>
                            <td><input type="text" placeholder="Vehicle type" name="vehicle_types" required class="insider" value="<?php echo isset($card_data->vehicle_types) ? $card_data->vehicle_types : '';?>" onblur="this.value=this.value.toUpperCase();"/></td>
                            <td colspan="2"><a href="javascript:void(0);" class="fa fa-save" onclick="submit_card_licence_form()"></a><input type="hidden" name="add_licence_data"/>
                               <input type="submit" value="submit" style="display:none;" id="sub_btn_add_licence_card"/>
                            </td>
                          </form>
                        </tr>
                        <?php } ?>
                    </thead>
                    <tbody id="licence_card_record_area">
					 <?php
                     $page = 1;
                     $per_page = 10; // Set how many records do you want to display per page.
                     $startpoint = ($page * $per_page) - $per_page;
                     $statement = "`tbl_driver_detail` WHERE status = 1 and updated_time > DATE_SUB(NOW(), INTERVAL 7 day) ORDER BY updated_time "; // Change `records` according to your table name.
                     $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
                     //$sql = 'SELECT * from tbl_acc_type';
                     //$data = mysqli_query($con, $sql);
					 if(mysqli_num_rows($data) > 0){
                     while($rec = mysqli_fetch_object($data))
                     {   //acc_no  acc_name date acc_type amount comments
                     ?>
                        <tr>
                            <td><a href="?print_licence_no=<?php echo $rec->licence_no;?>" class="fa fa-print"></a></td>
                            <td><?php echo $rec->licence_no;?></td>
                            <td><?php echo $rec->name;?></td>
                            <td><?php echo $rec->nationality;?></td>
                            <td><?php echo date('d/m/Y', strtotime($rec->date_birth));?></td>
                            <td><?php echo $rec->issue_place;?></td>
                            <td><?php echo date('d/m/Y', strtotime($rec->issue_date));?></td>
                            <td><?php echo date('d/m/Y', strtotime($rec->expiry_date));?></td>
                            <td><?php echo $rec->vehicle_types;?></td>
                            <td><a href="?cardId=<?php echo base64_encode($rec->id);?>" class="glyphicon glyphicon-edit"></a></td>
                            <td><a href="model/licence_model.php?delete_cardID=<?php echo base64_encode($rec->id);?>" onclick="return confirm('Are you sure to delete ? ');" class="glyphicon glyphicon-trash"></a></td>
                       </tr>
                     <?php }
					   }else{
					?>   <tr><td colspan="10" style="color:red;">No record found</td></tr>
					<?php } ?>
                   </tbody>
               </table>
               <div id="licence_card_pagination_area">
				<?php
                 // displaying paginaiton.
                 $pagination_data = array('current_statement' => $statement,
                                          'per_page' => $per_page,
                                          'current_page' => $page,
                                          'db_con' => $con
                                          );
                 $_SESSION['licence_card_pagination_data'] = $pagination_data;
                 echo ajax_pagination($statement,$per_page,$page,$url='licence_card_pagination', $con);
                ?>
                </div>

            </div>

            </div>
            <?php } ?>

            <!-- --------------------------------------------------------- -->

            <div  id="tab" style="display:none;">

                <div style="border-bottom:1px solid #333;overflow:auto;text-align:center;">
                    <div>
                       <div style="height: auto;width: 32%;float:left;padding:20px 10px;">
                            WASAARADDA GAADIIDKA IYO DUULISTA HAWADA
                            WAAXDA GAADIIDKA DHULKA
                       </div>
                       <div style="height: auto;width: 20%;float:left;">
                           <img src="assets/img/top_head.png" style="width:60%;"/>
                       </div>
                       <div style="height: auto;width: 35%;float:left;padding:20px 10px;">
                           MINISTRY OF TRANSPORT AND CIVIL AVIATION
                           VEHICLE TRANSPORT DEPARTMENT
                        </div>

                    </div>
                    <div style="font-weight:bold;clear:both;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y  h:i:sa'); ?></div>
                </div>
                <h3> <center>LICENCE DETAILS </center></h3>
                <div style="padding-left:20px;">
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                       <!--<tr >
                           <th style="padding:5px;">Licence No:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->licence_no) ? $search_result->licence_no : '';?> </td>
                           <th style="padding:5px;"> Place of Issue:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->issue_place) ? $search_result->issue_place : '';?></td>
                        </tr> -->
                        <tr align="left">
                           <th style="padding:5px;">Date of Issue:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->issue_date) ? date('d/m/Y', strtotime($search_result->issue_date)) : '';?></td>
                           <th style="padding:5px;">Expire Date:</th>
                           <td style="padding:5px;"><?php echo isset($search_result->expiry_date) ? date('d/m/Y', strtotime($search_result->expiry_date)) : '';?></td>
													 <th style="padding:5px;text-align:center;">Holders Photo</th>
												</tr>
                        <tr align="left">
                           <th style="padding:5px;">Licence No:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->licence_no) ? $search_result->licence_no : '';?></td>
													 <td style="padding:5px;" rowspan="7">
														 <div class="col" >
 				                      <?php if(isset($search_result->image) && $search_result->image != '' && file_exists("uploads/users_licence/".$search_result->image)){ ?>
 										  		 <img src="<?php echo "uploads/users_licence/".$search_result->image; ?>" style="width:118px;height:159px;"/>

 				                           <?php }else { ?>
 				                                 <img style="display:block;margin:0 auto;" src="assets/img/user-big.png" />
 				                           <?php } ?>

 				                     </div>
													 </td>
												</tr>
                        <tr align="left">
                           <th style="padding:5px;">Place of Issue:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->issue_place) ? $search_result->issue_place : '';?></td>
                        </tr>
												<tr align="left">
													 <th style="padding:5px;">Holder's Name::</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->name) ? $search_result->name : '';?></td>
												</tr>
												<tr align="left">
													 <th style="padding:5px;">Nationality:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->nationality) ? $search_result->nationality : '';?></td>
												</tr>
												<tr align="left">
													 <th style="padding:5px;">Date of Birth:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->date_birth) ? date('d/m/Y', strtotime($search_result->date_birth)) : '';?></td>
												</tr>
												<tr align="left">
													 <th style="padding:5px;">Gender:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->gender) ? ($search_result->gender==1 ? 'Lab' : 'Dhedig') : '';?></td>
												</tr>
												<tr align="left">
                           <th style="padding:5px;">Authorized vehicles:</th>
													 <td style="padding:5px;" colspan="3"><?php echo isset($search_result->vehicle_types) ? $search_result->vehicle_types : '';?></td>
                        </tr>
										 </table>
                </div>

                <hr/>
                <div id="Licence_image_card">
                   <img src="create_licence_image/Licence.jpg" style="border:1px solid #666666;"/>
                </div>

            </div>

						<!-- --------------------------------------------------------- -->

			<div  id="tab2" style="display:none;">

                <div style="border-bottom:1px solid #333;overflow:auto;text-align:center;">
										<div>
											 <div style="height: auto;width: 45%;float:left;padding:10px 0px;font-size:12px;">
														WASAARADDA GAADIIDKA IYO DUULISTA HAWADA <br>
														WAAXDA GAADIIDKA DHULKA
											 </div>
											 <div style="height: auto;width: 15%;float:left;padding-bottom:20px;">
													 <img src="assets/img/top_head.png" style="width:60%;"/>
											 </div>
											 <div style="height: auto;width: 40%;float:left;padding:10px 0px;font-size:12px;">
													 MINISTRY OF TRANSPORT AND CIVIL AVIATION <br>
													 VEHICLE TRANSPORT DEPARTMENT
												</div>

										</div>
                    <div style="font-weight:bold;clear:both;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y  h:i:sa'); ?></div>
                </div>
                <h3> <center>DRIVER AND LICENSE DETAILS</center></h3>
                <div style="padding-left:20px;">
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="left">
                           <th align="left" style="padding:5px; text-align:left;">Date of Issue:</th>
                           <td align="left" style="padding:5px; text-align:left;"><?php echo isset($search_result->issue_date) ? date('d/m/Y', strtotime($search_result->issue_date)) : '';?></td>
                           <th align="left" style="padding:5px; text-align:left;">Expire Date:</th>
                           <td align="left" style="padding:5px; text-align:left;"><?php echo isset($search_result->expiry_date) ? date('d/m/Y', strtotime($search_result->expiry_date)) : '';?></td>
													 <th style="padding:5px;text-align:center;">Holders Photo</th>
												</tr>
                        <tr align="left">
                           <th align="left" style="padding:5px; text-align:left;">Licence No:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="3"><?php echo isset($search_result->licence_no) ? $search_result->licence_no : '';?></td>
													 <td  style="padding:5px;" rowspan="5" align="center">
														 <div class="col" >
														  		<?php if(isset($search_result->image) && $search_result->image != '' && file_exists("uploads/users_licence/".$search_result->image)){ ?>
                                                                     <img src="<?php echo "uploads/users_licence/".$search_result->image; ?>" style="width:118px;height:159px;"/>
                    
                                                               <?php }else { ?>
                                                                     <img style="display:block;margin:0 auto;" src="assets/img/user-big.png" />
                                                               <?php } ?>
                     									</div>
													 </td>
												</tr>
                        <tr align="left">
                           <th align="left" style="padding:5px; text-align:left;">Place of Issue:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="3"><?php echo isset($search_result->issue_place) ? $search_result->issue_place : '';?></td>
                        </tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Holder's Name::</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="3"><?php echo isset($search_result->name) ? $search_result->name : '';?></td>
												</tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Mother's Name:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="3"><?php echo isset($search_result->mother_name) ? $search_result->mother_name : '';?></td>
												</tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Nationality:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="3"><?php echo isset($search_result->nationality) ? $search_result->nationality : '';?></td>
												</tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Date of Birth:</th>
													 <td align="left" style="padding:5px; text-align:left;"><?php echo isset($search_result->date_birth) ? date('d/m/Y', strtotime($search_result->date_birth)) : '';?></td>
													 <th align="left" style="padding:5px; text-align:left;">Place of Birth:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="2"><?php echo isset($search_result->birth_place) ? $search_result->birth_place : '';?></td>
												</tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Gender:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->gender) ? ($search_result->gender==1 ? 'Lab' : 'Dhedig') : '';?></td>
												</tr>
												<tr align="left">
													 <th align="left" style="padding:5px; text-align:left;">Personal ID:</th>
													 <td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->personal_id) ? $search_result->personal_id : '';?></td>
												</tr>
												<tr align="left">
													<th align="left" style="padding:5px; text-align:left;">Residence Address:</th>
													<td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->address) ? $search_result->address : '';?></td>
												</tr>
												<tr align="left">
												  <th align="left" style="padding:5px; text-align:left;">Mobile:</th>
											  	<td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->contact_no) ? $search_result->contact_no : '';?></td>
										    </tr>

											<tr align="left">
                                               <th align="left" style="padding:5px; text-align:left;">Authorized vehicles:</th>
                                               <td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->vehicle_types) ? $search_result->vehicle_types : '';?></td>
                                            </tr>
                                            <tr align="left">
													<th align="left" style="padding:5px; text-align:left;">Email Address:</th>
													<td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->email) ? $search_result->email : '';?></td>
										  	</tr>
											<tr align="left">
                                                  <th align="left" style="padding:5px; text-align:left;">Comments:</th>
                                                  <td align="left" style="padding:5px; text-align:left;" colspan="4"><?php echo isset($search_result->comments) ? $search_result->comments : '';?></td>
                                            </tr>
										 </table>
                    
                    <!--  Renewal History table -->
                    <h3> Renewal History </h3>
                    <table style="width:98%;text-align:left;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="left">
                           <th  style="padding:5px;">Renewal Type</th>
                           <th style="padding:5px;">Renewal Date</th>
                           <th style="padding:5px;">Expire Date</th>
                           <th style="padding:5px;">Receipt No</th>
                        </tr>                     
                        <?php
						$renewal_history = mysqli_query($con, 'select * from tbl_licence_renewal where licence_no = "'.mysqli_real_escape_string($con, $_GET['licence_search_id']).'" ');
					    if(mysqli_num_rows($renewal_history) > 0)
						{
						     while($renewal_rec = @mysqli_fetch_object($renewal_history))
							 {
								 if($renewal_rec->renewal_type == 1)
								     $renewl_type = 'Expire';
								 else if($renewal_rec->renewal_type == 2)
								     $renewl_type = 'Damage';
								 else if($renewal_rec->renewal_type == 3)
								     $renewl_type = 'Lost';	 	 
								 else
								     $renewl_type;	 
					   ?>		
                       			<tr align="left">
                                   <td  style="padding:5px;"><?php echo $renewl_type; ?></td>
                                   <td  style="padding:5px;"><?php echo $renewal_rec->renewal_date != '' ? date('m/d/Y', strtotime($renewal_rec->renewal_date)) : '' ; ?></td>
                                   <td  style="padding:5px;"><?php echo $renewal_rec->expire_date != '' ? date('m/d/Y', strtotime($renewal_rec->expire_date)) : '' ; ?></td>
                                   <td  style="padding:5px;"><?php echo $renewal_rec->receipt_no; ?></td>
                                </tr>  
                        <?php
							 }
						}else{
						?>
                              <tr align="center">
                                   <td  colspan="4" style="padding:5px;color:red;">No record available</td>
                              </tr> 
                         <?php } ?>      
                        </table>
                </div>
					<?php /*?><div class="form-inline" style="margin-bottom:20px;">
                    <div class="table-responsive" style="padding-left:20px;"><b>Authorized vehicles:</b>

                        <table style="width:80%;" class="table table-bordered">
	                    <thead>
	                    <tr>
                            <th>
                            <label for="check10" class="for-check"><img src="assets/img/class-a.png"/></label>
                            </th>
                            <th><label for="check12" class="for-check"><img src="assets/img/class-a1.png"/></label></th>
                            <th><label for="check13" class="for-check"><img src="assets/img/class-b.png"/></label></th>
                            <th><label for="check14" class="for-check"><img src="assets/img/class-c.png"/></label></th>
                            <th><label for="check15" class="for-check"><img src="assets/img/class-c1.png"/></label></th>
                            <th><label for="check16" class="for-check"><img src="assets/img/class-d.png"/></label></th>
                            <th><label for="check17" class="for-check"><img src="assets/img/class-e.png"/></label></th>
                            <th><label for="check18" class="for-check"><img src="assets/img/class-f.png"/></label></th>
                            <th><label for="check19" class="for-check"><img src="assets/img/class-g.png"/></label></th>
	                    </tr>
	                    </thead>
	                    <tbody>
	                    <tr align="center"><td>A</td><td>A1</td><td>B</td><td>C</td><td>C1</td><td>D</td><td>E</td><td>F</td><td>G</td></tr></tbody>
	                    <tr>
                            <th>
                            <input id="check10" name="vehicle_types[]" value="A" type="checkbox"  <?php if(isset($search_result->vehicle_types) && in_array("A", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/>
                            </th>
                            <th><input id="check12" name="vehicle_types[]" value="A1"  type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("A1", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check13" name="vehicle_types[]" value="B" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("B", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check14" name="vehicle_types[]" value="C" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("C", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check15" name="vehicle_types[]" value="C1" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("C1", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check16" name="vehicle_types[]" value="D" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("D", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check17" name="vehicle_types[]" value="E" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("E", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check18" name="vehicle_types[]" value="F" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("F", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
                            <th><input id="check19" name="vehicle_types[]" value="G" type="checkbox" <?php if(isset($search_result->vehicle_types) && in_array("G", explode(",",$search_result->vehicle_types))) echo 'checked'; ?>/></th>
	                    </tr>
                        </table>
                    </div>
                </div><?php */?>
            </div>

             <!-- ------------------ -->
             <div  id="tab3" style="display:none;width:200px;height:200px;">
				<div id="Licence_image_card" style="height:640px;">
                   <img src="create_licence_image/Licence.jpg" style="border:1px solid #666666;"/>
                </div>
                <div id="Licence_image_card" style="height:640px;">
                   <img src="create_licence_image/Main_images/licence_back.png" style="border:1px solid #666666;"/>
                </div>
             </div>


                <!--<div style="padding-left:20px;">
                    <h5>Licence owner details:</h5>
                    <div class="col" style="float:left;">
                      <?php if(isset($search_result->image) && $search_result->image != '' && file_exists("uploads/users_licence/".$search_result->image)){ ?>
						  		 <img src="<?php echo "uploads/users_licence/".$search_result->image; ?>" style="width:118px;height:159px;"/>

                           <?php }else { ?>
                                 <img src="assets/img/user-big.png"/>
                           <?php } ?>

                     </div>
                     <div  style="float:left; width:80%;margin-left:20px;">
                        <table style="width:100%;text-align:left;" border="1" cellpadding="0" cellspacing="0">



                            <tr>
                               <th style="padding:5px;">Holder's Name::</th>
                               <td style="padding:5px;"><?php echo isset($search_result->name) ? $search_result->name : '';?></td>
                               <th style="padding:5px;">Nationality:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->nationality) ? $search_result->nationality : '';?></td>
                            </tr>
                            <tr>
                               <th style="padding:5px;">Gender:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->gender) ? ($search_result->gender==1 ? 'Lab' : 'Dhedig') : '';?></td>
                               <th style="padding:5px;">Residence Address:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->address) ? $search_result->address : '';?></td>

                            </tr>
                            <tr>
                               <th  style="padding:5px;">Mother's Name:</th>
                               <td style="padding:5px;" ><?php echo isset($search_result->mother_name) ? $search_result->mother_name : '';?></td>
                               <th style="padding:5px;">Email Address:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->email) ? $search_result->email : '';?></td>
                            </tr>
                            <tr>
                               <th style="padding:5px;">Date of Birth:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->date_birth) ? date('d/m/Y', strtotime($search_result->date_birth)) : '';?></td>
                               <th style="padding:5px;">Contacts:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->contact_no) ? $search_result->contact_no : '';?></td>
                            </tr>
                            <tr>
                               <th style="padding:5px;">Place of Birth:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->birth_place) ? $search_result->birth_place : '';?></td>
                               <th style="padding:5px;">Personal ID:</th>
                               <td style="padding:5px;"><?php echo isset($search_result->personal_id) ? $search_result->personal_id : '';?></td>
                            </tr>


                         </table>
                     </div>
                </div> -->


          <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->

        </div>
    </div>

<script>
    $(document).ready(function(e) {
        <?php if(isset($_GET['print_licence_no']))
		{ 
		?>
		      var license_no = '<?php echo isset($search_result->licence_no) ? $search_result->licence_no : '';?>',
			      name = '<?php echo isset($search_result->name) ? str_replace("'", "\'", $search_result->name) : '';?>',
				  nationality = '<?php echo isset($search_result->nationality) ? $search_result->nationality : '';?>',
				  date_birth = '<?php echo isset($search_result->date_birth) ? date('d/m/Y', strtotime($search_result->date_birth)) : '';?>',
				  issue_place = '<?php echo isset($search_result->issue_place) ? $search_result->issue_place : '';?>',
				  vehicle_types = '<?php echo isset($search_result->vehicle_types) ? str_replace(",","-",$search_result->vehicle_types) : '';?>',
				  issue_date = '<?php echo isset($search_result->issue_date) ? date('d-m-Y', strtotime($search_result->issue_date)) : '';?>',
				  expiry_date = '<?php echo isset($search_result->expiry_date) ? date('d-m-Y', strtotime($search_result->expiry_date)) : '';?>',
				  name = '<?php echo isset($search_result->name) ? str_replace("'", "\'", $search_result->name) : '';?>';
			  var image = '';
			  <?php if(isset($search_result->image) && $search_result->image != '' && file_exists("uploads/users_licence/".$search_result->image)){ ?>
					image = '<?php echo $search_result->image; ?>';
			  <?php }else { ?>
                     image = 'user-big.png';
              <?php }	 ?>
			 	/*if(license_no == '' && name == '' && nationality == '' && date_birth == '' && issue_place == '' && vehicle_types == '' && issue_date == '' && expiry_date == '')
				{
					$('#show_error_msg').show().text('ERROR !  Please enter all the details for issue the card.');
					return false;
				}
				else
				{	 }*/	
		
					
			  var setting = '<?php echo ($setting_data->layoutpath); ?>';
			
				                        
			  var content = "$$$$§A:p §S:f §D:"+setting+" §F0:"+license_no+"  §F1: "+name+" §F2:"+nationality+" §F3:"+date_birth+" §F4:"+issue_place+" §F5:"+vehicle_types+" §F6:"+issue_date+" §F7:"+expiry_date+" §IPhotograph:http:%%gaadiidkapra.com%PRA%uploads%users_licence%"+image+"$$$$";
			 //var content = "$$$$/A:v /S:f /D:"+setting+" /F0:"+license_no+"  /F1:"+name+"/F2:"+nationality+"/F3:01-01-1990/F4:"+issue_place+" /F5:"+vehicle_types+" /F6:"+issue_date+" /F7:"+expiry_date+" /IPhotograph:http:%%gaadiidkapra.com%PRA%uploads%users_licence%"+image+"$$$$";
			  		printDiv(content);

	    <?php }
		      if(isset($_GET['licence_search_id'])){ ?>
			    PrintReports('#tab2');
		<?php } ?>
    });

	function printDiv(content)
	{

	  var newWin=window.open('','Print-Window');
	  newWin.document.open();
	  newWin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
	  newWin.document.close();
	  setTimeout(function(){newWin.close();},10);
	}
	function getImages()
	{
			 //PrintReports('#tab3');
			 window.open('licence_print.php', '_blank');

	}

	function Change_expire_date_card(val)
	{
		//alert($('.expiry_date').val());
		var dateAr = val.split('-');
		var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0];
		var someDate = new Date(newDate);
		//alert(someDate);
		var numberOfDaysToAdd = <?=THREEYEAR?>; //1095
		someDate.setDate(someDate.getDate() + numberOfDaysToAdd);
		if(!isNaN(someDate.getTime())){

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
			$("#expire_date").val(newDate);
		}
		else
		{
			$("#expire_date").val('dd/mm/yy');
			}


	}
    $('#fileinput').change(function(){
		$('#gallery').html('');

	});
	$('#licence_piture').change(function(){
		 $('#pictures_2').html('');
	});
	</script>
     <script src="assets/gallery.js"></script>
    <script src="assets/gallery_2.js"></script>
    <script src="assets/js/functions.js"></script>
 <?php /* ###############
         Footer
	  */
	  unset($_SESSION['search_statement']);
	   unset($_SESSION['licence_section']);
	  include_once('inc/footer.php');
?>
<script> 
$(function() {
	$( "#issue_date" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#expiry_date" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		//onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });	
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
//edit page
	$( "#issue_date1" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
	$( "#licence_renew_expire_date1" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		//onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
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
//search page		
	$( "#issue_date2" ).datepicker({
		yearRange: '0:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, Change_expire_date_card(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#expire_date3" ).datepicker({
		yearRange: '0:+20',
		minDate: 'today',
		//maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		//onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
			
	$( "#by_from_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_l_record_by_from_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#by_to_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_l_record_by_to_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });		
	
});

 </script>
