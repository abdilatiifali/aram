<?php 
// Config file
require_once('../inc/config.php');

/// search section
if(!isset($_POST['s_report_from_date']) || isset($_POST['s_report_to_date']) && !isset($_POST['action']))      // Search records
{
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT * FROM tbl_receipts where '.$where.'  ';
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0;
		while($rec = mysqli_fetch_object($data))
		 {
		      $result .= '<tr>
							<td style="padding:5px 10px;">'.$counter.'</td>
							<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
							<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
							<td style="padding:5px 10px;">'.$rec->for_opt.'</td>  
							<td style="padding:5px 10px;">'.$rec->received_from.'</td>
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						  </tr>';
				$counter++;	$sum = $sum + $rec->amount;	  
		 }
		 
		 // Get data for monthly report
		 $counter = 1; $sum = 0.00;
		 $first_date = date('m', strtotime($_POST['s_report_from_date']));
		 $year = 0;
		 $second_date = date('m', strtotime($_POST['s_report_to_date']));
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
				$monthly_record[sprintf("%02d", $i)]['sum'] = 0.00; 
				$monthly_record[sprintf("%02d", $i)]['total_receipts'] = 0;
				$monthly_record[sprintf("%02d", $i)]['year'] = 0;
		 }
		 $data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' ");
		 while($rec = mysqli_fetch_object($data))
		 {
			 $record_date = date('m', strtotime($rec->date));
			 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
			 if($year == 0)
			 	$year = date('Y', strtotime($rec->date));
			 $sum = $sum + $rec->amount;
			 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
		 }
		 $monthly_report = '';
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
		     $monthly_report .= '<tr align="center">
									<td style="padding:5px 10px;">'.get_month_name(sprintf("%02d", $i)).'</td>
									<td style="padding:5px 10px;">'.$year.'</td>
									<td style="padding:5px 10px;">'.$monthly_record[sprintf("%02d", $i)]['total_receipts'].'</td>
									<td style="padding:5px 10px;">$'.$monthly_record[sprintf("%02d", $i)]['sum'].'</td>
								</tr>';  
		     $counter++; 
		} 
		     $monthly_report .= '<tr>
							   		<td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';

		 //.........................
		 // Yearly reports
		 $counter = 1; $sum = 0.00;
		 $first_date = date('Y', strtotime($_POST['s_report_from_date']));
		 $second_date = date('Y', strtotime($_POST['s_report_to_date']));
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
				$monthly_record[$i]['sum'] = 0.00; 
				$monthly_record[$i]['total_receipts'] = 0;
		 }
		$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' ");
		while($rec = mysqli_fetch_object($data))
		{
			 $record_date = date('Y', strtotime($rec->date));
			 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
			 $sum = $sum + $rec->amount;
			 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
		}
		$yearly_report = '';
		for($i = $first_date; $i <= $second_date; $i++)
		{
		    $yearly_report .= '<tr align="center">
									<td style="padding:5px 10px;">'.$i.'</td>
									<td style="padding:5px 10px;">'.$monthly_record[$i]['total_receipts'].'</td>
									<td style="padding:5px 10px;">'.$monthly_record[$i]['sum'].'</td>
								</tr>'; 
			
		    $counter++; 
		} 
		$yearly_report .= '<tr>
								<td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							 </tr>';
		 //..........................
		 // TAX reports
		 if(isset($_POST['vehicle_no']))
		 {
			 $sum = 0.00;
			 $v_tax_result = '';
			 $vehicle_no = $_POST['vehicle_no'];
			 $data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' and vehicle_no = '".$vehicle_no."' ");
			 while($rec = mysqli_fetch_object($data))
			 {
			    $v_tax_result .= '<tr>
									<td style="padding:5px 10px;">'.$rec->vehicle_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->expire_date)).'</td>  
									<td style="padding:5px 10px;">$'.$rec->amount.'</td>
								  </tr>';
					$sum = $sum + $rec->amount;	 
			}
			$v_tax_result .= '<tr>
								<td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							  </tr>';		
			$v_tax__top_details = '<h4>Vehicle : '.$_POST['vehicle_no'].'</h4>
                					<h5>Period : '.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</h5>';       
			 
		 }
		 // Road tax contracts not renewed..
		 $road_tax_result = '';
		 $data = mysqli_query($con,"SELECT * FROM tbl_vehicles where  expire_date between '".date('d/m/y', strtotime($_POST['s_report_from_date']))."' and '".date('d/m/y', strtotime($_POST['s_report_to_date']))."'  ");
		 while($rec = mysqli_fetch_object($data))
		 {
			$road_tax_result .= '<tr>
								<td style="padding:5px 10px;">'.$rec->plate_no.'</td>
								<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
								<td style="padding:5px 10px;">'.$rec->Owner.'</td>  
								<td style="padding:5px 10px;">'.$rec->mobile_no.'</td>
							  </tr>';
			 
		}
		$road_tax_result_top_details = '<center>Period : '.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center>';        
		 //...........................
		 echo json_encode(array('result_daily_report' => $result, 
		 						'daily_report_sum' => $sum, 
								'monthly_report' => $monthly_report, 
								'yearly_report' => $yearly_report,
								'v_tax_result' => $v_tax_result,
								'v_tax__top_details' => $v_tax__top_details,  
								'road_tax_result' => $road_tax_result,
								'road_tax_result_top_details' => $road_tax_result_top_details
								 ));
	}
	else
		echo '';
}
// Daily report
if(isset($_POST['action']) && $_POST['action'] == 'daily_report')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT * FROM tbl_receipts where '.$where.'  ';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0;
		while($rec = mysqli_fetch_object($data))
		 {
		      $result .= '<tr>
							<td style="padding:5px 10px;">'.$counter.'</td>
							<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
							<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
							<td style="padding:5px 10px;">'.$rec->for_opt.'</td>  
							<td style="padding:5px 10px;">'.$rec->received_from.'</td>
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						  </tr>';
				$counter++;	$sum = $sum + $rec->amount;	  
		 }
		 $result .= '<tr>
						<td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result_daily_report' => $result, 
		 						'daily_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result_daily_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'daily_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//Receipt by day report
