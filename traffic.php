<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];
	  // 
	  if(isset($_REQUEST['fine_id']) && $_REQUEST['fine_id'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_traffic_fines where id = '".base64_decode(mysqli_real_escape_string($con, $_REQUEST['fine_id']))."' ");
			$search_result = mysqli_fetch_object($data);
			if(empty($search_result))
			    $_SESSION['error'] = 'ERROR !  Record not available.';
			
	   } 
	   else if(isset($_REQUEST['fine_master_id']) && $_REQUEST['fine_master_id'] != '')
	   {
			$data = mysqli_query($con,"SELECT * FROM tbl_fine_master where id = '".base64_decode(mysqli_real_escape_string($con, $_REQUEST['fine_master_id']))."' ");
			$search_result_m = mysqli_fetch_object($data);
			if(empty($search_result_m))
			    $_SESSION['error'] = 'ERROR !  Record not available.';
			$_SESSION['fine_section'] = 'master';	
			
	   }
	   else if(isset($_REQUEST['fine_payment_id']) && $_REQUEST['fine_payment_id'] != '')
	   {
			$data = mysqli_query($con,"SELECT t_fine.*, fm.amount FROM 
							 			tbl_traffic_fines as t_fine
										inner join tbl_fine_master as fm
										on fm.fine_code = t_fine.fine_code where t_fine.id = '".base64_decode(mysqli_real_escape_string($con, $_REQUEST['fine_payment_id']))."' ");
			$search_result_p = mysqli_fetch_object($data);
			if(empty($search_result_p))
			    $_SESSION['error'] = 'ERROR !  Record not available.';
			$_SESSION['fine_section'] = 'payment';	
			
	   }
?>
<style>
.page_info { margin: 10px;}
.current{
	color: #fff !important;
	cursor: default !important;
	background-color: #337ab7 !important;
	border-color: #337ab7 !important;
 }
</style>
        <div class="right-nav">
        	<ul class="nav nav-tabs">
            	<li <?php if(!isset($_SESSION['fine_section']) ){ ?>class="active"<?php } ?>><a data-toggle="tab" href="#details">Fine Details</a></li>
                <li <?php if(isset($_SESSION['fine_section']) && $_SESSION['fine_section'] == 'master'){ ?>class="active"<?php } ?>><a data-toggle="tab" href="#master">Fines Master</a></li>
                <li <?php if(isset($_SESSION['fine_section']) && $_SESSION['fine_section'] == 'payment'){ ?>class="active"<?php } ?>><a data-toggle="tab" href="#pay">Pay Fines</a></li>
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
            	<div id="details" class="tab-pane  <?php if(!isset($_SESSION['fine_section']) ) echo 'fade in active'; else echo 'fade'; ?>">
                    <?php if(isset($user_privileges[7]) && ($user_privileges[7]['w'] == 1 || $user_privileges[7]['e'] == 1 )){ ?>        
                    <form  method="post" action="model/fine_model.php<?php if(!empty($search_result)) echo '?id='.$_GET['fine_id'];?>" >
                        <div class="form-inline">
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Fine Number:</label>
                        <input id="text-short" type="text" name="fine_number" value="<?php echo isset($search_result->fine_no) ? $search_result->fine_no : '' ;?>" required="required" class="form-control"/>
                        </div>
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Date of Issue:</label>
                        <input id="issue_date" type="text" name="issue_date" value="<?php echo isset($search_result->issue_date) ? $search_result->issue_date : '' ;?>" required placeholder="dd-mm-yyyy" class="form-control" onkeypress="DateFormat(this,event.keyCode)" />
                        </div>
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4 cus-lab">Time:</label>
                        <input id="text-short" type="text" name="time" placeholder="H:m" value="<?php echo isset($search_result->time) ? $search_result->time : '' ;?>" class="form-control"/>
                        </div>   ,
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Place of Issue:</label>
                        <!--<input id="text-middle" type="text" name="issue_place" value="<?php echo isset($search_result->issue_place) ? $search_result->issue_place : 'Mogadishu' ;?>" class="form-control"/>-->
                        <select id="text-middle" size="1" name="issue_place" placeholder="Place">
                            <option value="<?php echo $ArIssuePlace[0]?>" <?php if(isset($search_result->issue_place) && $search_result->issue_place == $ArIssuePlace[0]) echo 'selected'; ?>><?php echo $ArIssuePlace[0]?></option>
                         </select>  
                        </div>
                        </div>              
                        <div class="form-inline">
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Fine Code:</label>
                        <?php $fine_master = mysqli_query($con, 'select * from tbl_fine_master'); ?>
                            <select id="text-middle" size="1" name="fine_code">
                              <?php /*?> <option  value="">Select fine code</option>
                               <option disabled="disabled" value="">Fine Code &nbsp;&nbsp;- &nbsp; Detail&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - &nbsp;&nbsp;Amount&nbsp;&nbsp;</option><?php */?>
                               <?php while($row = @mysqli_fetch_object($fine_master)) { ?>
                                    <option value="<?php echo $row->fine_code; ?>" <?php if(isset($search_result->fine_code) && $search_result->fine_code == $row->fine_code) echo 'selected'; ?>><?php echo $row->fine_code.' - '.$row->comments.' - &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$'.$row->amount; ?></option>
                               <?php } ?>     
                            </select>   
                        </div>
                        <div class="form-group">
                        <label for="text" class="control-label2 col-sm-4 cus-lab2">Fine Type:</label>
                        <select id="text-short" size="1" name="fine_type">
                        	<option value="Present" value="<?php echo isset($search_result->fine_type) ? $search_result->fine_type : '' ;?>">Present</option>
                            <option value="Away">Away</option>
                        </select>
                        </div>
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4 cus-lab3">Plate No:</label>
                        <input id="text-short" type="text" name="plate_no" value="<?php echo isset($search_result->plate_no) ? $search_result->plate_no : '' ;?>" required class="form-control"/>
                        </div>
                        <div class="form-group">
                        <label for="date" class="control-label2 col-sm-4">Registration:</label>
                        <input id="text-middle" type="text" name="registration" value="<?php echo isset($search_result->registration) ? $search_result->registration : '' ;?>" class="form-control"/>
                        </div>
                        </div>
                        <div class="separator-div">
                            <div class="form-left-side">
                            <div class="form-horizontal">
                            <div class="form-group"><label for="text" class="control-label col-sm-4">Driver Name:</label>
                            <div class="col-sm-8"><input id="text" type="text" name="driver_name" value="<?php echo isset($search_result->driver_name) ? $search_result->driver_name : '' ;?>" class="form-control"/></div>
                            </div>
                            <div class="form-group"><label for="text" class="control-label col-sm-4">Licence No:</label> 
                            <div class="col-sm-8"><input id="text" type="text" name="licence_no" required value="<?php echo isset($search_result->licence_no) ? $search_result->licence_no : '' ;?>" class="form-control"/></div>
                            </div>
                            <div class="form-group"><label for="text" class="control-label col-sm-4">Comments:</label>
                            <div class="col-sm-8"><input id="text" type="text" name="comments" value="<?php echo isset($search_result->licence_no) ? ($search_result->status == 2 ? 'Paid' : '') : '' ;?>" class="form-control"/></div>
                            </div>  
                            </div>
                            </div>
                            <div class="form-right-side">
                            <a href="javascript:void(0);" onclick="submit_fine_form()" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Save</span></a>
                            <input type="submit" value="sub" id="fine_form_sub_btn" style="display:none;"  />
                            <input type="hidden" name="add_fine_form" value="1" />
                            </div>
                        </div>
                    </form>
                    <?php } ?>
                    <script>
					
					function submit_fine_form()
					{
						$('#fine_form_sub_btn').trigger('click');
					}
					</script>
                   <?php if(isset($user_privileges[7]) && ($user_privileges[7]['r'] == 1 )){ ?>        
                    <span class="search2">Search by</span>
                    <form role="form" class="form-inline">
                    <div class="form-group"><label for="text">Fine No:</label>
                    <input id="text-short" type="text" onkeyup="get_fine_data_by_fine_no(this.value);" class="form-control"/></div>
                    <div class="form-group">
                    <label for="number">Plate No:</label>
                    <input id="text-short" onkeyup="get_fine_data_by_plate_no(this.value);" type="text" class="form-control"/>
                    </div>
                    <div class="form-group">
                    <label for="number">Licence No:</label>
                    <input id="text-short"  onkeyup="get_fine_data_by_licence_no(this.value);" type="text" class="form-control"/></div>
                    </form>
                    <div class="table-responsive">
                    <table class="table table-bordered">
                    <thead>
                    	<tr class="success">
                        	<th>Fine No</th>
                            <th>Code</th>
                            <th>Date</th>
                            <th>Place of Issue</th>
                            <th>Fine Type</th>
                            <th>Plate No</th>
                            <th>Registration</th>
                            <th>Licence No</th>
                            <th>Driver Name</th>
                            <th>Comments</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody id="fine_records_area">
                    <?php
					 $page = 1;
					 $per_page = 10; // Set how many records do you want to display per page.
					 $startpoint = ($page * $per_page) - $per_page;
					 $statement = "`tbl_traffic_fines` ORDER BY `id` DESC"; // Change `records` according to your table name.
					 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
					 //echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}"; exit;
					 //$data = mysqli_query($con, $sql);
					 if(mysqli_num_rows($data) > 0)
					 {
					 while($rec = mysqli_fetch_object($data))
					 {   //fine_no, issue_date,  time, issue_place, fine_code,  fine_type, plate_no, registration, driver_name, licence_no,
					?>
					    <tr>
                        	<td><?php echo $rec->fine_no;?></td>
                            <td><?php echo $rec->fine_code;?></td>
                            <td><?php echo date('d-m-Y', strtotime($rec->issue_date));?></td>
                            <td><?php echo $rec->issue_place;?></td>
                            <td><?php echo $rec->fine_type;?></td>
                            <td><?php echo $rec->plate_no;?></td>
                            <td><?php echo $rec->registration;?></td>
                            <td><?php echo $rec->licence_no;?></td>
                            <td><?php echo $rec->driver_name;?></td>
                            <td><?php echo $rec->status == 2 ? 'Paid' : '';?></td>
                            <td><a href="?fine_id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit">  </a></td>
                        </tr>
                      
					<?php
					  }
					 }else{
					?>  
                        <tr><td colspan="11" style="color:red;">No record found</td></tr>
                    <?php } ?>    
                    	
                    </tbody>
                </table>
                   <?php } ?>
            </div>
            <?php if(isset($user_privileges[7]) && ($user_privileges[7]['r'] == 1 )){ ?> 
            <div id="pagination_area">
            <?php
			 // displaying paginaiton.
			$_SESSION['current_statement'] = $statement;
			echo ajax_pagination($statement,$per_page,$page,$url='fine_pagination', $con);
 			?>
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

			</script>
        </div>
        <?php if(isset($user_privileges[7]) && ($user_privileges[7]['r'] == 1 )){ ?>  
           <div id="master" class="tab-pane <?php if(isset($_SESSION['fine_section']) && $_SESSION['fine_section'] == 'master') echo 'fade in active'; else echo 'fade'; ?>">
           	<div class="table-responsive">
            	<table class="table table-bordered">
                	<thead>
                    	<tr class="success">
                        	<th style="width:80px">Code</th>
                            <th style="width:400px">Fine Details   </th>
                            <th style="width:50px">Amount</th>
                            <th style="width:100px">Black Points</th>
                            <th style="width:50px">Prison</th>
                            <th style="width:200px">Vehicle Confiscation Period</th>
                            <th colspan="2"></th>
                        </tr>
                       	<tr class="active">
                          <form method="post" action="model/fine_model.php<?php if(!empty($search_result_m)) echo '?fine_master_id='.$_GET['fine_master_id'];?>">	
                            <th><input type="text" name="m_code" required="required" value="<?php echo isset($search_result_m->fine_code) ? $search_result_m->fine_code : '' ;?>" class="insider"/></th>
                            <th><input type="text" name="m_detail" required value="<?php echo isset($search_result_m->comments) ? $search_result_m->comments : '' ;?>" class="insider"/></th>
                            <th><input type="text"  name="m_amount" required  value="<?php echo isset($search_result_m->amount) ? $search_result_m->amount : '' ;?>" class="insider"/></th>
                            <th><input type="text" name="m_black_point" value="<?php echo isset($search_result_m->black_point) ? $search_result_m->black_point : '' ;?>" class="insider"/></th>
                            <th><input type="text" name="m_prison" value="<?php echo isset($search_result_m->prison) ? $search_result_m->prison : '' ;?>" class="insider"/></th>
                            <th><input type="text" name="m_vc_period" value="<?php echo isset($search_result_m->vehicle_confiscation) ? $search_result_m->vehicle_confiscation : '' ;?>" class="insider"/></th>
                            <th colspan="2"><a href="javascript:void(0)" onclick="submit_m_form()" class="glyphicon glyphicon-floppy-disk"></a>
                            	<input type="submit" id="m_form_sub"  style="display:none;"/>
                                <input type="hidden" name="m_add_form" value="1" />
                            </th>
                          </form>  
                        </tr>
                        
                   </thead>
                   <tbody id="master_fine_records_area">
                   		<?php
						 $page = 1;
						 $per_page = 10; // Set how many records do you want to display per page.
						 $startpoint = ($page * $per_page) - $per_page;
						 $statement = "`tbl_fine_master` where status = 2 ORDER BY `id` DESC"; // Change `records` according to your table name.
						 $data = mysqli_query($con,"SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}");
						 //echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}"; exit;
						 //$data = mysqli_query($con, $sql);
						 if(mysqli_num_rows($data) > 0)
						 {
						 while($rec = mysqli_fetch_object($data))
						 {   //fine_no, issue_date,  time, issue_place, fine_code,  fine_type, plate_no, registration, driver_name, licence_no,
						?>    
							<tr>
								<td><?php echo $rec->fine_code;?></td>
                                <td><?php echo ($rec->comments);?></td>
                                <td>$<?php echo $rec->amount;?></td>
								<td><?php echo $rec->black_point;?></td>
								<td><?php echo $rec->prison;?></td>
								<td><?php echo $rec->vehicle_confiscation;?></td>
								<td><a href="?fine_master_id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-check">  </a></td>
                                <td><a href="model/fine_model.php?delid=<?php echo base64_encode($rec->id); ?>" onclick="return confirm('Are you sure to delete?');"  class="glyphicon glyphicon-trash"></a></td>
							</tr>
						  
						<?php
						  }
						 }else{
						?>  
							<tr><td colspan="11" style="color:red;">No record found</td></tr>
						<?php } ?> 
                        
                   </tbody>
               </table>
           </div>
           <script>
			function submit_m_form()
			{
				$('#m_form_sub').trigger('click');
			}
			</script>
           <div id="master_pagination_area">
            <?php
			 // displaying paginaiton.
			$_SESSION['current_statement'] = $statement;
			echo ajax_pagination($statement,$per_page,$page,$url='fine_master_pagination', $con);
 			?>
            </div>
            <!--<div class="upload-csv">
                <h4> Upload .csv file to database </h4>
                <form class="upload" method="post" action="model/upload_csv_data.php" id="csv_upload_form" enctype="multipart/form-data">
                  <label for="csv_file_field" class="btn btn-lg btn-default"><span class="glyphicon glyphicon-plus"> Select .csv</span></label>
                  <input id="csv_file_field" type="file" name="csv_file_for_master_fine"  required class="form-control inputfile" style="padding: 0px;" />
                  <a href="javascript:void(0);" onClick="upload_csv()" class="btn btn-lg btn-default">
                    <span class="glyphicon glyphicon-upload"> Upload .csv</span>
                  </a>
                </form>
            </div>-->
       </div>
        
             <div id="pay" class="tab-pane fade <?php if(isset($_SESSION['fine_section']) && $_SESSION['fine_section'] == 'payment') echo ' in active'; else echo 'fade'; ?>">
                <div class="search-border">Search by</div>
                    <form role="form" class="form-inline">
                        <div class="form-group">
                        <label for="text">Plate No:</label>
                        <input id="text" type="text" class="form-control" onkeyup="get_fine_pay_data_by_plate_no(this.value);"/>
                        </div>
                        <div class="form-group">
                        <label for="number">Licence No:</label>
                        <input id="text" type="text" class="form-control" onkeyup="get_fine_pay_data_by_licence_no(this.value);"/>
                        </div>
                        <div class="form-group">
                        <label for="number">FIne Number:</label>
                        <input id="text" type="text" class="form-control" onkeyup="get_fine_pay_data_by_fine_no(this.value);"/>
                        </div>
                        </form>
                        <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr class="success">
                                    <th>Sr</th>
                                    <th style="width:110px">Date</th>
                                    <th>Fine Code</th>
                                    <th>Fine Number</th>
                                    <th>Plate No</th>
                                    <th>Plase of issue</th>
                                    <th>Amount</th>
                                    <th>Payment Date</th>
                                    <th>Receipt No</th>
                                    <th>PR</th>
                                </tr>
                                <tr>
                                 <?php if(isset($user_privileges[7]) && ($user_privileges[7]['w'] == 1 || $user_privileges[7]['e'] == 1 )){ ?>
                                  <form method="post" action="model/fine_model.php<?php if(!empty($search_result_p)) echo '?fine_payment_id='.$_GET['fine_payment_id'];?>">	
                                    <td>#</td>
                                    <td><?php echo isset($search_result_p->issue_date) ? date('d-m-Y', strtotime($search_result_p->issue_date)) : '' ;?></td>
                                    <td><?php echo isset($search_result_p->fine_code) ? $search_result_p->fine_code : '' ;?></td>
                                    <td><?php echo isset($search_result_p->fine_no) ? $search_result_p->fine_no : '' ;?></td>
                                    <td><?php echo isset($search_result_p->plate_no) ? $search_result_p->plate_no : '' ;?></td>
                                    <td><?php echo isset($search_result_p->issue_place) ? $search_result_p->issue_place : '' ;?></td>
                                    <td><?php echo isset($search_result_p->amount) ? $search_result_p->amount : '' ;?></td>
                                    <td class="active"><input type="text" style="width:85px" name="fp_payment_date" class="insider"/></td>
                                    <td class="active"><input type="text" style="width:55px" name="fp_receipt_no" class="insider receipt_no"/></td>
                                    <td><a href="javascript:void(0);" onclick="submit_fine_payment_form()" class="fa fa-save"></a>
                                        <input type="submit" id="fp_sub_btn" style="display:none;" />
                                    </td>
                                  </form>  
                                 <?php } ?>  
                                </tr>
                            </thead> 
                            <tbody id="fine_pay_detail_area">
                               
                                
                                <?php
                                 $is_data = 0;
                                 $page = 1;
                                 $per_page = 10; // Set how many records do you want to display per page.
                                 $startpoint = ($page * $per_page) - $per_page;
                                 
                                 $statement = "  tbl_traffic_fines as t_fine
                                                            inner join tbl_fine_master as fm
                                                            on fm.fine_code = t_fine.fine_code
                                                            where t_fine.status = 1 ORDER BY t_fine.id DESC"; // Change `records` according to your table name.
                                 $data = mysqli_query($con,"SELECT t_fine.*, fm.amount FROM  {$statement} LIMIT {$startpoint} , {$per_page}");
                                 //echo "SELECT * FROM {$statement} LIMIT {$startpoint} , {$per_page}"; exit;
                                 //$data = mysqli_query($con, $sql);
                                 if(mysqli_num_rows($data) > 0)
                                 {
                                     $counter = 1;
                                     $is_data = 1;
                                 while($rec = mysqli_fetch_object($data))
                                 {   //fine_no, issue_date,  time, issue_place, fine_code,  fine_type, plate_no, registration, driver_name, licence_no,
                                ?>
                                    <tr>
                                        <td><?php echo $counter; ?></td>
                                        <td><?php echo date('d-m-Y', strtotime($rec->issue_date));?></td>
                                        <td><?php echo $rec->fine_code;?></td>
                                        <td><?php echo $rec->fine_no;?></td>
                                        <td><?php echo $rec->plate_no;?></td>
                                        <td><?php echo $rec->issue_place;?></td>
                                        <td>$<?php echo $rec->amount;?></td>
                                        <td></td>
                                        <td></td>
                                        <td><a href="?fine_payment_id=<?php echo base64_encode($rec->id); ?>" class="glyphicon glyphicon-edit">  </a></td>
                                    </tr>
                                  
                                <?php  $counter++;
                                  }
                                 }else{
                                ?>  
                                    <tr><td colspan="11" style="color:red;">No record found</td></tr>
                                <?php } ?> 
                                
                            </tbody>
                      </table>
                      <script>
                      function submit_fine_payment_form()
                      { 
                        if($('.receipt_no').val() != '')
                        {
                            $.ajax({
                                url:"model/fine_model.php",
                                type:'POST',
                                data:'action=validate_receipt_no&receipt_no='+$('.receipt_no').val(),
                                beforeSend: function(){
                                    
                                },
                                success:function(result){  
                                    if(result == 'yes')
                                    {
                                        $('#show_error_msg').show().text('ERROR !  Receipt number already used.');
                                        $('.receipt_no').focus();
                                    }
                                    else if(result == 'no')
                                    {
                                        $('#fp_sub_btn').trigger('click');
                                    }
                                }
                            });
                        }
                        else
                           $('.receipt_no').focus();
                        
                      }
                      
                      </script>
                  </div>
                  <div id="fine_pay_pagination_area">
                    <?php
                    if($is_data == 1)
                    {
                         // displaying paginaiton.
                        $_SESSION['current_statement_finepay'] = $statement;
                        echo ajax_pagination($statement,$per_page,$page,$url='fine_pay_pagination', $con);
                    }
                    ?>
                  </div>
              </div>
        <?php } ?>      
        </div>
       </div>
        
<?php /* ###############
         Footer
	  */
	  unset($_SESSION['fine_section']);
	  include_once('inc/footer.php');
?>        
<script>   
$(function() {
	$( "#issue_date" ).datepicker({
		yearRange: '0:+20',
		minDate: 'today',
		//maxDate: 'today',
		dateFormat: 'dd-mm-yy',	
		changeMonth: true,
		changeYear: true, 			
		showOn: "both",
		/*onSelect: function(dates) {showOnFocus: true, Change_expire_date(this.value) },*/
		buttonImage: 'assets/calendar/calimg.png',
		buttonImageOnly: true });
		
});
 </script>
