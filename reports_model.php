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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('Renewal | License', 'New registration | License', 'Damaged card | License' , 'Lost card | License')
													and (".$where.")   
													group by for_opt
													order by for_opt ");
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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select * from tbl_receipts
													where
													   for_opt in ('Renewal | License', 'New registration | License', 'Damaged card | License' , 'Lost card | License')
													and (".$where.")   
													order by for_opt ");
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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('Renewal | Moto', 'Damaged card | Moto', 'New registration | Moto')
													and (".$where.")   
													group by for_opt
													order by for_opt ");
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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select * from tbl_receipts
													where
													   for_opt in ('Renewal | Moto', 'Damaged card | Moto', 'New registration | Moto')
													and (".$where.")   
													order by for_opt ");
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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		
		 $data = mysqli_query($con,"select amount fee, count(*) number, sum(amount) as total, for_opt from tbl_receipts
													where
													   for_opt in ('Transfer | vehicles', 'Damaged card | vehicles', 'Lost card | vehicles', 'New registration | Vehicles')
													and (".$where.")   
													group by for_opt
													order by for_opt ");
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
	   $where .= ' date between "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_from_date']))).'" and "'.date('Y-m-d', strtotime(mysqli_real_escape_string($con, $_POST['s_report_to_date']))).'" ';  
	}
	$result = '';
	if($where != '')
	{
		// Yearly reports
		 $counter = 1; $sum = 0.00;
		 $sub_sum = 0;
		 $data = mysqli_query($con,"select * from tbl_receipts
													where
													   for_opt in ('Transfer | vehicles', 'Damaged card | vehicles', 'Lost card | vehicles', 'New registration | Vehicles')
													and (".$where.")   
													order by for_opt ");
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
?>