if(isset($_POST['action']) && $_POST['action'] == 'receipt_by_day_report')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT sum(amount) as sum , count(*) as total, date 
				FROM tbl_receipts 
				where '.$where.'  
				group by date
				order by date
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0; $total_receipts = 0;
		while($rec = mysqli_fetch_object($data))
		 {
		      $result .= '<tr>
							<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
							<td style="padding:5px 10px;">'.$rec->total.'</td>  
							<td style="padding:5px 10px;">$'.$rec->sum.'</td>
						  </tr>';
				$counter++;	$sum = $sum + $rec->sum; $total_receipts = $total_receipts + $rec->total;	  
		 }
		 $result .= '<tr>
						<td ><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
						<td align="center"> <div style="font-weight:bold;">'.$total_receipts.'</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result_by_date_report' => $result, 
		 						'date_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result_by_date_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'date_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
// monthly report
if(isset($_POST['action']) && $_POST['action'] == 'monthly_report')
{
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Get data for monthly report
		 $counter = 1; $sum = 0.00;
		 $first_date = date('m', strtotime($_POST['s_report_from_date']));
		 $year = 0;
		 
		 $second_date = date('m', strtotime($_POST['s_report_to_date']));
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
				$monthly_record[sprintf("%02d", $i)]['sum'] = 0.00; 
				$monthly_record[sprintf("%02d", $i)]['total_receipts'] = 0;
				$monthly_record[sprintf("%02d", $i)]['year'] = 0;
		 }
		 $data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' ");
		 while($rec = mysqli_fetch_object($data))
		 {
			 $record_date = date('m', strtotime($rec->date));
			 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
			 if($year == 0)
			 	$year = date('Y', strtotime($rec->date));
			 $sum = $sum + $rec->amount;
			 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
		 }
		 if($year == 0)
			 	$year = date('Y',  strtotime($_POST['s_report_from_date']));
		 $monthly_report = '';
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
		     $monthly_report .= '<tr align="center">
									<td style="padding:5px 10px;">'.get_month_name(sprintf("%02d", $i)).'</td>
									<td style="padding:5px 10px;">'.$year.'</td>
									<td style="padding:5px 10px;">'.$monthly_record[sprintf("%02d", $i)]['total_receipts'].'</td>
									<td style="padding:5px 10px;">$'.$monthly_record[sprintf("%02d", $i)]['sum'].'</td>
								</tr>';  
		     $counter++; 
		} 
		     $monthly_report .= '<tr>
							   		<td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';
						
		 echo json_encode(array('monthly_report' => $monthly_report, 
								));
	}
	else
	    echo json_encode(array('monthly_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 				));		
}
// Yearly report
if(isset($_POST['action']) && $_POST['action'] == 'yealy_report')
{
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $first_date = date('Y', strtotime($_POST['s_report_from_date']));
		 $second_date = date('Y', strtotime($_POST['s_report_to_date']));
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
				$monthly_record[$i]['sum'] = 0.00; 
				$monthly_record[$i]['total_receipts'] = 0;
		 }
		$data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' ");
		while($rec = mysqli_fetch_object($data))
		{
			 $record_date = date('Y', strtotime($rec->date));
			 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
			 $sum = $sum + $rec->amount;
			 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
		}
		$yearly_report = '';
		for($i = $first_date; $i <= $second_date; $i++)
		{
		    $yearly_report .= '<tr align="center">
									<td style="padding:5px 10px;">'.$i.'</td>
									<td style="padding:5px 10px;">'.$monthly_record[$i]['total_receipts'].'</td>
									<td style="padding:5px 10px;">'.$monthly_record[$i]['sum'].'</td>
								</tr>'; 
			
		    $counter++; 
		} 
		$yearly_report .= '<tr>
								<td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							 </tr>';
						
		 echo json_encode(array('yearly_report' => $yearly_report
								));
	}
	else
	    echo json_encode(array('yearly_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 				));		
}
// licence summary report
if(isset($_POST['action']) && $_POST['action'] == 'licence_summary')
{
	$where = '';
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select r.amount fee, count(*) number, sum(r.`amount`) as total, r.for_opt 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									
									where
									   act.acc_type = 'License'
									and (".$where.")   
									  
									group by r.for_opt
									order by r.for_opt"
		 							);
		 $monthly_report = '';
		 $sum = 0; $counter = 1; $numbers = 0;
		 while($rec = mysqli_fetch_object($data))
		 {
			 
		     $monthly_report .= '<tr align="center" >
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->number.'</td>
									<td style="padding:5px 10px;">$'.$rec->fee.'</td>
									<td style="padding:5px 10px;">$'.$rec->total.'</td>
								</tr>'; 
			 $sum = $sum + 	$rec->total;	$numbers = $numbers + $rec->number;			
		     $counter++; 
		} 
		     $monthly_report .= '<tr>
			                        <td ><div style="float:right;margin-right:30px;font-weight:bold;">Total issued license ( '.$numbers.')</div></td>
							   		<td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total amount:</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';
		 				
		 echo json_encode(array('licence_report' => $monthly_report, 
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('licence_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>',
								'top_details' => $top_details						 
		 				));		
}
// Licence Details reports
if(isset($_POST['action']) && $_POST['action'] == 'licence_detail')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select r.* 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									where
									   act.acc_type = 'License'
									and (".$where.")   
									  
									order by r.for_opt"
		 							);											
		$total_rec = mysqli_num_rows($data); $rec_count = 1;
		$yearly_report  = '';
		while($rec = mysqli_fetch_object($data))
		{
		
		    if($counter == 1){ $title = $rec->for_opt; } 
			if($title != $rec->for_opt){   
                  $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'. $sub_sum.'</b></div></td></tr>';
            	  $sub_sum = 0; $counter = 1;
			}       
			if($title != $rec->for_opt || $counter == 1){
				  $yearly_report .=	'<tr><td colspan="6"><b>'.$rec->for_opt.'</b></td></tr>';
                  $title = $rec->for_opt; 
		    } 
			
			$yearly_report .= '<tr align="center" > 
									<td style="padding:5px 10px;">'.$counter.'</td>
									<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->received_from.'</td>
									<td style="padding:5px 10px;">$'.$rec->amount.'</td>
								</tr>'; 
			
		   $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
		   if($rec_count == $total_rec){ 
                 $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'.$sub_sum.'</b></div></td></tr>';
                 $sub_sum = 0; $counter = 1;
		   }  
		   $rec_count++;
		} 
		$yearly_report .= '<tr>
								<td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount:</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							 </tr>';
		
			 				
		 echo json_encode(array('licence_report' => $yearly_report,
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('licence_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
								'top_details' => $top_details						
		 				));		
}
// moto summary report
if(isset($_POST['action']) && $_POST['action'] == 'moto_summary')
{
	$where = '';
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select r.amount fee, count(*) number, sum(r.`amount`) as total, r.for_opt 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									
									where
									   act.acc_type = 'Moto'
									and (".$where.")   
									  
									group by r.for_opt
									order by r.for_opt"
		 							); 											
		 $monthly_report = '';
		 $sum = 0; $counter = 1; $numbers = 0;
		 while($rec = mysqli_fetch_object($data))
		 {
			 
		     $monthly_report .= '<tr align="center" >
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->number.'</td>
									<td style="padding:5px 10px;">$'.$rec->fee.'</td>
									<td style="padding:5px 10px;">$'.$rec->total.'</td>
								</tr>'; 
			 $sum = $sum + 	$rec->total;	$numbers = $numbers + $rec->number;			
		     $counter++; 
		} 
		     $monthly_report .= '<tr>
			                        <td ><div style="float:right;margin-right:30px;font-weight:bold;">Total issued license ( '.$numbers.')</div></td>
							   		<td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total amount:</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';
		 				
		 echo json_encode(array('moto_report' => $monthly_report, 
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('moto_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>',
								'top_details' => $top_details						 
		 				));		
}
// moto Details reports
if(isset($_POST['action']) && $_POST['action'] == 'moto_detail')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select r.* 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									where
									   act.acc_type = 'Moto'
									and (".$where.")   
									  
									order by r.for_opt"
		 							);														
		$total_rec = mysqli_num_rows($data); $rec_count = 1;
		$yearly_report  = '';
		while($rec = mysqli_fetch_object($data))
		{
		
		    if($counter == 1){ $title = $rec->for_opt; } 
			if($title != $rec->for_opt){   
                  $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'. $sub_sum.'</b></div></td></tr>';
            	  $sub_sum = 0; $counter = 1;
			}       
			if($title != $rec->for_opt || $counter == 1){
				  $yearly_report .=	'<tr><td colspan="6"><b>'.$rec->for_opt.'</b></td></tr>';
                  $title = $rec->for_opt; 
		    } 
			
			$yearly_report .= '<tr align="center" > 
									<td style="padding:5px 10px;">'.$counter.'</td>
									<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->received_from.'</td>
									<td style="padding:5px 10px;">$'.$rec->amount.'</td>
								</tr>'; 
			
		   $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
		   if($rec_count == $total_rec){ 
                 $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'.$sub_sum.'</b></div></td></tr>';
                 $sub_sum = 0; $counter = 1;
		   }  
		   $rec_count++;
		} 
		$yearly_report .= '<tr>
								<td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount:</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							 </tr>';
		
			 				
		 echo json_encode(array('moto_report' => $yearly_report,
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('moto_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
								'top_details' => $top_details						
		 				));		
}
//---------
// vehicle summary report
if(isset($_POST['action']) && $_POST['action'] == 'vehicle_summary')
{
	$where = '';
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select r.amount fee, count(*) number, sum(r.`amount`) as total, r.for_opt 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									
									where
									   act.acc_type = 'Vehicle'
									and (".$where.")   
									  
									group by r.for_opt
									order by r.for_opt"
		 							); 														
		 $monthly_report = '';
		 $sum = 0; $counter = 1; $numbers = 0;
		 while($rec = mysqli_fetch_object($data))
		 {
			 
		     $monthly_report .= '<tr align="center" >
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->number.'</td>
									<td style="padding:5px 10px;">$'.$rec->fee.'</td>
									<td style="padding:5px 10px;">$'.$rec->total.'</td>
								</tr>'; 
			 $sum = $sum + 	$rec->total;	$numbers = $numbers + $rec->number;			
		     $counter++; 
		} 
		     $monthly_report .= '<tr>
			                        <td ><div style="float:right;margin-right:30px;font-weight:bold;">Total issued license ( '.$numbers.')</div></td>
							   		<td colspan="2"><div style="float:right;margin-right:30px;font-weight:bold;"> Total amount:</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';
		 				
		 echo json_encode(array('vehicle_report' => $monthly_report, 
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('vehicle_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>',
								'top_details' => $top_details						 
		 				));		
}
// vehicle Details reports
if(isset($_POST['action']) && $_POST['action'] == 'vehicle_detail')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>';       
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select r.* 
									from tbl_receipts r
									
									inner join tbl_account_list as al
									on al.acc_name = r.for_opt
									inner join tbl_acc_type as act
									on act.acc_type = al.acc_type
									
									where
									   act.acc_type = 'Vehicle'
									and (".$where.")   
									  
									order by r.for_opt"
		 							);													
		$total_rec = mysqli_num_rows($data); $rec_count = 1;
		$yearly_report  = '';
		while($rec = mysqli_fetch_object($data))
		{
		
		    if($counter == 1){ $title = $rec->for_opt; } 
			if($title != $rec->for_opt){   
                  $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'. $sub_sum.'</b></div></td></tr>';
            	  $sub_sum = 0; $counter = 1;
			}       
			if($title != $rec->for_opt || $counter == 1){
				  $yearly_report .=	'<tr><td colspan="6"><b>'.$rec->for_opt.'</b></td></tr>';
                  $title = $rec->for_opt; 
		    } 
			
			$yearly_report .= '<tr align="center" > 
									<td style="padding:5px 10px;">'.$counter.'</td>
									<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
									<td style="padding:5px 10px;">'.$rec->for_opt.'</td>
									<td style="padding:5px 10px;">'.$rec->received_from.'</td>
									<td style="padding:5px 10px;">$'.$rec->amount.'</td>
								</tr>'; 
			
		   $counter++; $sum = $sum + $rec->amount; $sub_sum = $sub_sum + $rec->amount;
		   if($rec_count == $total_rec){ 
                 $yearly_report .= '<tr><td colspan="2"><div style="float:right;margin-right:50px;"><b>'.($counter - 1).'</b></div></td><td colspan="4"><div style="float:right;margin-right:50px;"><b>$'.$sub_sum.'</b></div></td></tr>';
                 $sub_sum = 0; $counter = 1;
		   }  
		   $rec_count++;
		} 
		$yearly_report .= '<tr>
								<td colspan="5"><div style="float:right;margin-right:30px;font-weight:bold;"> Total Amount:</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							 </tr>';
		
			 				
		 echo json_encode(array('vehicle_report' => $yearly_report,
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('vehicle_report' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
								'top_details' => $top_details						
		 				));		
}
// Vehicle Tax report     
if(isset($_POST['action']) && $_POST['action'] == 'vehicle_tax_report')
{
	// TAX reports
		 if(isset($_POST['vehicle_no']))
		 {
			 $sum = 0.00;
			 $v_tax_result = '';
			 $vehicle_no = $_POST['vehicle_no'];
			 $data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' and vehicle_no = '".$vehicle_no."' ");
			 while($rec = mysqli_fetch_object($data))
			 {
			    $v_tax_result .= '<tr>
									<td style="padding:5px 10px;">'.$rec->vehicle_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->expire_date)).'</td>  
									<td style="padding:5px 10px;">$'.$rec->amount.'</td>
								  </tr>';
					$sum = $sum + $rec->amount;	 
			}
			$v_tax_result .= '<tr>
								<td colspan="3"><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
								<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
							  </tr>';		
			$v_tax__top_details = '<h4>Vehicle : '.$_POST['vehicle_no'].'</h4>
                					<h5>Period : '.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</h5>';       
			 
		 }
						
		 echo json_encode(array('v_tax_result' => $v_tax_result,
								'v_tax__top_details' => $v_tax__top_details, 
								));
	
}
// Road  Tax not renewed report
if(isset($_POST['action']) && $_POST['action'] == 'road_tax_report')
{
	// Road tax contracts not renewed..
		 $road_tax_result = '';
		 $where = '';
		if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
		{
		   $where .= ' r.expire_date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
		}
		 if(isset($_POST['vehicle_no']) && $_POST['vehicle_no'] != '')
		 {
			if($where != '')
			    $where .= ' AND ';
			$where .= "	r.vehicle_no = '".$_POST['vehicle_no']."' ";	 
		 }
		 //echo "SELECT * FROM tbl_vehicles where  ".$where." "; exit;
		 $data = mysqli_query($con,"SELECT r.expire_date,  v.plate_no, v.Owner, v.mobile_no FROM tbl_receipts r
		 							inner join tbl_vehicles v
									on v.plate_no = r.vehicle_no
									where  ".$where." order by r.expire_date");
		 while($rec = mysqli_fetch_object($data))
		 {
			$road_tax_result .= '<tr>
									<td style="padding:5px 10px;">'.$rec->plate_no.'</td>
									<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->expire_date)).'</td>
									<td style="padding:5px 10px;">'.$rec->Owner.'</td>  
									<td style="padding:5px 10px;">'.$rec->mobile_no.'</td>
								  </tr>';
			 
		}
		$road_tax_result_top_details = '<center>Period : '.date('d/m/Y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/Y', strtotime($_POST['s_report_to_date'])).'</center>';        
		 //...........................
						
		 echo json_encode(array('road_tax_result' => $road_tax_result,
								'road_tax_result_top_details' => $road_tax_result_top_details
								));
	
}
//
// Receipts details with account names
if(isset($_POST['action']) && $_POST['action'] == 'receipt_report_account_names')
{
	$top_details = '<h5><center>'.date('d/m/Y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/Y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT r.date, r.receipt_no, r.amount, r.for_opt, r.received_from
				FROM tbl_receipts r
				where '.$where.'  
				ORDER BY r.date, r.receipt_no';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0;
		while($rec = mysqli_fetch_object($data))
		 {
		      $result .= '<tr>
							<td style="padding:5px 10px;">'.$counter.'</td>
							<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
							<td style="padding:5px 10px;">'.$rec->for_opt.'</td> 
							<td style="padding:5px 10px;">'.$rec->received_from.'</td>
							<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						  </tr>';
				$counter++;	$sum = $sum + $rec->amount;	  
		 }
		 $result .= '<tr>
						<td colspan="4"><div style="float:left;margin-left:30px;font-weight:bold;"> Grand Totals :</div></td>
						<td align="center"> <div style="font-weight:bold;"> '.($counter - 1).'</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result' => $result, 
		 						'daily_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'daily_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//....................
// Receipts grouped by account names
if(isset($_POST['action']) && $_POST['action'] == 'receipt_detail_grouped_account_name')
{
	$top_details = '<h5><center>'.date('d/m/Y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/Y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' r.date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT r.date, r.receipt_no, r.amount, r.for_opt, r.received_from
				FROM tbl_receipts r
				where  '.$where.'  
				ORDER BY r.for_opt ,r.date, r.receipt_no';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0;
		$for_account = ''; $receipt_counter = 0; $sumary_sum = 0.00;
		$sumry_data = '';
		$total_record = mysqli_num_rows($data);
		while($rec = mysqli_fetch_object($data))
		 {
		      if($counter == 1)
			  {
                   $sumry_data = '<td style="padding:5px;">'.$rec->for_opt.'</td>';
				    $for_account = $rec->for_opt;
			  } 
			  else if($rec->for_opt != $for_account) 
			  { 
					// Show Summary -->
					$sumry_data = '<td colspan="2" style="text-align:left;margin-left:10px;"><b>Summary for \'For\' = '.$for_account.'</b></td>
								   <td colspan="1" style="height:30px;"><b>'.$receipt_counter.'</b></td> 
								   <td></td>
								   <td><b>$'.number_format($sumary_sum,2).'</b></td>
								</tr>
								<tr>
								<td style="padding:5px;">'.$rec->for_opt.'</td>';
                    $for_account = $rec->for_opt; $receipt_counter = 0; $sumary_sum = 0.00;
			  }
			  else
			  { 
                   $sumry_data =  '<td></td>';
			  }
			  
			  $result .= '<tr>
			                '.$sumry_data.'
							<td style="padding:5px 10px;">'.date('d/m/Y', strtotime($rec->date)).'</td>
							<td style="padding:5px 10px;">'.$rec->receipt_no.'</td>
							<td style="padding:5px 10px;">'.$rec->received_from.'</td>
							<td style="padding:5px 10px;">$'.number_format($rec->amount,2).'</td>
						  </tr>';
			  $sum = $sum + $rec->amount;	$receipt_counter++; $sumary_sum = $sumary_sum + $rec->amount;
			  if($total_record  == $counter)
			  {
				  $result .= '<tr>
				                  <td colspan="2" style="text-align:left;margin-left:10px;"><b>Summary for \'For\' = '.$for_account.'</b></td>
								   <td colspan="1" style="height:30px;"><b>'.$receipt_counter.'</b></td> 
								   <td></td>
								   <td><b>$'.number_format($sumary_sum,2).'</b></td>
							  </tr>';
			  }
			  $counter++;	  
		 }
		 $result .= '<tr style="color:red;">
						<td colspan="2"><div style="float:left;margin-left:30px;font-weight:bold;"> Grand Total :</div></td>
						<td align="center"> <div style="font-weight:bold;"> '.($counter - 1).'</div></td>
						<td></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result' => $result, 
		 						'daily_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'daily_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//.......................
// Receipts summary by account names
if(isset($_POST['action']) && $_POST['action'] == 'receipt_details_summry_account_names')
{
	$top_details = '<h5><center>'.date('d/m/Y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/Y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')  
	{
		// statement for pagination
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount, for_opt
				FROM tbl_receipts 
				where '.$where.'  
				group by for_opt
				ORDER BY for_opt ';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0; $receipts = 0;
		while($rec = mysqli_fetch_object($data))
		 {
		      $result .= '<tr>
							<td style="padding:5px 10px;">'.$rec->for_opt.'</td> 
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
							<td style="padding:5px 10px;">'.$rec->receipts.'</td>
							
						  </tr>';
				$counter++;	$sum = $sum + $rec->amount;	$receipts = $receipts + $rec->receipts;
		 }
		 $result .= '<tr>
						<td ><div style="float:left;margin-left:30px;font-weight:bold;"></div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
						<td align="center"> <div style="font-weight:bold;"> '.$receipts.'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result' => $result, 
		 						'daily_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'daily_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//......................
//Receipts Summary by each day
if(isset($_POST['action']) && $_POST['action'] == 'receipt_summary_day')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// statement for pagination
		$sql = 'SELECT sum(amount) as sum , count(*) as total, date 
				FROM tbl_receipts 
				where '.$where.'  
				group by date
				order by date
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0; $total_receipts = 0;
		$days = array('Sun', 'Mon', 'Tues', 'Wed','Thur','Fri', 'Sat');
		while($rec = mysqli_fetch_object($data))
		 {
		      $day = date('w',strtotime($rec->date)); 
			  $result .= '<tr>
							<td style="padding:5px 10px;">'.date('Y-m-d',  strtotime($rec->date)).' &nbsp;&nbsp; '.$days[$day].'</td>
							<td style="padding:5px 10px;">'.$rec->total.'</td>  
							<td style="padding:5px 10px;">$'.$rec->sum.'</td>
						  </tr>';
				$counter++;	$sum = $sum + $rec->sum; $total_receipts = $total_receipts + $rec->total;	  
		 }
		 $result .= '<tr>
						<td ><div style="float:right;margin-right:30px;font-weight:bold;"> Total :</div></td>
						<td align="center"> <div style="font-weight:bold;">'.$total_receipts.'</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result' => $result, 
		 						'date_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'date_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//......................
//Receipts Summary by main_accounts
if(isset($_POST['action']) && $_POST['action'] == 'receipt_summary_main_accounts')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// report for license
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%License"
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0; $total_receipts = 0;
		$rec = mysqli_fetch_object($data);
		$result .= '<tr>
						<td style="padding:5px 10px;float:left;">License</td>
						<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
						<td style="padding:5px 10px;">$'.$rec->amount.'</td>
					</tr>';
		$counter++;	$sum = $sum + $rec->amount; $total_receipts = $total_receipts + $rec->receipts;	  
		
		// report for Moto
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Moto"
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$rec = mysqli_fetch_object($data);
		$result .= '<tr>
						<td style="padding:5px 10px;float:left;">Moto</td>
						<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
						<td style="padding:5px 10px;">$'.$rec->amount.'</td>
					</tr>';
		$counter++;	$sum = $sum + $rec->amount; $total_receipts = $total_receipts + $rec->receipts;	 
		
		// report for Remoor
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Remoor"
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$rec = mysqli_fetch_object($data);
		$result .= '<tr>
						<td style="padding:5px 10px;float:left;">Remoor</td>
						<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
						<td style="padding:5px 10px;">$'.$rec->amount.'</td>
					</tr>';
		$counter++;	$sum = $sum + $rec->amount; $total_receipts = $total_receipts + $rec->receipts;	 
		
		
		// report for Vehicle
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Vehicle"
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$rec = mysqli_fetch_object($data);
		$result .= '<tr>
						<td style="padding:5px 10px;float:left;">Vehicle</td>
						<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
						<td style="padding:5px 10px;">$'.$rec->amount.'</td>
					</tr>';
		$counter++;	$sum = $sum + $rec->amount; $total_receipts = $total_receipts + $rec->receipts;	 
		
		
		 $result .= '<tr style="color:red;">
						<td ><div style="float:left;margin-right:30px;font-weight:bold;"> Total accounts summary 4</div></td>
						<td align="center"> <div style="font-weight:bold;">'.$total_receipts.'</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }
														
		 echo json_encode(array('result' => $result, 
		 						'date_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'date_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//Receipts summary by months
if(isset($_POST['action']) && $_POST['action'] == 'receipt_report_summary_month')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Get data for monthly report
		 $counter = 1; $sum = 0.00; $total_receipt = 0;
		 $first_date = date('m', strtotime($_POST['s_report_from_date']));
		 $year = 0;
		 
		 $second_date = date('m', strtotime($_POST['s_report_to_date']));
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
				$monthly_record[sprintf("%02d", $i)]['sum'] = 0.00; 
				$monthly_record[sprintf("%02d", $i)]['total_receipts'] = 0;
				$monthly_record[sprintf("%02d", $i)]['year'] = 0;
		 }
		 $data = mysqli_query($con,"SELECT * FROM tbl_receipts where date between '".date('Y-m-d', strtotime($_POST['s_report_from_date']))."' and '".date('Y-m-d', strtotime($_POST['s_report_to_date']))."' ");
		 while($rec = mysqli_fetch_object($data))
		 {
			 $record_date = date('m', strtotime($rec->date));
			 $monthly_record[$record_date]['sum'] = $monthly_record[$record_date]['sum'] + $rec->amount;
			 if($year == 0)
			 	$year = date('Y', strtotime($rec->date));
			 $sum = $sum + $rec->amount;
			 
			 $monthly_record[$record_date]['total_receipts'] = $monthly_record[$record_date]['total_receipts'] + 1;
		 }
		 if($year == 0)
			 	$year = date('Y',  strtotime($_POST['s_report_from_date']));
		 $monthly_report = '';
		 for($i = $first_date; $i <= $second_date; $i++)
		 {
		     $monthly_report .= '<tr align="center">
									<td style="padding:5px 10px;">'.get_month_name(sprintf("%02d", $i)).'</td>
									<td style="padding:5px 10px;">'.$monthly_record[sprintf("%02d", $i)]['total_receipts'].'</td>
									<td style="padding:5px 10px;">$'.$monthly_record[sprintf("%02d", $i)]['sum'].'</td>
								</tr>';  
		     $counter++;  $total_receipt = $total_receipt + $monthly_record[sprintf("%02d", $i)]['total_receipts'];
		} 
		     $monthly_report .= '<tr>
							   		<td ><div style="margin-left:30px;font-weight:bold;"> Grand total:</div></td>
									<td align="center"> <div style="font-weight:bold;">'.$total_receipt.'</div></td>
									<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
                                 </tr>';
						
		 echo json_encode(array('result' => $monthly_report, 
		                         'top_details' => $top_details 
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
								'top_details' => $top_details						
		 				));		
}

//......................
//Receipts summary by main accounts and subaccounts
if(isset($_POST['action']) && $_POST['action'] == 'receipt_summary_main_sub_accounts')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// report for license
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount, for_opt
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%License"
				group by for_opt
				order by for_opt	  
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$counter = 1; $sum = 0; $total_receipts = 0; $group_sum = 0;
		$result .= '<tr><td colspan="3" style="padding:5px 10px;float:left;font-weight: bold;text-decoration:underline;">License</td></tr>';
		while($rec = mysqli_fetch_object($data))
		{
			$result .= '<tr>
							<td style="padding:5px 10px;float:left;">'.$rec->for_opt.'</td>
							<td style="padding:5px;">'.$rec->receipts.'</td>  
							<td style="padding:5px;">$'.$rec->amount.'</td>
						</tr>';
			$group_sum = $group_sum + $rec->amount;		
			$counter++;	$sum = $sum + $rec->amount;  $total_receipts = $total_receipts + $rec->receipts;	 	
		}
		 
		$result .= '<tr><td></td><td></td><td  style="padding:5px 10px;font-weight: bold;">$'.$group_sum.'</td></tr>';
		// report for Moto
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount, for_opt
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Moto"
				group by for_opt
				order by for_opt	  
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$group_sum  = 0;
		$result .= '<tr><td colspan="3" style="padding:5px 10px;float:left;font-weight: bold;text-decoration:underline;">Moto</td></tr>';
		while($rec = mysqli_fetch_object($data))
		{
			$result .= '<tr>
							<td style="padding:5px 10px;float:left;">'.$rec->for_opt.'</td>
							<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						</tr>';
			$group_sum = $group_sum + $rec->amount;		
			$counter++;	$sum = $sum + $rec->amount;  $total_receipts = $total_receipts + $rec->receipts;	 	
		}
		 
		$result .= '<tr><td></td><td></td><td  style="padding:5px 10px;font-weight: bold;">$'.$group_sum.'</td></tr>';
		
		// report for Remoor
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount, for_opt
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Remoor"
				group by for_opt
				order by for_opt	  
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$group_sum  = 0;
		$result .= '<tr><td colspan="3" style="padding:5px 10px;float:left;font-weight: bold;text-decoration:underline;">Remoor</td></tr>';
		while($rec = mysqli_fetch_object($data))
		{
			$result .= '<tr>
							<td style="padding:5px 10px;float:left;">'.$rec->for_opt.'</td>
							<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						</tr>';
			$group_sum = $group_sum + $rec->amount;		
			$counter++;	$sum = $sum + $rec->amount;  $total_receipts = $total_receipts + $rec->receipts;	 	
		}
		 
		$result .= '<tr><td></td><td></td><td  style="padding:5px 10px;font-weight: bold;">$'.$group_sum.'</td></tr>';
		
		// report for Vehicle
		$sql = 'SELECT  count(receipt_no) receipts, sum(amount) amount, for_opt
				FROM tbl_receipts 
				where '.$where.'
					  and for_opt like "%Vehicle"
				group by for_opt
				order by for_opt	  
				';
		//cho $sql; exit;
		$data = mysqli_query($con, $sql);
		$group_sum  = 0;
		$result .= '<tr><td colspan="3" style="padding:5px 10px;float:left;font-weight: bold;text-decoration:underline;">Vehicle</td></tr>';
		while($rec = mysqli_fetch_object($data))
		{
			$result .= '<tr>
							<td style="padding:5px 10px;float:left;">'.$rec->for_opt.'</td>
							<td style="padding:5px 10px;">'.$rec->receipts.'</td>  
							<td style="padding:5px 10px;">$'.$rec->amount.'</td>
						</tr>';
			$group_sum = $group_sum + $rec->amount;		
			$counter++;	$sum = $sum + $rec->amount;  $total_receipts = $total_receipts + $rec->receipts;	 	
		}
		 
		$result .= '<tr><td></td><td></td><td  style="padding:5px 10px;font-weight: bold;">$'.$group_sum.'</td></tr>';
		
		
		 $result .= '<tr>
						<td ><div style="float:left;margin-right:30px;font-weight:bold;"> Grand Total:</div></td>
						<td align="center"> <div style="font-weight:bold;">'.$total_receipts.'</div></td>
						<td align="center"> <div style="font-weight:bold;"> $'.number_format($sum,2).'</div></td>
					 </tr>';
		 /*if(mysqli_num_rows($data) == 0)
		 {
			 $result = '<tr><td style="padding:5px 10px;" colspan="6"> No record found</td></tr>';
			 $sum = 0.00;
		 }*/
														
		 echo json_encode(array('result' => $result, 
		 						'date_report_sum' => $sum,
								'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
														<td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'date_report_sum' => '0.00',
								'top_details' => $top_details
						));		
}
//Users activity report
if(isset($_POST['action']) && $_POST['action'] == 'users_activity_report')
{
	$top_details = '<h5><center>'.date('d/m/y', strtotime($_POST['s_report_from_date'])).' - '.date('d/m/y', strtotime($_POST['s_report_to_date'])).'</center></h5>'; 
	$where = '';
	if(isset($_POST['s_report_from_date']) && $_POST['s_report_from_date'] != '' && isset($_POST['s_report_to_date']) && $_POST['s_report_to_date'] != '')
	{
	   $where .= ' AND DATE(created_At) between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Get all users
		$sql = 'select * from tbl_users ';
		$users_data = mysqli_query($con, $sql);
		$counter = 1;
		while($user = mysqli_fetch_object($users_data))
		{
			// count receipts
			$receipts_sql = 'select count(*) receiptes 
							 from tbl_receipts 
							 where createdBy = '.$user->id.'
							 '.$where.'
							 ';
			$receipts_query = mysqli_query($con, $receipts_sql);
			$receipts_data = mysqli_fetch_object($receipts_query);
			// count licence
			$licence_sql = 'select count(*) licence 
							 from tbl_driver_detail 
							 where username = "'.$user->username.'"
							 '.$where.'';
			$licence_query = mysqli_query($con, $licence_sql);
			$licence_data = mysqli_fetch_object($licence_query);
			
			// count vehicle
			$vehicle_sql = 'select count(*) vehicles 
							 from tbl_vehicles 
							 where username = "'.$user->username.'"
							 '.$where.'';
			$vehicle_query = mysqli_query($con, $vehicle_sql);
			$vehicle_data = mysqli_fetch_object($vehicle_query);
			
			// count vehicle Transfer
			$vehicle_transfer_sql = 'select count(*) veh_tansfer 
									 from tbl_vehicle_transfer 
									 where createBy = '.$user->id.'
									 '.$where.'';
			$vehicle_transfer_query = mysqli_query($con, $vehicle_transfer_sql);
			$vehicle_transfer = mysqli_fetch_object($vehicle_transfer_query);
			
			$total_count = (isset($receipts_data->receiptes) ? $receipts_data->receiptes : 0) + 
						    (isset($vehicle_data->vehicle) ? $vehicle_data->vehicle : 0) +
							(isset($licence_data->licence) ? $licence_data->licence : 0) +
							(isset($vehicle_transfer->veh_tansfer) ? $vehicle_transfer->veh_tansfer : 0);
								
			$result .= '<tr>
							<td align="center">'.$counter.'</td>
							<td style="padding:5px 10px;float:left;">'.$user->username.'</td>
							<td style="padding:5px;">'.(isset($receipts_data->receiptes) ? $receipts_data->receiptes : 0).'</td>  
							<td style="padding:5px;">'.(isset($vehicle_data->vehicle) ? $vehicle_data->vehicle : 0).'</td>
							<td style="padding:5px;">'.(isset($licence_data->licence) ? $licence_data->licence : 0).'</td>
							<td style="padding:5px;">'.(isset($vehicle_transfer->veh_tansfer) ? $vehicle_transfer->veh_tansfer : 0).'</td>
							<td style="padding:5px;">'.(isset($total_count) ? $total_count : 0).'</td>
						</tr>';
			$counter++;							 
		}
		
														
		 echo json_encode(array('result' => $result, 
		 						'top_details' => $top_details
								));
	}
	else
	    echo json_encode(array('result' => '<tr>
											 <td style="padding:5px 10px;" colspan="6"> No record found</td></tr>', 
		 						'top_details' => $top_details
						));		
}
?>