<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];
?>
<script>   
$(function() {
	$( "#from_date" ).datepicker({
		yearRange: '-50:+20',
		//minDate: 'today',
		maxDate: 'today',
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		showOn: "both",
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true
	});
	$( "#by_from_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_record_by_from_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
	$( "#by_to_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_record_by_to_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
			
	$( "#account_data_date" ).datepicker({
		yearRange: '-50:+20',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		onSelect: function(dates) {showOnFocus: true, get_account_data_date(this.value) },
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
});
 </script>
  <div class="right-nav">
        <ul class="nav nav-tabs">
          <li <?php if(!isset($_GET['section'])) { ?> class="active" <?php } ?>>
            <a data-toggle="tab" href="#receipts">Receipts
            </a>
          </li>
          <li <?php if(isset($_GET['section']) && $_GET['section'] == 'acc_list') { ?> class="active" <?php } ?>>
            <a data-toggle="tab" href="#prices" id="acc_tab">Prices/Accounts List
            </a>
          </li>
          <li style="float: right;">
             <?php if(isset($_SESSION['success'])){ ?>
                <div class="alert alert-success" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;float:right;"><?php echo $_SESSION['success']; ?></div>
              <?php unset($_SESSION['success']); } ?>
              <?php if(isset($_SESSION['error'])){ ?>
                <div class="alert alert-danger" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"><?php echo $_SESSION['error']; ?></div>
              <?php unset($_SESSION['error']);  } ?>
              <div class="alert alert-danger" id="show_error_msg" style="padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div>
           </li>
        </ul>
        <div class="tab-content">
          <?php
			   // Edit...
			   if(isset($_GET['id']))
			   {
				   $rec_id = base64_decode($_GET['id']);
				   $check = mysqli_query($con, 'select r.*, u.username from tbl_receipts r
				   								left join tbl_users u
												on u.id = r.updatedBy
												where r.id = '.$rec_id.'');
				   $check_data = @mysqli_fetch_object($check);
				   if(empty($check_data))
				       $_SESSION['error'] = 'ERROR ! Record not available.';
			   }
			   else
			   {
			   	//max(receipt_no) + 1
				   $checkQry = mysqli_query($con, 'select max(receipt_no) + 1 as mrecid from tbl_receipts');
				   $GetRecData = @mysqli_fetch_object($checkQry);
				   if(empty($GetRecData))
				       $_SESSION['error'] = 'ERROR ! Record not available.';
			   }
	      ?>

          <?php /*?><?php if(isset($_SESSION['success'])){ ?>
          	<div class="alert alert-success" style="margin-top:5px;"><?php echo $_SESSION['success']; ?></div>
          <?php unset($_SESSION['success']); } ?>
          <?php if(isset($_SESSION['error'])){ ?>
          	<div class="alert alert-danger" style="margin-top:5px;"><?php echo $_SESSION['error']; ?></div>
          <?php unset($_SESSION['error']);  } ?><?php */?>
          <div id="receipts" class="tab-pane fade in <?php if(isset($_GET['section']) && $_GET['section'] == 'acc_list') echo 'fade'; else echo 'active'; ?>">
            <?php if(isset($user_privileges[1]) && ($user_privileges[1]['w'] == 1 || ($user_privileges[1]['e'] == 1 && isset($_GET['id'])))){ ?>
            <form role="form" id="receipt_form"  action="model/receipt_model.php<?php if(!empty($check_data)) echo '?id='.$_GET['id'];?>" method="post">
             <div  class="form-inline" >
              <div class="form-group">
                <label for="text">Receipt No:
                </label>
               <input id="receipt_no" type="text" <?php if(isset($_GET['id']) && (isset($logged_in_user->id) && $logged_in_user->id != 1)) echo 'readonly'; ?>   name="receipt_no" required class="form-control" value="<?php echo isset($check_data->receipt_no) ? $check_data->receipt_no : $GetRecData -> mrecid; ?>"/>
              </div>
              <div class="form-group">
                <label for="date">Date:
                </label>
                <?php if(isset($_GET['id'])){ ?>
                	<input type="text" name="date"  required="required" value="<?php echo isset($check_data->date) ? date('d-m-Y', strtotime($check_data->date)) : date('d-m-Y'); ?>"  class="form-control datepick" <?php if(isset($logged_in_user->id) && $logged_in_user->id == 1){ ?> id="from_date" onkeyup="Change_expire_date(this.value)" onkeypress="DateFormat(this,event.keyCode)" <?php }else{ ?> readonly="readonly" <?php } ?> />
                <?php }else { ?>
                    <input type="text" name="date" id="from_date" onkeyup="Change_expire_date(this.value)" required="required" value="<?php echo date('d-m-Y'); ?>"  class="form-control datepick" onkeypress="DateFormat(this,event.keyCode)" readonly="readonly" />
                <?php } ?>        
                
              </div>
              <?php /*?><div class="form-group">
                <label for="date">Expire Date:
                </label>
                <input type="text" name="expire_date" id="expire_date"  placeholder="Issue Date + 90 days" value="<?php echo isset($check_data->expire_date) ? date('d-m-Y', strtotime($check_data->expire_date)) : date('d-m-Y', strtotime("+90 Day")); ?>" class="form-control"/>
              </div>
              <script>
				function Change_expire_date(val)
				{

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
						$("#expire_date").val(newDate);
					}
					else
					    $("#expire_date").val('dd-mm-yy');


				}

				</script>
				<?php */?>
            </div>
            <div class="separator-div">
              <div class="form-left-side">

                <div  class="form-horizontal" >
                  <?php /*?><div class="form-group">
                    <label for="text" class="control-label col-sm-4">Receipt No:
                    </label>
                    <div class="col-sm-8">
                    	<input id="receipt_no" type="text" name="receipt_no" required class="form-control" value="<?php echo isset($check_data->receipt_no) ? $check_data->receipt_no : ''; ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="date" class="control-label col-sm-4">Date:
                    </label>
                    <div class="col-sm-8">
                    	<input id="date" type="text" name="date" value="<?php echo isset($check_data->date) ? date('d-m-Y', strtotime($check_data->date)) : date('d-m-Y'); ?>" readonly class="form-control"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="date" class="control-label col-sm-4">Expire Date:
                    </label>
                    <div class="col-sm-8">
                    	<input id="expire_date" type="text" name="expire_date" readonly placeholder="Issue Date + 90 days" value="<?php echo isset($check_data->expire_date) ? date('d-m-Y', strtotime($check_data->expire_date)) : date('d-m-Y', strtotime("+90 Day")); ?>" class="form-control"/>
                    </div>
                  </div><?php */?>
                  <div class="form-group">
                    <label for="text" class="control-label col-sm-4">Received from:
                    </label>
                    <div class="col-sm-8">
                      <input id="received_from" type="text" name="received_from" required class="form-control" value="<?php echo isset($check_data->received_from) ? $check_data->received_from : ''; ?>"/>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="text" class="control-label col-sm-4">For:
                    </label>
                    <div class="col-sm-8">
                      <select size="1" required name="for_opt" id="for_opt" onchange="get_acc_amount(this.value)">
						<option value=""> Select For... </option>
						<?php
                        $sql = 'SELECT * from tbl_account_list';
                         $data = mysqli_query($con, $sql);
                         while($rec = mysqli_fetch_object($data))
                         {   //acc_no
                        ?>
                             <option value="<?php echo $rec->acc_name; ?>" <?php if(isset($check_data->for_opt) && $check_data->for_opt ==  $rec->acc_name) echo 'selected'; ?>><?php echo $rec->acc_name; ?></option>
                        <?php } ?>

                      </select>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="text" class="control-label col-sm-4">Amount of:
                    </label>
                    <div class="col-sm-8">
                      <input id="amount" type="text" name="amount" required readonly="readonly" class="form-control" value="<?php echo isset($check_data->amount) ? $check_data->amount : ''; ?>"/>
                    </div>
                  </div>
                  
                  <?php /*?><div class="form-group">
                    <label for="text" class="control-label col-sm-4">Vehicle No:
                    </label>
                    <div class="col-sm-8">
                      <input id="vehicle_no" type="text" name="vehicle_no"  class="form-control" value="<?php echo isset($check_data->vehicle_no) ? $check_data->vehicle_no : ''; ?>"/>
                    </div>
                  </div><?php */?>
                  <div class="form-group">
                    <label for="text" class="control-label col-sm-4">User:
                    </label>
                    <div class="col-sm-8">
                      <input type="text" id="comments" name="comments" class="form-control" value="<?php echo isset($check_data->username) ? $check_data->username : ''; ?>" />
                    </div>
                  </div>
                </div>
              </div>
              <div class="form-right-side">
                <a href="javascript:void(0);" onClick="submit_form()" class="btn btn-lg btn-default">
                  <span class="glyphicon glyphicon-saved"> Save </span>
                </a>
                <a href="javascript:void(0);" class="btn btn-lg btn-default" onclick="PrintElem('#tab')">
                  <span class="glyphicon glyphicon-print"> Print
                  </span>
                </a>
                <a href="javascript:void(0);"  title="Delete" onclick="show_receipt_preview_popup()" data-toggle="modal" data-target="#myModal" class="btn btn-lg btn-default">
                  <span class="glyphicon glyphicon-eye-open"> Preview
                  </span>
                </a>

              </div>
            </div>
            </form>
            <?php } ?>
            <?php if(isset($user_privileges[1]) && $user_privileges[1]['r'] == 1){ ?>
            <form role="form" class="form-inline" id="search_form">
              <span class="search">Search by
              </span>
              <div class="form-group">
                <label for="name">Name:
                </label>
                <input id="text" type="text" onkeyup="get_record_by_name(this.value)" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="number">Number:
                </label>
                <input id="text" type="text" onkeyup="get_record_by_receipt_no(this.value)" class="form-control"/>
              </div>
              <div class="form-group">
                <label for="date">From date:
                </label>
                <input id="by_from_date" name="text" type="text" onkeyup="get_record_by_from_date(this.value)"placeholder="dd-mm-yyyy" class="form-control datepick" onkeypress="DateFormat(this,event.keyCode)"  />
              </div>
              <div class="form-group">
                <label for="date">To date:
                </label>
                <input id="by_to_date" type="text" onkeyup="get_record_by_to_date(this.value)" placeholder="dd-mm-yyyy" class="form-control datepick" onkeypress="DateFormat(this,event.keyCode)"/>
              </div>
            </form>
            <div class="table-responsive" >
              <table class="table table-bordered" >
                <thead>
                  <tr class="success">
                    <th>Receipt</th>
                    <th>Issue Date</th>
                    <th>Received From</th>
                    <th>Account Name</th>
                    <th>Amount</th>
                    <th>User</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                <tbody id="receipt_records">
                <?php
				 $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
				 if ($page <= 0) $page = 1;

				 $per_page = 10; // Set how many records do you want to display per page.

				 $startpoint = ($page * $per_page) - $per_page;

				 $statement = "tbl_receipts  r
				 			  left join tbl_users u
							  on u.id = r.updatedBy
							   ORDER BY r.id DESC"; // Change `records` according to your table name.

				 $data = mysqli_query($con,"SELECT r.*,u.username FROM {$statement} LIMIT {$startpoint} , {$per_page}");
				 //$sql = 'SELECT * from tbl_receipts';
				 //$data = mysqli_query($con, $sql);
				 while($rec = mysqli_fetch_object($data))
				 {
				?>
                      <tr>
                        <td><?php echo $rec->receipt_no;?></td>
                        <td><?php echo date('d M, Y', strtotime($rec->date));?></td>
                        <td><?php echo $rec->received_from;?></td>
                        <td><?php echo $rec->for_opt ;?></td>
                        <td>$<?php echo $rec->amount;?></td>
                        <td><?php echo substr($rec->username,0,15); if(strlen($rec->username) > 15) echo '...';?></td>
                        <?php if(isset($user_privileges[1]) && $user_privileges[1]['e'] == 1){ ?>
                            <td>
                              <a href="?id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit">
                              </a>
                            </td>
                            <td>
                            <?php if($rec->status == 1) { ?>
                              <a href="model/receipt_model.php?delid=<?php echo base64_encode($rec->id); ?>" onclick="return confirm('Are you sure, you want to delete this record ?');" class="glyphicon glyphicon-trash">
                              </a>
                             <?php } ?> 
                            </td>
                        <?php }else{ ?>
                            <td></td><td></td>
                        <?php } ?>
                      </tr>
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
            <div id="receipt_records_pagination">
            <?php
			 // displaying paginaiton.
			echo pagination($statement,$per_page,$page,$url='?', $con);
 			?>
            </div>
            <?php } ?>
           <?php /*?><nav class="pages">
              <ul class="pagination pagination-sm">
                <li class="disabled">
                  <a href="#" aria-label="Previous">
                    <span aria-hidden="true">«
                    </span>
                  </a>
                </li>
                <li class="active">
                  <a href="#">1
                    <span class="sr-only">(current)
                    </span>
                  </a>
                </li>
              </ul>
            </nav><?php */?>
          </div>
          <div id="prices" class="tab-pane <?php if(isset($_GET['section']) && $_GET['section'] == 'acc_list') echo 'active'; else echo 'fade'; ?>">
            <?php if(isset($user_privileges[1]) && $user_privileges[1]['r'] == 1){ ?>
            <form role="form" class="form-inline">
              <div class="form-group">
                <label for="text">Date:
                </label>
                <input id="account_data_date" type="text" placeholder="dd-mm-yyyy" onkeyup="get_account_data_date(this.value)" class="form-control" onkeypress="DateFormat(this,event.keyCode)"/>
              </div>
            </form>
            <div class="table-responsive">
              <table class="table table-bordered" id="myTable">
                <thead>
                  <tr class="success">
                    <th>Account No
                    </th>
                    <th>Account Name
                    </th>
                    <th>Date Created
                    </th>
                    <th>Account Type
                    </th>
                    <th>Amount
                    </th>
                    <th>Comments
                    </th>
                    <th>E
                    </th>
                    <th>Del
                    </th>
                  </tr>
                  <?php
					   // Edit...
					   if(isset($_GET['acc_id']))
					   {
						   $rec_id = base64_decode($_GET['acc_id']);
						   $check = mysqli_query($con, 'select * from tbl_account_list where id = '.$rec_id.'');
						   $check_data = @mysqli_fetch_object($check);
						   if(empty($check_data))
							   $_SESSION['error'] = 'ERROR ! Record not available.';
					   }
				  ?>
                  <?php if(isset($user_privileges[1]) && ($user_privileges[1]['w'] == 1 || ($user_privileges[1]['e'] == 1 && isset($_GET['acc_id'])))){ ?>
                  <tr class="active">
                    <form role="form" class="form-inline" action="model/accounts_model.php<?php if(!empty($check_data)) echo '?acc_id='.$_GET['acc_id'];?>" method="post" id="account_list_form">
                    <th>
                      <input type="text" name="acc_no" required="required"  placeholder="1000100" style="width:100px" class="insider" value="<?php echo isset($check_data->acc_no) ? $check_data->acc_no : ''; ?>"/>
                    </th>
                    <th>
                      <input type="text" name="acc_name" required placeholder="Licence renew" style="width:200px" class="insider" value="<?php echo isset($check_data->acc_name) ? $check_data->acc_name : ''; ?>"/>
                    </th>
                    <th>
                      <input type="text" name="date" placeholder="dd-mm-yy" class="insider" value="<?php echo isset($check_data->date) ? date('d-m-Y', strtotime($check_data->date)) : date('d-m-Y'); ?>"/>
                    </th>
                    <th>
                      <select size="1" style="width:120px" class="insider" required name="acc_type">
						<option value=""> Select Type... </option>
						<?php
                        $sql = 'SELECT * from tbl_acc_type';
                         $data = mysqli_query($con, $sql);
                         while($rec = mysqli_fetch_object($data))
                         {   //acc_no
                        ?>
                             <option value="<?php echo $rec->acc_type; ?>" <?php if(isset($check_data->acc_type) && $check_data->acc_type ==  $rec->acc_type) echo 'selected'; ?>><?php echo $rec->acc_type; ?></option>
                        <?php } ?>

                      </select>
                    </th>
                    <th>
                      <input type="text" placeholder="$50" name="amount" class="insider" value="<?php echo isset($check_data->amount) ? $check_data->amount : ''; ?>"/>
                    </th>
                    <th>
                      <input type="text" placeholder="Comment" name="comments" class="insider" value="<?php echo isset($check_data->comments) ? $check_data->comments : ''; ?>"/>
                    </th>
                    <th colspan="2">
                      <a href="javascript:void(0);" onclick="account_list()" class="glyphicon glyphicon-floppy-disk">
                      </a>
                      <input type="submit"  name="submit" value="submit" id="acc_form_sub_btn" style="display:none;"/>
                    </th>
                    </form>
                  </tr>
                  <?php } ?>
                </thead>
                <tbody id="account_list_records">
                <?php
				 $page = (int)(!isset($_GET["page"]) ? 1 : $_GET["page"]);
				 if ($page <= 0) $page = 1;

				 $per_page = 10; // Set how many records do you want to display per page.

				 $startpoint = ($page * $per_page) - $per_page;

				 $statement = "`tbl_account_list` ORDER BY `id` DESC"; // Change `records` according to your table name.

				 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
				 //$sql = 'SELECT * from tbl_receipts';
				 //$data = mysqli_query($con, $sql);
				 while($rec = mysqli_fetch_object($data))
				 {   //acc_no  acc_name date acc_type amount comments
				?>
                  <tr>
                        <td><?php echo $rec->acc_no;?></td>
                        <td><?php echo $rec->acc_name;?></td>
                        <td><?php echo date('d M, Y', strtotime($rec->date));?></td>
                        <td><?php echo $rec->acc_type;?></td>
                        <td>$<?php echo $rec->amount;?></td>
                        <td><?php echo substr($rec->comments,0,15); if(strlen($rec->comments) > 15) echo '...';?></td>
                        <?php if(isset($user_privileges[1]) && $user_privileges[1]['e'] == 1){ ?>
                        <td>
                          <a href="?section=acc_list&acc_id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit">
                          </a>
                        </td>
                        <td>
                          <a href="model/accounts_model.php?del_acc_id=<?php echo base64_encode($rec->id); ?>" onclick="return confirm('Are you sure, you want to delete this record ?');" class="glyphicon glyphicon-trash">
                          </a>
                        </td>
                        <?php }else{ ?>
                           <td></td><td></td>
                        <?php } ?>
                      </tr>
                <?php
				 }
				?>

                </tbody>
              </table>
            </div><br/>
            <style>
			.page_info { margin: 10px;}
			.current{
				color: #fff !important;
				cursor: default !important;
				background-color: #337ab7 !important;
				border-color: #337ab7 !important;
			 }
			</style>
            <div id="account_list_records_pagination">
            <?php
			 // displaying paginaiton.
			echo pagination($statement,$per_page,$page,$url='?section=acc_list&', $con);
 			?>
            </div>
            <?php /*?><nav class="pages">
              <ul class="pagination pagination-sm">
                <li class="disabled">
                  <a href="#" aria-label="Previous">
                    <span aria-hidden="true">«
                    </span>
                  </a>
                </li>
                <li class="active">
                  <a href="#">1
                    <span class="sr-only">(current)
                    </span>
                  </a>
                </li>
              </ul>
            </nav><?php */?>
            <div class="table-responsive">
              <table class="table table-bordered" >
                <thead>
                  <tr class="success">
                    <th>Account Type
                    </th>
                    <th>A-E
                    </th>
                    <th>Del
                    </th>
                  </tr>
                  <?php
					   // Edit...
					   if(isset($_GET['acc_t_id']))
					   {
						   $rec_id = base64_decode($_GET['acc_t_id']);
						   $check = mysqli_query($con, 'select * from tbl_acc_type where id = '.$rec_id.'');
						   $check_data = @mysqli_fetch_object($check);
						   if(empty($check_data))
							   $_SESSION['error'] = 'ERROR ! Record not available.';
					   }
				  ?>
                  <?php if(isset($user_privileges[1]) && ($user_privileges[1]['w'] == 1 || ($user_privileges[1]['e'] == 1 && isset($_GET['acc_t_id'])))) { ?>
                  <tr>
                    <form role="form" class="form-inline" action="model/accounts_model.php<?php if(!empty($check_data)) echo '?acc_t_id='.$_GET['acc_t_id'];?>" method="post" id="account_type_form">
                     <th>
                       <input type="text" name="acc_type_title" required="required" placeholder="Add account type" class="insider" value="<?php echo isset($check_data->acc_type) ? $check_data->acc_type : ''; ?>"/>
                        <input type="submit"  name="submit" value="submit" id="acc_type_form_sub_btn" style="display:none;"/>
                    </th>
                    </form>

                    <th colspan="2">
                      <a href="javascript:void(0);" onclick="account_type()" class="glyphicon glyphicon-floppy-disk">
                      </a>

                    </th>
                  </tr>
                  <?php } ?>
                </thead>
                <tbody id="acc_type_records">
                <?php
				 $page = 1;
				 $per_page = 10; // Set how many records do you want to display per page.
				 $startpoint = ($page * $per_page) - $per_page;
				 $statement = "`tbl_acc_type` ORDER BY `id` DESC"; // Change `records` according to your table name.
				 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
				 //$sql = 'SELECT * from tbl_acc_type';
				 //$data = mysqli_query($con, $sql);
				 while($rec = mysqli_fetch_object($data))
				 {   //acc_no  acc_name date acc_type amount comments
				?>
                  <tr>
                        <td><?php echo $rec->acc_type;?></td>
                        <?php if(isset($user_privileges[1]) && $user_privileges[1]['e'] == 1){ ?>
                        <td>
                          <a href="?section=acc_list&acc_t_id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit">
                          </a>
                        </td>
                        <td>
                          <a href="model/accounts_model.php?del_acc_t_id=<?php echo base64_encode($rec->id); ?>" onclick="return confirm('Are you sure, you want to delete this record ?');" class="glyphicon glyphicon-trash">
                          </a>
                        </td>
                        <?php }else{ ?>
                           <td></td><td></td>
                        <?php } ?>
                      </tr>
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
            <div id="pagination_area">
            <?php
			 // displaying paginaiton.
			 $pagination_data = array('current_statement' => $statement,
			 						  'per_page' => $per_page,
									  'current_page' => $page,
									  'db_con' => $con
									  );
			 $_SESSION['pagination_data'] = $pagination_data;
			echo ajax_pagination($statement,$per_page,$page,$url='call_pagination', $con);
 			?>
            </div>
            <?php } ?>
						<!--
            <hr/>
            <?php if(isset($logged_in_user->id) && $logged_in_user->id == 1){ ?>
             <div class="upload-csv">
							<h4> Upload .csv file to database </h4>
								<form class="upload" method="post" action="model/upload_csv.php" id="csv_upload_form" enctype="multipart/form-data">
                  <label for="csv_file_field" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Select .csv</span></label>
                  <input id="csv_file_field" type="file" name="csv_file_for_receipts"  required class="form-control inputfile" style="padding: 0px;" />
                  <a href="javascript:void(0);" onClick="upload_csv()" class="btn btn-lg btn-default">
                    <span class="glyphicon glyphicon-upload"> Upload .csv</span>
                  </a>
								</form>
						</div>
            <?php } ?>
            <script>
			function upload_csv()
			{
				if($('#csv_file_field').val() == ''){
					$('#csv_file_field').focus();
				}
				else
					$('#csv_upload_form').submit();
			}

		</script> -->
            <?php /*?><nav class="pages">
              <ul class="pagination pagination-sm">
                <li class="disabled">
                  <a href="#" aria-label="Previous">
                    <span aria-hidden="true">«
                    </span>
                  </a>
                </li>
                <li class="active">
                  <a href="#">1
                    <span class="sr-only">(current)
                    </span>
                  </a>
                </li>
              </ul>
            </nav><?php */?>
          </div>
              <div style="display:none;width:900px;" id="tab">
                <h2> <center>Receipt Voucher </center></h2>
                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <div style="width:30%;float:left;font-weight:bold;" id="p_r_receipt_no_1">  Receipt No : 098786</div>
                    <div style="width:30%;float:left;font-weight:bold;margin-left:10%;" id="p_r_date_1"> <b> Date: 08/04/2015</b></div>
                    <div style="width:20%;float:left;font-weight:bold;" id="p_r_time_1"> <b> Time: 14:41</b></div>
                </div>
                <div style="padding-left:20px;margin-top:30px;">
                    <table style="width:100%;">
                        <tr style="height:30px;">
                           <th style="font-weight:bold; width:150px;text-align:left;">Received from:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_received_from_1"></div></td>
                        </tr>
                        <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">Amount of :</th>
                           <td style="" colspan="2"><div style="width:80px;border-bottom:1px solid black;height:30px;float:left;" id="p_r_amount_1"> </div>  (<span id="p_r_amount_word_1"></span>)</td>
                        </tr>
                        <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">For: </th>
                           <td > <div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_for_1">New license</div> </td>
                        </tr>
                        <tr style="min-height:30px; height:auto;">
                           <th style="font-weight:bold;text-align:left;" valign="top">User:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;min-height:30px;" id="p_r_comment_1"></div></td>
                        </tr>
                         <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">Accountant:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_accountant_1">Abdullatif</div></td>
                           <td style="text-decoration:underline;padding-top:10px;"><span style="float:right;text-decoration:underline;"><b>Signature</b></span></td>
                        </tr>

                     </table>
                </div>
                <div style="border-bottom:1px dotted #333;height:10px;margin:20px 0px;"></div>
                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <div style="width:30%;float:left;font-weight:bold;" id="p_r_receipt_no_2">  Receipt No : 098786</div>
                    <div style="width:30%;float:left;font-weight:bold;margin-left:10%;" id="p_r_date_2"> <b> Date: 08/04/2015</b></div>
                    <div style="width:20%;float:left;font-weight:bold;" id="p_r_time_2"> <b> Time: 14:41</b></div>
                </div>
                <div style="padding-left:20px;margin-top:30px;">
                    <table style="width:100%;">
                        <tr style="height:30px;">
                           <th style="font-weight:bold; width:150px;text-align:left;">Received from:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_received_from_2"></div></td>
                        </tr>
                        <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">Amount of :</th>
                           <td style="" colspan="2"><div style="width:80px;border-bottom:1px solid black;height:30px;float:left;" id="p_r_amount_2"> </div>  (<span id="p_r_amount_word_2"></span>)</td>
                        </tr>
                        <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">For: </th>
                           <td > <div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_for_2">New license</div> </td>
                        </tr>
                        <tr style="min-height:30px; height:auto;">
                           <th style="font-weight:bold;text-align:left;" valign="top">User:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;min-height:30px;" id="p_r_comment_2"></div></td>
                        </tr>
                         <tr style="height:30px;">
                           <th style="font-weight:bold;text-align:left;">Accountant:</th>
                           <td ><div style="width:200px;border-bottom:1px solid black;height:30px;" id="p_r_accountant_2">Abdullatif</div></td>
                           <td style="text-decoration:underline;padding-top:10px;"><span style="float:right;text-decoration:underline;"><b>Signature</b></span></td>
                        </tr>

                     </table>
                </div>
              </div>

        </div>
      </div>
      <!-- -------------------------- -->

      <!-- -------------------------- -->
 <?php /* ###############
         Footer
	  */
	  include_once('inc/footer.php');
?>
