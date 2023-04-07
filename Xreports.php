<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');

?>

<!--   <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
   <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>-->
   
   <div class="right-nav">
      	<ul class="nav nav-tabs">
        	<li class="active"><a data-toggle="tab" href="#reports-stat">Reports</a></li>
					<li><a data-toggle="tab" href="#statistics">Statistics</a></li>
                    <li style="float: right;"><div class="alert alert-danger" id="show_error_msg" style="display:none;padding:2px;margin-top:2px;padding-left:15px;margin-bottom:0px;"></div></li>
        </ul>

      <div class="tab-content">
       <?php if(isset($user_privileges[4]) && $user_privileges[4]['r'] == 1){ ?>
      	<div id="reports-stat" class="tab-pane fade in active">
        	<form role="form" class="form-inline mar1" >
            	<div class="form-group">
                	<label for="name">From date:</label>
                    <input  name="from" type="text" id="datepicker"  onkeyup="get_reports_by_date(this.value)" class="form-control from_date datepick" onkeypress="DateFormat(this,event.keyCode)" placeholder="dd-mm-yyyy" value="<?php //echo date('d-m-Y', strtotime('-3 Month')); ?>" />

								</div>
                <div class="form-group">
                	<label for="number">To date:</label>
                    <input name="to" type="text" id="datepicker2" onkeyup="get_reports_to_date(this.value)" class="form-control to_date datepick1" onkeypress="DateFormat(this,event.keyCode)"placeholder="dd-mm-yyyy" value="<?php //echo date('d-m-Y'); ?>"/>
                </div>
            	<div class="form-group">
                	<label for="number">Vehicle Plate:</label>
                    <input id="text-short" type="text" onkeyup="get_reports_vehicle_plate(this.value)" class="form-control vehicle_no"/>
                </div>
                <div class="form-group" style="margin-right: 0px;float: right; margin-top: -13px;">
                    <button  style="margin-left: 142px;" class="btn btn-lg btn-default" onclick=" return Submit_reports_form()"> Get Reports </button>
                </div>

           </form>
           <script>
				   function Submit_reports_form()
				   {
				       s_report_from_date = $('.from_date').val();
					   s_report_to_date = $('.to_date').val();
					   get_reports_records();
					   return false;
				   }
				   $(function() {
					$( "#datepicker" ).datepicker({
						dateFormat: 'dd-mm-yy',
					  	changeMonth: true,
						changeYear: true,
						showOn: "both",
						buttonImage: 'assets/calendar/calimg.png',
						buttonImageOnly: true
					});
					$( "#datepicker2" ).datepicker({
						dateFormat: 'dd-mm-yy',
						changeMonth: true,
						changeYear: true,
						showOn: "both",
						buttonImage: 'assets/calendar/calimg.png',
						buttonImageOnly: true });
				  });
				 </script>
           <div class="table-responsive">
           	    <table class="table table-bordered">
                	<thead>
                    	<tr class="success">
                        	<th>Report Name</th>
                            <th>Report Details</th>
                            <th>Comments</th>
                            <th>Print</th>
                        </tr>
                   </thead>
                    <tbody>
                   	    <!--<tr>
                        	<td>Daily cash receipts</td>
                            <td>Periodic cash receipts report</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="daily_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#daily_report_tab')"></a></td>
                        </tr>-->
                        <!--<tr>
                        	<td>Receipts by day report</td>
                            <td>Receipts reports by day</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="daily_report_by_day_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#daily_report_by_day_tab')"></a></td>
                        </tr>-->
                        <!--<tr>
                        	<td>Monthly receipts summary report</td>
                            <td>Summary report by months</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="monthly_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#monthly_report_tab')"></a></td>
                        </tr>-->
                        <?php /*?><tr>
                            <td>Yearly receipts summary report</td>
                            <td>Summary report by years</td>
                            <td></td>
                            <td><a href="javascript:void(0);" class="glyphicon glyphicon-print" onclick="PrintReports('#yealy_report_tab')"></a></td>
                        </tr><?php */?>
                        <!--<tr>
                            <td>License summary report</td>
                            <td>Summary report of License</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="licence_summry_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#licence_summary_report_tab')"></a></td>
                        </tr>
                        <tr>
                            <td>License detailed report</td>
                            <td>Summary report of License</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="licence_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#licence_detail_tab')"></a></td>
                        </tr>

                        <tr>
                            <td>Vehicles receipts summary report</td>
                            <td>Vehicles receipts Summary report</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="vehicle_sum_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#vehicle_summary_report_tab')"></a></td>
                        </tr>
                        <tr>
                            <td>Vehicles receipts detailed report</td>
                            <td>Detail report of Vehicles</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="vehicle_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#vehicle_detail_tab')"></a></td>
                        </tr>
                        <tr>
                            <td>Moto receipts summary report</td>
                            <td>Moto receipts Summary report</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="moto_sum_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#moto_summary_report_tab')"></a></td>
                        </tr>
                        <tr>
                            <td>Moto receipts detailed report</td>
                            <td>Detail report of Moto</td>
                            <td></td>
                            <td><a href="javascript:void(0);" style="display:none;" id="moto_report_print_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#moto_detail_tab')"></a></td>
                        </tr>-->
                        <tr></tr>
                        <tr>
                            <td>Receipts details with account names</td>
                            <td>Receipts details with account names</td>
                            <td></td>
                            <td ><span id="receipt_details_account_names_loading_msg" style="display:none;"> Wait...</span><a href="javascript:void(0);" style="display:none;" id="receipt_details_account_names_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_detail_with_account_name')"></a></td>
                        </tr>
                        <tr>
                            <td>Receipts grouped by account names</td>
                            <td>Receipts grouped by account names</td>
                            <td></td>
                            <td>
							    <span id="receipt_details_group_account_names_loading_msg" style="display:none;"> Wait...</span>
							    <a href="javascript:void(0);" style="display:none;" id="receipt_details_group_account_names_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_detail_grouped_account_name')"></a></td>
                        </tr>
                        <tr>
                            <td>Receipts summary by account names</td>
                            <td>Receipts summary by account names</td>
                            <td></td>
                            <td>
							    <span id="receipt_details_summry_account_names_loading_msg" style="display:none;"> Wait...</span>
								<a href="javascript:void(0);" style="display:none;" id="receipt_details_summry_account_names_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_details_summry_account_names')"></a></td>
                        </tr>
                        <tr>
                            <td>Receipts Summary by each day</td>
                            <td>Receipts Summary by each day</td>
                            <td></td>
                            <td>
							    <span id="receipt_summary_day_loading_msg" style="display:none;"> Wait...</span>
							    <a href="javascript:void(0);" style="display:none;" id="receipt_summary_day_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_summary_day')"></a></td>
                        </tr>
                        <tr>
                            <td>Receipts Summary by Main accounts</td>
                            <td>Receipts Summary by Main accounts</td>
                            <td></td>
                            <td>
							   <span id="receipt_summary_main_accounts_loading_msg" style="display:none;"> Wait...</span>
							   <a href="javascript:void(0);" style="display:none;" id="receipt_summary_main_accounts_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_summary_main_accounts')"></a></td>
                        </tr>
                        <tr>
                        	<td>Receipts summary by months</td>
                            <td>Receipts summary by months</td>
                            <td></td>
                            <td>
								<span id="receipt_report_summary_month_loading_msg" style="display:none;"> Wait...</span>
								<a href="javascript:void(0);" style="display:none;" id="receipt_report_summary_month_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_report_summary_month')"></a></td>
                        </tr>
                        <tr>
                        	<td>Receipts summary by main accounts and subaccounts</td>
                            <td>Receipts summary by main accounts and subaccounts</td>
                            <td></td>
                            <td>
								<span id="receipt_summary_main_sub_accounts_loading_msg" style="display:none;"> Wait...</span>
								<a href="javascript:void(0);" style="display:none;" id="receipt_summary_main_sub_accounts_icon" class="glyphicon glyphicon-print" onclick="PrintReports('#receipt_summary_main_sub_accounts')"></a></td>
                        </tr>
                       <?php /*?> <tr>
                            <td>Vehicle tax history report</td>
                            <td>Periodic tax payment report</td>
                            <td></td>
                        	<td><a href="javascript:void(0);" class="glyphicon glyphicon-print" onclick="PrintReports('#vehicle_tax_report_tab')"></a></td>
                        </tr>
                        <tr>
                            <td>Road tax contracts not renewed report</td>
                            <td>Periodic Road tax contracts not renewed report</td>
                            <td></td>
                        	<td><a href="javascript:void(0);" class="glyphicon glyphicon-print" onclick="PrintReports('#road_tax_report_tab')"></a>
                            <!--<a href="javascript:void(0);"  id="print_road_tax" onclick="PrintReports('#road_tax_report_tab')"></a>-->
                            </td>
                        </tr><?php */?>
                    </tbody>
                </table>
           </div>
           <script>  // PrintReports('#road_tax_report_tab')
		   function print_road_t()
		   {
			   if(vehicle_plate == '')
			   	   window.location = '?p=road_tax_report&from_date='+s_report_from_date+'&to_date='+s_report_to_date;
			   else
			       window.location = '?p=road_tax_report&from_date='+s_report_from_date+'&to_date='+s_report_to_date+'&vehicle_no='+vehicle_plate;
		   }

		   </script>
           <!--<nav><ul class="pagination pagination-sm"><li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">«</span></a></li><li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li></ul></nav>-->
       </div>
       <?php } ?>
        <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->
            <?php

			$start_date = date('d-m-Y', strtotime('-3 Month'));
			$end_date = date('d-m-Y');
			?>
            <div style="width:100%;display:none;" id="daily_report_tab">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts report</h3>
                    <div style="width:100%;float:left;font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="daily_report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;"># </th>
                            <th  style="padding:5px;">Receipt No </th>
                           <th  style="padding:5px;">Date </th>
                           <th  style="padding:5px;">Account </th>
                           <th  style="padding:5px;">Name </th>
                           <th  style="padding:5px;">Amount </th>

                        </tr>
                        <tbody align="center" id="daily_report_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"> <?php //echo $rec->for_opt ;?></td>
                                <td style="padding:5px;"><?php //echo $rec->received_from;?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>

            <!-- receipts by day report -->
            <div style="width:100%;display:none;" id="daily_report_by_day_tab">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts by day report</h3>
                    <div style="width:100%;float:left;font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="daily_report_by_date_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;">Issue date </th>
                           <th  style="padding:5px;">Total receipts per day </th>
                           <th  style="padding:5px;">Total amount per day </th>
                        </tr>
                        <tbody align="center" id="daily_report_by_day_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->

            <div style="width:100%;display:none;" id="monthly_report_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Montly summary report</h4>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Month</th>
                           <th  style="padding:5px;">Year</th>
                           <th  style="padding:5px;">Total receipts </th>
                           <th  style="padding:5px;">Amount (USD) </th>
                        </tr>
                        <tbody id="monthly_report_area">
                        <?php
						$counter = 1; $sum = 0.00;
						$first_date = date('m', strtotime($start_date));
						 $second_date = date('m', strtotime($end_date));
						 for($i = $first_date; $i <= $second_date; $i++)
						 {
								$monthly_record[sprintf("%02d", $i)]['sum'] = 0.00;
								$monthly_record[sprintf("%02d", $i)]['total_receipts'] = 0;
						 }
						$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."' ");
						while($rec = mysqli_fetch_object($data))
				 		{
							 $record_date = date('m', strtotime($rec->date));
							 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
							 $sum = $sum + $rec->amount;
							 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
						}
						//for($i = $first_date; $i <= $second_date; $i++)
						{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo get_month_name(sprintf("%02d", $i));?></td>
                                <td style="padding:5px;"><?php //echo date('Y', strtotime($start_date));?></td>
                                <td style="padding:5px;"><?php //echo $monthly_record[sprintf("%02d", $i)]['total_receipts'];?></td>
                                <td style="padding:5px;">$<?php //echo $monthly_record[sprintf("%02d", $i)]['sum'];?>0.00</td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        <tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?>0.00</div></td></tr>
                        </tbody>
                     </table>

                </div>

            </div>

            <div style="width:100%;display:none;" id="yealy_report_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Yearly summary report</h3>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Year</th>
                           <th  style="padding:5px;">Total receipts </th>
                           <th  style="padding:5px;">Amount (USD) </th>
                        </tr>
                        <tbody id="yearly_report_area">
                        <?php
						$counter = 1; $sum = 0.00;
						 $first_date = date('Y', strtotime($start_date));
						 $second_date = date('Y', strtotime($end_date));
						 for($i = $first_date; $i <= $second_date; $i++)
						 {
								$monthly_record[$i]['sum'] = 0.00;
								$monthly_record[$i]['total_receipts'] = 0;
						 }
						$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."' ");
						while($rec = mysqli_fetch_object($data))
				 		{
							 $record_date = date('Y', strtotime($rec->date));
							 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
							 $sum = $sum + $rec->amount;
							 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
						}
						for($i = $first_date; $i <= $second_date; $i++)
						{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php echo $i;?></td>
                                <td style="padding:5px;"><?php echo $monthly_record[$i]['total_receipts'];?></td>
                                <td style="padding:5px;">$<?php echo $monthly_record[$i]['sum'];?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                         <tr><td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php echo number_format($sum,2); ?></div></td></tr>
                         </tbody>
                     </table>

                </div>

            </div>

            <!-- License summary -->
            <div style="width:100%;display:none;" id="licence_summary_report_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">License summary report</h4>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                <div id="licence_summary_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Account Name</th>
                           <th  style="padding:5px;">Number</th>
                           <th  style="padding:5px;">Fees</th>
                           <th  style="padding:5px;">Amount  </th>
                        </tr>
                        <tbody id="licence_summary_area">
                        <?php

						$data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('License renewal', 'change license', 'Lost license' , 'New license')
													group by for_opt
													order by for_opt");
						while($rec = mysqli_fetch_object($data))
				 		{
							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->number;?></td>
                                <td style="padding:5px;"><?php //echo $rec->fee;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->total; ?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        <tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?>0.00</div></td></tr>
                        </tbody>
                     </table>

                </div>

            </div>

            <div style="width:100%;display:none" id="licence_detail_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">License detailed report</h3>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                 <div id="licence_detail_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">#</th>
                           <th  style="padding:5px;">Receipt </th>
                           <th  style="padding:5px;">Date </th>
                           <th  style="padding:5px;">For </th>
                           <th  style="padding:5px;">Name </th>
                           <th  style="padding:5px;">Lacagta </th>
                        </tr>
                        <tbody id="licence_detail_area">
                        <?php
						$counter = 1; $sum = 0.00;
						$sub_sum = 0;
						$data = mysqli_query($con,"select * from tbl_receipts

where
   for_opt in ('License renewal', 'change license', 'Lost license' , 'New license')

order by for_opt");
						$total_rec = mysqli_num_rows($data); $rec_count = 1;
						while($rec = mysqli_fetch_object($data))
				 		{
						     /*?>if($counter == 1){ $title = $rec->for_opt; }
							if($title != $rec->for_opt){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo //$counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}
							if($title != $rec->for_opt || $counter == 1){<?php
						?>

                                <tr><td colspan="6"><b><?php echo $rec->for_opt;?></b></td></tr>
                            <?php $title = $rec->for_opt; }  */

							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter;?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"><?php //echo $rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->received_from;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->amount;?></td>
                            </tr>
                        <?php break; $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
						     if($rec_count == $total_rec){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo $counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php //echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}  $rec_count++;
						}
						?>
                         <tr><td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount: :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?></div></td></tr>
                         </tbody>
                     </table>

                </div>

            </div>

            <!-- Moto summary -->
            <div style="width:100%;display:none;" id="moto_summary_report_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Moto receipts summary report</h4>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                <div id="moto_summary_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Account Name</th>
                           <th  style="padding:5px;">Number</th>
                           <th  style="padding:5px;">Fees</th>
                           <th  style="padding:5px;">Amount  </th>
                        </tr>
                        <tbody id="moto_summary_area">
                        <?php

						$data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('Renewal | Moto', 'Damaged card | Moto', 'New registration | Moto')
													group by for_opt
													order by for_opt");
						while($rec = mysqli_fetch_object($data))
				 		{
							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo //$rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->number;?></td>
                                <td style="padding:5px;"><?php //echo $rec->fee;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->total; ?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        <tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?>0.00</div></td></tr>
                        </tbody>
                     </table>

                </div>

            </div>

            <!-- moto detail -->
            <div style="width:100%;display:none;" id="moto_detail_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Moto receipts detailed report</h3>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                 <div id="moto_detail_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">#</th>
                           <th  style="padding:5px;">Receipt </th>
                           <th  style="padding:5px;">Date </th>
                           <th  style="padding:5px;">For </th>
                           <th  style="padding:5px;">Name </th>
                           <th  style="padding:5px;">Lacagta </th>
                        </tr>
                        <tbody id="moto_detail_area">
                        <?php
						$counter = 1; $sum = 0.00;
						$sub_sum = 0;
						$data = mysqli_query($con,"select * from tbl_receipts

where
   for_opt in ('License renewal', 'change license', 'Lost license' , 'New license')

order by for_opt");
						$total_rec = mysqli_num_rows($data); $rec_count = 1;
						while($rec = mysqli_fetch_object($data))
				 		{
						     /*?>if($counter == 1){ $title = $rec->for_opt; }
							if($title != $rec->for_opt){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo //$counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}
							if($title != $rec->for_opt || $counter == 1){<?php
						?>

                                <tr><td colspan="6"><b><?php echo $rec->for_opt;?></b></td></tr>
                            <?php $title = $rec->for_opt; }  */

							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter;?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"><?php //echo $rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->received_from;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->amount;?></td>
                            </tr>
                        <?php break; $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
						     if($rec_count == $total_rec){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo $counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php //echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}  $rec_count++;
						}
						?>
                         <tr><td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount: :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?></div></td></tr>
                         </tbody>
                     </table>

                </div>

            </div>

            <!-- vehicle summary -->
            <div style="width:100%;display:none;" id="vehicle_summary_report_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Vehicles receipts summary report</h4>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                <div id="vehicle_summary_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Account Name</th>
                           <th  style="padding:5px;">Number</th>
                           <th  style="padding:5px;">Fees</th>
                           <th  style="padding:5px;">Amount  </th>
                        </tr>
                        <tbody id="vehicle_summary_area">
                        <?php

						$data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('Renewal | Moto', 'Damaged card | Moto', 'New registration | Moto')
													group by for_opt
													order by for_opt");
						while($rec = mysqli_fetch_object($data))
				 		{
							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo //$rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->number;?></td>
                                <td style="padding:5px;"><?php //echo $rec->fee;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->total; ?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        <tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?>0.00</div></td></tr>
                        </tbody>
                     </table>

                </div>

            </div>

            <!-- vehicle detail -->
            <div style="width:100%;display:none;" id="vehicle_detail_tab">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Vehicles receipts detailed report</h3>
									<div style="width:100%;float:left;font-weight:bold;" >   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
							</div>
                 <div id="vehicle_detail_tab_top_details">

                <h5><center><?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></center></h5>
				</div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">#</th>
                           <th  style="padding:5px;">Receipt </th>
                           <th  style="padding:5px;">Date </th>
                           <th  style="padding:5px;">For </th>
                           <th  style="padding:5px;">Name </th>
                           <th  style="padding:5px;">Lacagta </th>
                        </tr>
                        <tbody id="vehicle_detail_area">
                        <?php
						$counter = 1; $sum = 0.00;
						$sub_sum = 0;
						$data = mysqli_query($con,"select * from tbl_receipts

where
   for_opt in ('License renewal', 'change license', 'Lost license' , 'New license')

order by for_opt");
						$total_rec = mysqli_num_rows($data); $rec_count = 1;
						while($rec = mysqli_fetch_object($data))
				 		{
						     /*?>if($counter == 1){ $title = $rec->for_opt; }
							if($title != $rec->for_opt){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo //$counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}
							if($title != $rec->for_opt || $counter == 1){<?php
						?>

                                <tr><td colspan="6"><b><?php echo $rec->for_opt;?></b></td></tr>
                            <?php $title = $rec->for_opt; }  */

							?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter;?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"><?php //echo $rec->for_opt;?></td>
                                <td style="padding:5px;"><?php //echo $rec->received_from;?></td>
                                <td style="padding:5px;">$<?php //echo $rec->amount;?></td>
                            </tr>
                        <?php break; $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
						     if($rec_count == $total_rec){ ?>
                               <tr><td colspan="2"><div style="float:right;margin-right:50px;"><b><?php //echo $counter - 1;?></b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$<?php //echo $sub_sum;?></b></div></td></tr>
                        <?php  $sub_sum = 0; $counter = 1;}  $rec_count++;
						}
						?>
                         <tr><td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount: :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?></div></td></tr>
                         </tbody>
                     </table>

                </div>

            </div>

            <div style="width:100%;display:none;" id="vehicle_tax_report_tab">

							<div style="border-bottom:1px solid #333;overflow:auto;">
                <h3 align="center"> Vehicle tax history report</h3>

                <div id="vehicle_tax_report_top_details">

                <h4>Vehicle : </h4>
                <h5>Period : <?php echo date('d-m-Y'); ?> - <?php echo date('d-m-Y'); ?></h5>
							</div>
            </div>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Receipt No</th>
                           <th  style="padding:5px;">Issue Date </th>
                           <th  style=";padding:5px;">Expire Date </th>
                           <th  style="padding:5px;">Account Name </th>
                           <th  style="padding:5px;">Owner name </th>
                           <th  style="padding:5px;">Vehicle No</
                        </tr>
                        <tbody align="center" id="vehicle_tax_report_area">
                        <?php
						/*$counter = 1; $sum = 0.00;
						 $vehicle_no = '';
						$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."' and vehicle_no = '".$vehicle_no."' ");
						while($rec = mysqli_fetch_object($data)) */
				 		{
						?>
                            <tr >
                                <td align="center" style="padding:5px;"><?php //echo $rec->vehicle_no;?></td>
                                <td align="center" style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td align="center" style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->expire_date));?></td>
                                <td align="center" style="padding:5px;"><?php //echo $rec->amount;?></td>
                                <td align="center" style="padding:5px;"><?php //echo $rec->amount;?></td>
                                <td align="center" style="padding:5px;"><?php //echo $rec->amount;?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                         <!--<tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php echo number_format($sum,2); ?></div></td></tr>-->
                         </tbody>
                     </table>

                </div>


            </div>

            <div style="width:100%;display:none;" id="road_tax_report_tab">
                 <h3 align="center">Road tax contracts not renewed</h4>
                 <h4 id="road_tax_report_top_area"><center></center></h4>
								 <div style="border-bottom:1px solid #333;overflow:auto;"></div>
                 <div style="width:100%;margin-top:30px;">
                    <table align="center" style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="width:120px;padding:5px;">Receipt No</th>
                           <th  style="width:120px;padding:5px;">Issue Date </th>
                           <th  style="width:120px;padding:5px;">Expire Date </th>
                           <th  style="padding:5px;">Account Name </th>
                           <th  style="padding:5px;">Owner name </th>
                           <th  style="width:120px;padding:5px;">Vehilcle No</th>

                        </tr>
                        <tbody id="road_tax_report_area">
                        <?php
						/* $where = '';
						if(isset($_GET['from_date']) && $_GET['from_date'] != '' && isset($_GET['to_date']) && $_GET['to_date'] != '')
						{
						   $where .= ' expire_date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_GET['from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_GET['to_date']))).'" ';
						}
						 if(isset($_GET['vehicle_no']) && $_GET['vehicle_no'] != '')
						 {
							if($where != '')
								$where .= ' AND ';
							$where .= "	plate_no = '".$_GET['vehicle_no']."' ";
						 }*/
						//$data = mysqli_query($con,"SELECT * FROM tbl_vehicles where  ".$where." order by expire_date");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $rec->plate_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->expire_date));?></td>
                                <td align="left" style="padding:5px;"><?php // echo $rec->Owner;?></td>
                                <td style="padding:5px;"><?php //echo $rec->mobile_no;?></td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        </tbody>
                     </table>

                </div>
            </div>

             <!-- Receipts details with account names -->
            <div style="width:100%;display:none;" id="receipt_detail_with_account_name">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts details with account names</h3>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="width:100%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr text-align="center">
                           <th  style="padding:5px;text-align:center;">Sr </th>
                           <th  style="padding:5px;text-align:center;">Issue date </th>
                           <th  style="padding:5px;text-align:center;">Account Name</th>
                           <th  style="padding:5px;text-align:center;">Received From</th>
                           <th  style="padding:5px;text-align:center;">Receipt No</th>
                           <th  style="padding:5px;text-align:center;">Amount</th>
                        </tr>
                        <tbody align="center" id="receipt_detail_with_account_name_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->

            <!-- Receipts grouped by account namess -->
            <div style="width:100%;display:none;" id="receipt_detail_grouped_account_name">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts grouped by account namess</h3>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;">For Account  </th>
                           <th  style="padding:5px;">Issue date </th>
                           <th  style="padding:5px;">Receipt</th>
                           <th  style="padding:5px;">Received From</th>
                           <th  style="padding:5px;">Amount</th>
                        </tr>
                        <tbody align="center" id="receipt_detail_grouped_account_name_area">
                        <?php

						//cho $sql; exit;
						/*$data = mysqli_query($con, $sql);
						$counter = 1; $sum = 0.00;
						$for_account = ''; $receipt_counter = 0; $sumary_sum = 0.00;
						while($rec = mysqli_fetch_object($data))*/
				 		{

						?>
                            <?php /*?><tr align="center">
                                <?php
								if($counter == 1){ ?>
                                     <td style="padding:5px;"><?php echo $rec->for_opt ; ?></td>
								<?php $for_account = $rec->for_opt;
							    }
								else if($rec->for_opt != $for_account) { ?>
                                    <!--  Show Summary -->
                                       <td colspan="2" style="text-align:left;margin-left:10px;"><b>Summary for 'For' = <?php echo $for_account; ?></b></td>
                                       <td colspan="1" style="height:30px;"><b><?php echo $receipt_counter; ?></b></td>
                                       <td></td>
                                       <td><b>$<?php echo $sumary_sum; ?></b></td>
                                    </tr>
                                    <tr>
                                	<td style="padding:5px;"><?php echo $rec->for_opt ; ?></td>
                                <?php    $for_account = $rec->for_opt; $receipt_counter = 0; $sumary_sum = 0.00;
								}else{ ?>
                                    <td></td>
                                <?php } ?>
                                <td style="padding:5px;"><?php echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"><?php echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php echo $rec->received_from;?></td>
                                <td style="padding:5px;">$<?php echo $rec->amount;?></td>

                            </tr><?php */?>
                        <?php //$counter++; $sum = $sum + $rec->amount; $receipt_counter++; $sumary_sum = $sumary_sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->

            <!-- Receipts summary by account names -->
            <div style="width:100%;display:none;" id="receipt_details_summry_account_names">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts summary by account names</h3>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;width:60%;">For</th>
                           <th  style="padding:5px;">Amount </th>
                           <th  style="padding:5px;">Receipts</th>

                        </tr>
                        <tbody align="center" id="receipt_details_summry_account_names_area">
                        <?php

						//cho $sql; exit;
						/*$data = mysqli_query($con, $sql);
						$counter = 1; $sum = 0.00;
						$for_account = ''; $receipt_counter = 0; $sumary_sum = 0.00;
						while($rec = mysqli_fetch_object($data))*/
				 		{

						?>
                            <?php /*?><tr align="center">
                                <?php
								if($counter == 1){ ?>
                                     <td style="padding:5px;"><?php echo $rec->for_opt ; ?></td>
								<?php $for_account = $rec->for_opt;
							    }
								else if($rec->for_opt != $for_account) { ?>
                                    <!--  Show Summary -->
                                       <td colspan="2" style="text-align:left;margin-left:10px;"><b>Summary for 'For' = <?php echo $for_account; ?></b></td>
                                       <td colspan="1" style="height:30px;"><b><?php echo $receipt_counter; ?></b></td>
                                       <td></td>
                                       <td><b>$<?php echo $sumary_sum; ?></b></td>
                                    </tr>
                                    <tr>
                                	<td style="padding:5px;"><?php echo $rec->for_opt ; ?></td>
                                <?php    $for_account = $rec->for_opt; $receipt_counter = 0; $sumary_sum = 0.00;
								}else{ ?>
                                    <td></td>
                                <?php } ?>
                                <td style="padding:5px;"><?php echo date('d/m/Y', strtotime($rec->date));?></td>
                                <td style="padding:5px;"><?php echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php echo $rec->received_from;?></td>
                                <td style="padding:5px;">$<?php echo $rec->amount;?></td>

                            </tr><?php */?>
                        <?php //$counter++; $sum = $sum + $rec->amount; $receipt_counter++; $sumary_sum = $sumary_sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->

             <!-- Receipts Summary by each day -->
            <div style="width:100%;display:none;" id="receipt_summary_day">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts Summary by each day</h3>
                    <div style="width:100%;float:left;font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;">Issue date </th>
                           <th  style="padding:5px;">Total receipts per day </th>
                           <th  style="padding:5px;">Total amount per day </th>
                        </tr>
                        <tbody align="center" id="receipt_summary_day_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->

             <!-- Receipts Summary by Main accounts -->
            <div style="width:100%;display:none;" id="receipt_summary_main_accounts">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts Summary by Main accounts</h3>
                    <div style="width:100%;float:left;font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;float:left;">Main Account  </th>
                           <th  style="padding:5px;">Receipts </th>
                           <th  style="padding:5px;">Amount </th>
                        </tr>
                        <tbody align="center" id="receipt_summary_main_accounts_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->
            <!-- Receipts summary by months -->
            <div style="width:100%;display:none;" id="receipt_report_summary_month">
							<div style="border-bottom:1px solid #333;overflow:auto;">
									<h3 align="center">Receipts summary by months</h4>
							</div>
                 <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="width:100%;margin-top:30px;">
                    <table style="width:100%;" border="1" cellpadding="0" cellspacing="0">
                        <tr >
                           <th  style="padding:5px;">Month</th>
                           <th  style="padding:5px;">Total receipts </th>
                           <th  style="padding:5px;">Total Amount </th>
                        </tr>
                        <tbody id="receipt_report_summary_month_area">
                        <?php
						/*$counter = 1; $sum = 0.00;
						$first_date = date('m', strtotime($start_date));
						 $second_date = date('m', strtotime($end_date));
						 for($i = $first_date; $i <= $second_date; $i++)
						 {
								$monthly_record[sprintf("%02d", $i)]['sum'] = 0.00;
								$monthly_record[sprintf("%02d", $i)]['total_receipts'] = 0;
						 }
						$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."' ");
						while($rec = mysqli_fetch_object($data))
				 		{
							 $record_date = date('m', strtotime($rec->date));
							 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
							 $sum = $sum + $rec->amount;
							 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
						}*/
						//for($i = $first_date; $i <= $second_date; $i++)
						{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo get_month_name(sprintf("%02d", $i));?></td>
                                <td style="padding:5px;"><?php //echo date('Y', strtotime($start_date));?></td>
                                <td style="padding:5px;"><?php //echo $monthly_record[sprintf("%02d", $i)]['total_receipts'];?></td>
                                <td style="padding:5px;">$<?php //echo $monthly_record[sprintf("%02d", $i)]['sum'];?>0.00</td>
                            </tr>
                        <?php $counter++;
						}
						?>
                        <tr><td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td><td align="center"> <div style="font-weight:bold;"> $<?php //echo number_format($sum,2); ?>0.00</div></td></tr>
                        </tbody>
                     </table>

                </div>

            </div>

            <!-- -------------------- -->
            <!-- Receipts Summary by Main accounts -->
            <div style="width:100%;display:none;" id="receipt_summary_main_sub_accounts">

                <div style="border-bottom:1px solid #333;overflow:auto;">
                    <h3 align="center">Receipts summary by main accounts and subaccounts</h3>
                    <div style="width:100%;float:left;font-weight:bold;" id="p_r_receipt_no_1">   Date: <?php echo date('d M, Y h:i:sa'); ?></div>
                </div>
                <h3> <center>Period </center></h3>
                <h5 id="report_period"><center><?php echo date('d/m/Y', strtotime($start_date)); ?> - <?php echo date('d-m-Y', strtotime($end_date)); ?> </center></h5>
                <div style="padding-left:20px;width:98%;margin-top:5px;">
                    <table style="width:100%;" border="0" cellpadding="0" cellspacing="0">
                        <tr align="center">
                           <th  style="padding:5px;float:left;">Account name  </th>
                           <th  style="padding:5px;">Receipts </th>
                           <th  style="padding:5px;">Amount </th>
                        </tr>
                        <tbody align="center" id="receipt_summary_main_sub_accounts_area">
                        <?php
						$counter = 1; $sum = 0.00;
						//$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($start_date))."' and '".date('Y-m-d', strtotime($end_date))."'");
						//while($rec = mysqli_fetch_object($data))
				 		{
						?>
                            <tr align="center">
                                <td style="padding:5px;"><?php //echo $counter ; ?></td>
                                <td style="padding:5px;"><?php //echo $rec->receipt_no;?></td>
                                <td style="padding:5px;"><?php //echo date('d/m/Y', strtotime($rec->date));?></td>

                            </tr>
                        <?php //$counter++; $sum = $sum + $rec->amount;
						}
						?>
                        </tbody>
                     </table>
                     <!--<div style="float:right;margin-right:10px;margin-top:10px;font-weight:bold;"> Total : &nbsp;&nbsp;&nbsp;&nbsp; $<span id="daily_report_sum"><?php echo number_format($sum,2); ?></span> </div>-->
                </div>

            </div>
            <!-- -------------------- -->
						<div id="statistics" class="tab-pane fade">
							<div class="charts">
								<span>Charts</span>
								<a href="#"><img src="assets/img/chart1.png"/></a>
								<a href="#"><img src="assets/img/chart2.png"/></a>
								<a href="#"><img src="assets/img/chart3.png"/></a>
								<a href="#"><img src="assets/img/chart4.png"/></a>
							</div>
						</div>
            <?php

			?>
          <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->
      </div>

   </div>

<?php /* ###############
         Footer
	  */
	  include_once('inc/footer.php');
?>
