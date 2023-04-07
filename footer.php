</div>
<!-- -------------------------------------------- -->
    <!-- Pop up model  -->
    <div class="modal fade" id="myModal" tabindex="-1" style="width:900px;background-color: transparent;border:none;left:45%;overflow:hidden;" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:auto;">
            <div class="modal-content">
                <div class="modal-header" style="background: #E8E7E7;text-align: center;color: #131212;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Receipt Preview</h4>
                </div>
                <div class="modal-body" id="receipt_preview_popup">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Close</button>
                   <?php /*?> <button type="button" class="btn btn-primary" onclick="del_confirm();" data-dismiss="modal">Yes</button><?php */?>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/accordion.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js">-->

</script>
<script>

function submit_form()
{   // receipt_no from_date received_from amount vehicle_no  for_opt
	var error = 0, is_focus = 0;
	if($('#receipt_no').val() == '')
	{
		 $('#receipt_no').focus();
		 is_focus = 1; error = 1;
	}
	if($('#from_date').val() == '' && is_focus == 0)
	{
		 $('#from_date').focus();
		 is_focus = 1; error = 1;
	}
	if($('#expire_date').val() == '' && is_focus == 0)
	{
		 $('#expire_date').focus();
		 is_focus = 1; error = 1;
	}
	if($('#received_from').val() == '' && is_focus == 0)
	{
		 $('#received_from').focus();
		 is_focus = 1; error = 1;
	}

	if($('#for_opt').val() == '' && is_focus == 0)
	{
		 $('#for_opt').focus();
		 is_focus = 1; error = 1;
	}
	if($('#amount').val() == '' && is_focus == 0)
	{
		 $('#amount').focus();
		 is_focus = 1; error = 1;
	}
	if($('#vehicle_no').val() == '' && is_focus == 0)
	{
		 $('#vehicle_no').focus();
		 is_focus = 1; error = 1;
	}
	if(error == 0)
	{
		<?php if(isset($_GET['id']) && $_GET['id'] != ''){ ?>
		        $('#receipt_form').submit();
		<?php } else { ?>
			$.ajax({
				url:"model/receipt_model.php",
				type:'POST',
				data:'action=validate_receipt_no&receipt_no='+$('#receipt_no').val(),
				beforeSend: function(){
					//$('#receipt_records_pagination').html('');
					//$('#receipt_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					if(result == 'yes')
					{
						$('#show_error_msg').show().text('ERROR !  Receipt number is already exists.');
						$('#receipt_no').focus();
					}
					else if(result == 'no')
					{
						$('#receipt_form').submit();
					}
				}
			});
		<?php } ?>
	}
		//$('#receipt_form').submit();
}
setTimeout(function(){
	$('.alert').fadeOut(3000);
},4000);

// Ajax calls for search...
var s_name = '', s_receipt_no = '', s_from_date = '', s_to_date = '',receipt_records = '', receipt_records_pagination = '';
function get_record_by_name(val)
{
	s_name = val;
	get_records();
}
function get_record_by_receipt_no(val)
{
	s_receipt_no = val;
	get_records();
}
function get_record_by_from_date(val)
{
	s_from_date = val;
	get_records();
}
function get_record_by_to_date(val)
{
	s_to_date = val;
	get_records();
}
// ajax call
function get_records()
{
	if(receipt_records == '')
	{
	    receipt_records = $('#receipt_records').html();
		receipt_records_pagination = $('#receipt_records_pagination').html();
	}
	if(s_name != '' || s_receipt_no != '' || (s_from_date != '' && s_to_date != ''))
	{
		$.ajax({
			url:"model/receipt_model.php",
			type:'POST',
			data:'search_name='+s_name+'&s_receipt_no='+s_receipt_no+'&s_from_date='+s_from_date+'&s_to_date='+s_to_date,
			beforeSend: function(){
				$('#receipt_records_pagination').html('');
				$('#receipt_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#receipt_records').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#receipt_records').html(data.result);
					$('#receipt_records_pagination').html(data.pagination);
				}
			}
		});

	}
	else
	{
		if(receipt_records != '')
		{
		 	$('#receipt_records').html(receipt_records);
			$('#receipt_records_pagination').html(receipt_records_pagination);
		}
	}
}

// Account list Form
function account_list()
{
	$('#acc_form_sub_btn').trigger('click');
	//$('#account_list_form').submit();
}
// acc type
function account_type()
{
	$('#acc_type_form_sub_btn').trigger('click');
	//$('#account_type_form').submit();
}
// Search Accounts list w.r.t data
var acc_lit_records = '';
function get_account_data_date(date)
{
	if(acc_lit_records == '')
	{
	    acc_lit_records = $('#account_list_records').html();
		acc_lit_records_pagination = $('#account_list_records_pagination').html();
	}
	if(date != '')
	{
		$.ajax({
			url:"model/accounts_model.php",
			type:'POST',
			data:'s_by_date='+date+'&action=search_account_list_by_date',
			beforeSend: function(){
				$('#account_list_records_pagination').html('');
				$('#account_list_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#account_list_records').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#account_list_records').html(data.result);
					$('#account_list_records_pagination').html(data.pagination);
				}
			}
		});

	}
	else
	{
		if(receipt_records != '')
		{
		 	$('#account_list_records').html(acc_lit_records);
			$('#account_list_records_pagination').html(acc_lit_records_pagination);
		}
	}
}
</script>
<script type="text/javascript">

    // show preview...
	function show_receipt_preview_popup()
	{
		for(var i = 1; i <=2; i++){
			$('#p_r_receipt_no_'+i).text(' Receipt No :'+$('#receipt_no').val());
			$('#p_r_date_'+i).text(' Date: '+$('#from_date').val());
			$('#p_r_time_'+i).text(' Time:  <?php echo date('H:i');?>');
			$('#p_r_received_from_'+i).text($('#received_from').val());
			$('#p_r_amount_'+i).text('$'+$('#amount').val());
			$('#p_r_amount_word_'+i).text(toWords($('#amount').val()));
			$('#p_r_for_'+i).text($('#for_opt').val());
			$('#p_r_vechical_no_'+i).text($('#vehicle_no').val());
			var comnet_str = $('#comments').val();
			if(comnet_str.length > 50)
			     $('#p_r_comment_'+i).css('width','auto');
			else
			     $('#p_r_comment_'+i).css('width','200px');
			$('#p_r_comment_'+i).text($('#comments').val());
			$('#p_r_accountant_'+i).text('');
		}
		$('#receipt_preview_popup').html($('#tab').html());
	}
	// Print section for receipts
    function PrintElem(elem)
    {    // receipt_no from_date received_from amount vehicle_no  for_opt
        // p_r_receipt_no  p_r_date  p_r_time   p_r_received_from  p_r_amount  p_r_amount_word  p_r_for   p_r_vechical_no  p_r_comment  p_r_accountant
		for(var i = 1; i <=2; i++){
			$('#p_r_receipt_no_'+i).text(' Receipt No :'+$('#receipt_no').val());
			$('#p_r_date_'+i).text(' Date: '+$('#from_date').val());
			$('#p_r_time_'+i).text(' Time:  <?php echo date('H:i');?>');
			$('#p_r_received_from_'+i).text($('#received_from').val());
			$('#p_r_amount_'+i).text('$'+$('#amount').val());
			$('#p_r_amount_word_'+i).text(toWords($('#amount').val()));
			$('#p_r_for_'+i).text($('#for_opt').val());
			$('#p_r_vechical_no_'+i).text($('#vehicle_no').val());
			var comnet_str = $('#comments').val();
			if(comnet_str.length > 50)
			     $('#p_r_comment_'+i).css('width','auto');
			else
			     $('#p_r_comment_'+i).css('width','200px');
			$('#p_r_comment_'+i).text($('#comments').val());
			$('#p_r_accountant_'+i).text('');
		}

		Popup($(elem).html());
    }
    // Print for vehicles
	function PrintVehicle(elem)
    {
	    if($('#search_vehicle_no').val() == '')
		    $('#search_vehicle_no').focus();
		else
			Popup($(elem).html());
    }
	// Print for vehicles
	function PrintVehicle_auto(elem)
    {
	    Popup($(elem).html());
    }
	// Report module
	function PrintReports(elem)
	{
		Popup($(elem).html());
	}
	
    function Popup(data)
    {
        var mywindow = window.open('', 'Report', 'height=600,width=600');
		mywindow.document.write('<html><head>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }
	// Licence module
	function PrintLicence_img(elem)
	{
		Popup2($(elem).html());
	}
	function Popup2(data)
    {
        var mywindow = window.open('', '', 'height=500,width=700');
		mywindow.document.write('<html><head>');
        /*optional stylesheet*/ //mywindow.document.write('<link rel="stylesheet" href="main.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('</body></html>');
        
		
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();

        return true;
    }

// Ajax Pagination
function call_pagination(page)
{
	$.ajax({
		url: 'model/accounts_model.php',
		type:'POST',
		data: 'action=account_type_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#acc_type_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#acc_type_records').html(data.result);
			if(data.pagination != '')
			    $('#pagination_area').html(data.pagination);
		}
	});
}
// Receipt Ajax Pagination
function receipt_ajax_pagination(page)
{
	$.ajax({
		url: 'model/receipt_model.php',
		type:'POST',
		data: 'action=receipt_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#receipt_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#receipt_records').html(data.result);
			if(data.pagination != '')
			    $('#receipt_records_pagination').html(data.pagination);
		}
	});
}
// Receipt Ajax Pagination for vechile module
function receipt_ajax_pagination_vehicle(page)
{
	$.ajax({
		url: 'model/receipt_model.php',
		type:'POST',
		data: 'action=receipt_ajax_pagination_vehicle&page='+page,
		beforeSend: function(){
			$('#receipt_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#receipt_records').html(data.result);
			if(data.pagination != '')
			    $('#receipt_records_pagination').html(data.pagination);
		}
	});
}
// Account List Ajax Pagination
function acc_list_ajax_pagination(page)
{
	$.ajax({
		url: 'model/accounts_model.php',
		type:'POST',
		data: 'action=account_list_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#account_list_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#account_list_records').html(data.result);
			if(data.pagination != '')
			    $('#account_list_records_pagination').html(data.pagination);
		}
	});
}
// Get account amout for receipt
function get_acc_amount(val)
{
	if(val != ''){
		$.ajax({
			url: 'model/accounts_model.php',
			type:'POST',
			data: 'action=get_account_amount_for_receipt&account_name='+val,
			beforeSend: function(){
				//$('#account_list_records').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success: function(result){
					if(result != ''){
						$('#amount').val(result);
					}
			}
		});
	}
}
</script>
<script type="text/javascript">
// American Numbering System
var th = ['', 'thousand', 'million', 'billion', 'trillion'];

var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];

var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];

var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

function toWords(s) {
    s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s)) return 'not a number';
    var x = s.indexOf('.');
    if (x == -1) x = s.length;
    if (x > 15) return 'too big';
    var n = s.split('');
    var str = '';
    var sk = 0;
    for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';
                sk = 1;
            }
        } else if (n[i] != 0) {
            str += dg[n[i]] + ' ';
            if ((x - i) % 3 == 0) str += 'hundred ';
            sk = 1;
        }
        if ((x - i) % 3 == 1) {
            if (sk) str += th[(x - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    if (x != s.length) {
        var y = s.length;
        str += ' dollars and ';
        for (var i = x + 1; i < y; i++) {  if(dg[n[i]] == 'zero' && dg[n[(i + 1)]] == 'zero'){ str += ' Zero'; i = i + 1; } else str += dg[n[i]] + ' ' };
		str += ' Cents'
    }
    return str.replace(/\s+/g, ' ');

}


/* ----------------------------------------------------------------------------------
   **********************************************************************************
   							       USERS MODULE
   **********************************************************************************
   ----------------------------------------------------------------------------------
*/
function add_new_user()
{
	$('#submit_form').trigger('click');
}
/* ----------------------------------------------------------------------------------
   **********************************************************************************
   							       Vehicles MODULE
   **********************************************************************************
   ----------------------------------------------------------------------------------
*/

// Ajax Pagination
function vehicles_pagination(page)
{
	$.ajax({
		url: 'model/vehicles_model.php',
		type:'POST',
		data: 'action=vehicles_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#vechicle_records_area').html(data.result);
			if(data.pagination != '')
			    $('#pagination_area_vehicle').html(data.pagination);
		}
	});
}
// Ajax calls for search...
var s_v_name = '', s_v_number = '', v_type = '', v_contact = '', vehicle_records = '', vehicle_records_pagination = '';
function get_v_record_by_number(val)
{
	s_v_number = val;
	get_vehicle_records();
}
function get_v_record_by_name(val)
{
	s_v_name = val;
	get_vehicle_records();
}
function get_v_record_by_v_type(val)
{
	v_type = val;
	get_vehicle_records();
}
function get_v_record_by_v_contact(val)
{
	v_contact = val;
	get_vehicle_records();
}

// ajax call
function get_vehicle_records()
{
	if(vehicle_records == '')
	{
	    vehicle_records = $('#vechicle_records_area').html();
		vehicle_records_pagination = $('#pagination_area_vehicle').html();
	}
	if(s_v_name != '' || s_v_number != '' || v_type != '' || v_contact != '')
	{   // s_v_name  s_v_number s_v_nationality
		$.ajax({
			url:"model/vehicles_model.php",
			type:'POST',
			data:'s_v_name='+s_v_name+'&s_v_number='+s_v_number+'&v_type='+v_type+'&v_contact='+v_contact,
			beforeSend: function(){
				$('#pagination_area_vehicle').html('');
				$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#vechicle_records_area').html(data.result);
					$('#pagination_area_vehicle').html(data.pagination);
				}
			}
		});

	}
	else
	{
		if(vehicle_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/vehicles_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#pagination_area_vehicle').html('');
					$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#vechicle_records_area').html(vehicle_records);
					$('#pagination_area_vehicle').html(vehicle_records_pagination);
				}
			});



		}
	}
}
// Ajax Pagination vechicle card list
function vehicles_card_pagination(page)
{
	$.ajax({
		url: 'model/vehicles_model.php',
		type:'POST',
		data: 'action=vehicles_cardlist_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#vechicle_card_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#vechicle_card_records_area').html(data.result);
			if(data.pagination != '')
			    $('#pagination_card_area_vehicle').html(data.pagination);
		}
	});
}
// Ajax calls for search...
var s_v_cardlist_name = '', s_v_cardlist_from_date = '', v_cardlist_to_date = '',vehicle_cardlist_records = '', vehicle_cardlist_records_pagination = '';
function get_v_card_record_by_from_date(val)
{   
	s_v_cardlist_from_date = val;
	get_vehicle_cardlist_records();
}
function get_v_card_record_by_name(val)
{
	s_v_cardlist_name = val;
	get_vehicle_cardlist_records();
}
function get_v_card_record_by_to_date(val)
{
	v_cardlist_to_date = val;
	get_vehicle_cardlist_records();
}

// ajax call
function get_vehicle_cardlist_records()
{
	if(vehicle_cardlist_records == '')
	{
	    vehicle_cardlist_records = $('#vechicle_card_records_area').html();
		vehicle_cardlist_records_pagination = $('#pagination_card_area_vehicle').html();
	}
	if(s_v_cardlist_name != '' || (s_v_cardlist_from_date != '' && v_cardlist_to_date != ''))  
	{   // s_v_name  s_v_number s_v_nationality 
	
		$.ajax({
			url:"model/vehicles_model.php",
			type:'POST',
			data:'s_v_card_name='+s_v_cardlist_name+'&s_v_card_from_date='+s_v_cardlist_from_date+'&v_card_to_date='+v_cardlist_to_date,
			beforeSend: function(){
				$('#pagination_card_area_vehicle').html('');
				$('#vechicle_card_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#vechicle_card_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#vechicle_card_records_area').html(data.result);
					$('#pagination_card_area_vehicle').html(data.pagination);
				}
			}
		});

	}
	else
	{
		if(vehicle_cardlist_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/vehicles_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#pagination_card_area_vehicle').html('');
					$('#vechicle_card_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#vechicle_card_records_area').html(vehicle_cardlist_records);
					$('#pagination_card_area_vehicle').html(vehicle_cardlist_records_pagination);
				}
			});



		}
	}
}
/* ----------------------------------------------------------------------------------
   **********************************************************************************
   							       Vehicles MODULE
   **********************************************************************************
   ----------------------------------------------------------------------------------
*/

var s_report_from_date = '', s_report_to_date = '';
	  
var vehicle_plate = '';
function get_reports_by_date(val)
{
	s_report_from_date = val;
	//get_reports_records();
}
function get_reports_to_date(val)
{
	s_report_to_date = val;
	//get_reports_records();
}
function get_reports_vehicle_plate(val)
{
	vehicle_plate = val;
	//get_reports_records();
}
// ajax call

function get_reports_records()
{
   
	if(s_report_from_date != '' && s_report_to_date != '')
	{   // s_v_name  s_v_number s_v_nationality
		$('.table .glyphicon').hide();
		// Daily report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=daily_report&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Daily Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#daily_report_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#daily_report_area').html(data.result_daily_report);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#daily_report_period').html(data.top_details);
					$('#daily_report_print_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		// Receipt by Date report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_by_day_report&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#daily_report_by_day_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#daily_report_by_day_area').html(data.result_by_date_report);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#daily_report_by_date_period').html(data.top_details);
					$('#daily_report_by_day_print_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		// monthly report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=monthly_report&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Monthly Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.monthly_report == '')
					$('#monthly_report_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#monthly_report_area').html(data.monthly_report);
					
				}
				$('#monthly_report_tab_top_details').html(data.top_details);
				$('#monthly_report_print_icon').show(); 
				$('#show_error_msg').hide().html('');
			}
		});
		
		//     
		// licence summary report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=licence_summary&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.licence_report == '')
					$('#licence_summary_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#licence_summary_area').html(data.licence_report);
					
				}
				$('#licence_summary_tab_top_details').html(data.top_details);
				$('#licence_summry_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		// licence detail
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=licence_detail&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.licence_report == '')
					$('#licence_detail_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#licence_detail_area').html(data.licence_report);
					
				}
				$('#licence_detail_tab_top_details').html(data.top_details);
				$('#licence_report_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		// moto summary report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=moto_summary&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.moto_report == '')
					$('#moto_summary_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#moto_summary_area').html(data.moto_report);
					
				}
				$('#moto_summary_tab_top_details').html(data.top_details);
				$('#moto_sum_report_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		// Moto detail        
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=moto_detail&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');
				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.moto_report == '')
					$('#moto_detail_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#moto_detail_area').html(data.moto_report);
					
				}
				$('#moto_detail_tab_top_details').html(data.top_details);
				$('#moto_report_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		//--------------------        
		// vehicle summary report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=vehicle_summary&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');
				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.vehicle_report == '')
					$('#vehicle_summary_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#vehicle_summary_area').html(data.vehicle_report);
					
				}
				$('#vehicle_summary_tab_top_details').html(data.top_details);
				$('#vehicle_sum_report_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		// Moto detail
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=vehicle_detail&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading  Report, Please Wait ....');
				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.vehicle_report == '')
					$('#vehicle_detail_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#vehicle_detail_area').html(data.vehicle_report);
					
				}
				$('#vehicle_detail_tab_top_details').html(data.top_details);
				$('#vehicle_report_print_icon').show();
				$('#show_error_msg').hide().html('');
			}
		});
		//  Receipt Report with account names
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_report_account_names&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Receipt Report with account names,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#receipt_detail_with_account_name_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_detail_with_account_name_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_detail_with_account_name #report_period').html(data.top_details);
					$('#receipt_details_account_names_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		//  Receipts grouped by account names
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_detail_grouped_account_name&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Receipt Report  grouped by account names,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#receipt_detail_grouped_account_name_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_detail_grouped_account_name_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_detail_grouped_account_name #report_period').html(data.top_details);
					$('#receipt_details_group_account_names_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		//  Receipts summary by account names
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_details_summry_account_names&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Receipt Report  grouped by account names,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#receipt_detail_grouped_account_name_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_details_summry_account_names_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_details_summry_account_names #report_period').html(data.top_details);
					$('#receipt_details_summry_account_names_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		// Receipts Summary by each day
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_summary_day&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result_daily_report == '')
					$('#receipt_summary_day_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_summary_day_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_summary_day #report_period').html(data.top_details);
					$('#receipt_summary_day_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		// Receipts Summary by Main accounts
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_summary_main_accounts&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#receipt_summary_main_accounts_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_summary_main_accounts_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_summary_main_accounts #report_period').html(data.top_details);
					$('#receipt_summary_main_accounts_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		//Receipts summary by months
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_report_summary_month&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Monthly Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#receipt_report_summary_month_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_report_summary_month_area').html(data.result);
					
				}
				$('#receipt_report_summary_month #report_period').html(data.top_details);
				$('#receipt_report_summary_month_icon').show(); 
				$('#show_error_msg').hide().html('');
			}
		});
		// Receipts summary by main accounts and subaccounts
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=receipt_summary_main_sub_accounts&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date,
			beforeSend: function(){
				$('#show_error_msg').show().html('Loading Report,.....');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#receipt_summary_main_sub_accounts_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#receipt_summary_main_sub_accounts_area').html(data.result);
					//$('#daily_report_sum').html(data.daily_report_sum);
					$('#receipt_summary_main_sub_accounts #report_period').html(data.top_details);
					$('#receipt_summary_main_sub_accounts_icon').show();
					$('#show_error_msg').hide().html('');  
					
				}
			}
		});
		// tax report  
		/*$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=vehicle_tax_report&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date+'&vehicle_no='+vehicle_plate,
			beforeSend: function(){
				//$('#pagination_area_vehicle').html('');
				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){ 
				var data = $.parseJSON(result);
				if(data.v_tax_result == '')
					$('#vehicle_tax_report_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{  
					$('#vehicle_tax_report_area').html(data.v_tax_result);
					$('#vehicle_tax_report_top_details').html(data.v_tax__top_details);
					
				}
			}
		});
		// road tax no renewed report
		$.ajax({
			url:"model/reports_model.php",
			type:'POST',
			data:'action=road_tax_report&s_report_from_date='+s_report_from_date+'&s_report_to_date='+s_report_to_date+'&vehicle_no='+vehicle_plate,
			beforeSend: function(){
				//$('#pagination_area_vehicle').html('');
				//$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){  
				var data = $.parseJSON(result);  
				if(data.road_tax_result == '')
					$('#road_tax_report_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{   
					$('#road_tax_report_area').html(data.road_tax_result);
					$('#road_tax_report_top_area').html(data.road_tax_result_top_details);
					
				}
			}
		});*/

	}
	else
	{
		$('#show_error_msg').show().html('Please Enter Dates.');
		$('.from_date').focus();
	}

}

<?php if(isset($_GET['p']) && $_GET['p'] == 'road_tax_report'){ ?>
		   $('#road_tax_report_top_area').html('<center>Period : '+s_report_from_date+' - '+s_report_to_date+'</center>');
		   $('#print_road_tax').trigger('click');
<?php } ?>	
<?php if(isset($_GET['section']) && $_GET['section'] == 'vehicle_search') { ?>	
      // 
	  
	 $(document).ready(function(e) {
       $('#print_vehicle').trigger('click'); 
    });
<?php } ?>	   

<!-- /////////////////////////////////////////////////////////////////////// -->

// Ajax Pagination
function licence_pagination(page)
{
	$.ajax({
		url: 'model/licence_model.php',
		type:'POST',
		data: 'action=licence_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#licence_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#licence_record_area').html(data.result);
			if(data.pagination != '')
			    $('#licence_pagination_area').html(data.pagination);
		}
	});
}   
// Ajax calls for search licence...
var s_l_name = '', s_licence_no = '', s_l_nationality = '', s_l_contact = '', licence_records = '', licence_records_pagination = '';
function get_l_record_by_no(val)
{
	s_licence_no = val;
	get_licence_records();
}
function get_l_record_by_name(val)
{
	s_l_name = val;
	get_licence_records();
}
function get_l_record_by_nationality(val)
{
	s_l_nationality = val;
	get_licence_records();
}
function get_l_record_by_contact(val)
{
	s_l_contact = val;
	get_licence_records();
}

// ajax call
function get_licence_records()
{
	if(licence_records == '')  
	{
	    licence_records = $('#licence_record_area').html();
		licence_records_pagination = $('#licence_pagination_area').html();
	}
	if(s_licence_no != '' || s_l_name != '' || s_l_nationality != '' || s_l_contact != '')
	{   // s_licence_no  s_l_name s_l_nationality
		$.ajax({
			url:"model/licence_model.php",
			type:'POST',
			data:'s_licence_no='+s_licence_no+'&s_l_name='+s_l_name+'&s_l_nationality='+s_l_nationality+'&s_l_contact='+s_l_contact,
			beforeSend: function(){
				$('#licence_pagination_area').html('');
				$('#licence_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#licence_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#licence_record_area').html(data.result);
					$('#licence_pagination_area').html(data.pagination);
				}
			}
		});

	}
	else
	{
		if(licence_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/licence_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#licence_pagination_area').html('');
					$('#licence_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#licence_record_area').html(licence_records);
					$('#licence_pagination_area').html(licence_records_pagination);
				}
			});



		}
	}
}


// Ajax Pagination for licence card list
function licence_card_pagination(page)
{  
	$.ajax({
		url: 'model/licence_model.php',
		type:'POST',
		data: 'action=licence_ajax_pagination_card&page='+page,
		beforeSend: function(){
			$('#licence_card_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#licence_card_record_area').html(data.result);
			if(data.pagination != '')
			    $('#licence_card_pagination_area').html(data.pagination);
		}
	});
} 
// Ajax calls for search licence card list...
var l_from_date = '', l_to_date = '', licence_card_records = '', licence_card_records_pagination = '';
function get_l_record_by_from_date(val)
{
	l_from_date = val;
	get_licence_card_records();
}
function get_l_record_by_to_date(val)
{
	l_to_date = val;
	get_licence_card_records();
}

// ajax call
function get_licence_card_records()
{
	if(licence_card_records == '')   
	{
	    licence_card_records = $('#licence_card_record_area').html();
		licence_card_records_pagination = $('#licence_card_pagination_area').html();
	}
	if(l_from_date != '' && l_to_date != '')
	{   // l_from_date  l_to_date
		$.ajax({

			url:"model/licence_model.php",
			type:'POST',
			data:'l_from_date='+l_from_date+'&l_to_date='+l_to_date,
			beforeSend: function(){
				$('#licence_card_pagination_area').html('');
				$('#licence_card_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);
				if(data.result == '')
					$('#licence_card_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#licence_card_record_area').html(data.result);
					$('#licence_card_pagination_area').html(data.pagination);
				}
			}
		});

	}
	else
	{    
		if(licence_card_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/licence_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement_card',
				beforeSend: function(){
					$('#licence_pagination_area').html('');
					$('#licence_record_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#licence_card_record_area').html(licence_card_records);
					$('#licence_card_pagination_area').html(licence_card_records_pagination);
				}
			});



		}
	}
}
 function submit_card_licence_form()
 {
	 $('#sub_btn_add_licence_card').trigger('click');
 }
 
 // Ajax Pagination for licence renewal list     
function licence_renewal_pagination(page)
{  
	$.ajax({
		url: 'model/licence_renewal_model.php',
		type:'POST',
		data: 'action=licence_ajax_pagination_renewal_list&page='+page,
		beforeSend: function(){
			$('#licence_renewal_data_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			$('#licence_renew_success_msg').html('').hide();
			$('#licence_renew_error_msg').html('').hide();				
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#licence_renewal_data_area').html(data.result);
			if(data.pagination != '')
			    $('#licence_renewal_pagination_area').html(data.pagination);
		}
	});
} 
// 
function get_latest_licence_renewal_record()
{   
	var Licene_no = $('#licence_renewal_licence_no').val(); 
	if(Licene_no != '')
	{
		$.ajax({
			url: 'model/licence_renewal_model.php',
			type:'POST',
			data: 'action=latest_date_for_licence_renewal&licence_no='+Licene_no,
			beforeSend: function(){
				$('#licence_renewal_data_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				//$('#licence_renew_success_msg').html('').hide();
				//$('#licence_renew_error_msg').html('').hide();
			},
			success: function(result){ 
				var data = $.parseJSON(result); 
				if(data.result != '')
					$('#licence_renewal_data_area').html(data.result);
				if(data.pagination != '')
					$('#licence_renewal_pagination_area').html(data.pagination);
			}
		});
	}
	else
	  $('#licence_renew_error_msg').show().text('ERROR !  Some thing wrong, please refersh page.');
}
function licence_renewal_delete_record(recordID)
{  
	var is_confirm = confirm('Are your sure to delete this record ?');
	if(is_confirm)
	{
		$.ajax({
			url: 'model/licence_renewal_model.php',
			type:'POST',
			data: 'action=licence_renewal_delete_record&recordID='+recordID,
			beforeSend: function(){
				$('#licence_renew_success_msg').html('').hide();
				$('#licence_renew_error_msg').html('').hide();				
			},
			success: function(result){ 
				if(result == 'yes')
				{
					$('#licence_renew_success_msg').show().text('Record deleted successfully.');
					get_latest_licence_renewal_record();
				}
				else 
				{
					$('#licence_renew_error_msg').show().text('ERROR !  Some thing wrong, please try again.');
					
				}
			}
		});
	}
} 
function get_receipt_data(receipt_no)
{   
	if(receipt_no != '')
	{
		$.ajax({
			url: 'model/licence_model.php',
			type:'POST',
			data: 'action=licence_get_receipt_data&receipt_no='+receipt_no,
			beforeSend: function(){
					$('#show_error_msg').hide().text('Please wait ...');		
			},
			success: function(result){ 
				var data = $.parseJSON(result);   
				if(data.result == 'yes')
				{   
				    $('.licence_receipt_fee').val(data.fees);
					$('.licence_receipt_holder_name').val(data.holder_name);
					$('.licence_receipt_issueDate').val(data.issue_date);
					$('.expire_date').val(data.expire_date);
					$('#show_error_msg').hide().text('');
				}
				else 
				{
					$('#show_error_msg').show().text('ERROR !  Receipt number not exists.');
					$('.licence_receipt_fee').val('');
					$('.licence_receipt_holder_name').val('');
					$('.licence_receipt_issueDate').val('');
					$('.expire_date').val('');
					
				}
			}
		});
	}
	
}
function get_receipt_data_licence_renew(receipt_no)
{   
	if(receipt_no != '')
	{
		$.ajax({
			url: 'model/licence_model.php',
			type:'POST',
			data: 'action=licence_get_receipt_data&receipt_no='+receipt_no,
			beforeSend: function(){
				$('#licence_renew_success_msg').show().text('Please Wait.....');			
			},
			success: function(result){ 
				var data = $.parseJSON(result);   
				if(data.result == 'yes')
				{         
				    $('.licence_renew_fee').val(data.fees);
					//$('.licence_receipt_holder_name').val(data.holder_name);
					$('.licence_renew_issue_date').val(data.issue_date);
					$('.licence_renew_expire_date').val(data.expire_date);
					$('#licence_renew_error_msg').hide().text('');
					$('#licence_renew_success_msg').show().text('');
				}
				else 
				{
					$('#licence_renew_error_msg').show().text('ERROR !  Receipt number not exists.');
					$('.licence_renew_fee').val('');
					//$('.licence_receipt_holder_name').val('');
					$('.licence_renew_issue_date').val('');
					$('.licence_renew_expire_date').val('');
					$('#licence_renew_success_msg').show().text('');
					
				}
			}
		});
	}
	
}

// Ajax calls for search for vehicle card...
var s_v_card_from_date = '', s_v_card_to_date = '',vehicle_card_records = '', vehicle_card_records_pagination = '';
function get_v_card_record_from_date(val)
{
	s_v_card_from_date = val;
	get_vehicle_card_records();
}
function get_v_card_record_to_date(val)
{
	s_v_card_to_date = val;
	get_vehicle_card_records();
}


// ajax call
function get_vehicle_card_records()
{
	if(vehicle_card_records == '')
	{
	    vehicle_card_records = $('#vechicle_records_area').html();
		vehicle_card_records_pagination = $('#pagination_area_vehicle').html();
	}
	if(s_v_card_from_date != '' && s_v_card_to_date != '' )
	{   // s_v_card_from_date  s_v_card_to_date
		$.ajax({
			url:"model/vehicles_transfer_model.php",
			type:'POST',
			data:'s_v_card_from_date='+s_v_card_from_date+'&s_v_card_to_date='+s_v_card_to_date,
			beforeSend: function(){
				$('#pagination_area_vehicle').html('');
				$('#vechicle_records_area').html('<tr><td colspan="12" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);  
				if(data.result == '')
					$('#vechicle_records_area').html('<tr><td colspan="12" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#vechicle_records_area').html(data.result);
					$('#pagination_area_vehicle').html(data.pagination);
					 
				}
			}
		});

	}
	else
	{
		if(vehicle_card_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/vehicles_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#pagination_area_vehicle').html('');
					$('#vechicle_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#vechicle_records_area').html(vehicle_card_records);
					$('#pagination_area_vehicle').html(vehicle_card_records_pagination);
				}
			});



		}
	}
}

// Vehicle REnewal
// 
function get_latest_vehicle_renewal_record()
{   
	var plate_no = $('#vehicle_renewal_plate_no').val(); 
	if(plate_no != '')
	{
		$.ajax({
			url: 'model/vehicle_renewal_model.php',
			type:'POST',
			data: 'action=latest_date_for_vehicle_renewal&plate_no='+plate_no,
			beforeSend: function(){
				$('#vehicle_renewal_data_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				//$('#licence_renew_success_msg').html('').hide();
				//$('#licence_renew_error_msg').html('').hide();
			},
			success: function(result){ 
				var data = $.parseJSON(result); 
				if(data.result != '')
					$('#vehicle_renewal_data_area').html(data.result);
				if(data.pagination != '')
					$('#licence_renewal_pagination_area').html(data.pagination);
			}
		});
	}
	else
	  $('#licence_renew_error_msg').show().text('ERROR !  Some thing wrong, please refersh page.');
}
// Ajax Pagination for vehicle renewal list     
function vehicle_renewal_pagination(page)
{  
	$.ajax({
		url: 'model/vehicle_renewal_model.php',
		type:'POST',
		data: 'action=licence_ajax_pagination_renewal_list&page='+page,
		beforeSend: function(){
			$('#vehicle_renewal_data_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
			$('#licence_renew_success_msg').html('').hide();
			$('#licence_renew_error_msg').html('').hide();				
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#vehicle_renewal_data_area').html(data.result);
			if(data.pagination != '')
			    $('#licence_renewal_pagination_area').html(data.pagination);
		}
	});
} 
function vehicle_renewal_delete_record(recordID)
{  
	var is_confirm = confirm('Are your sure to delete this record ?');
	if(is_confirm)
	{
		$.ajax({
			url: 'model/vehicle_renewal_model.php',
			type:'POST',
			data: 'action=veh_renewal_delete_record&recordID='+recordID,
			beforeSend: function(){
				$('#licence_renew_success_msg').html('').hide();
				$('#licence_renew_error_msg').html('').hide();				
			},
			success: function(result){ 
				if(result == 'yes')
				{
					$('#licence_renew_success_msg').show().text('Record deleted successfully.');
					get_latest_vehicle_renewal_record();
				}
				else 
				{
					$('#licence_renew_error_msg').show().text('ERROR !  Some thing wrong, please try again.');
					
				}
			}
		});
	}
} 
/* ----------------------------------------------------------------------------------
   **********************************************************************************
   							       Fine MODULE
   **********************************************************************************
   ----------------------------------------------------------------------------------
*/
// Ajax Pagination
function fine_pagination(page)
{
	$.ajax({
		url: 'model/fine_model.php',
		type:'POST',
		data: 'action=fine_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#fine_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#fine_records_area').html(data.result);
			if(data.pagination != '')
			    $('#pagination_area').html(data.pagination);
		}
	});
}

// Ajax calls for search for fine...
var s_fine_by_fine_no = '', s_fine_plate_no = '', s_fine_licence_no = '', fine_records = '', fine_records_pagination = '';
function get_fine_data_by_fine_no(val)
{ 
	s_fine_by_fine_no = val;
	get_traffic_fine_data();
}
function get_fine_data_by_plate_no(val)
{
	s_fine_plate_no = val;
	get_traffic_fine_data();
}
function get_fine_data_by_licence_no(val)
{
	s_fine_licence_no = val;
	get_traffic_fine_data();
}

// ajax call
function get_traffic_fine_data()
{
	if(fine_records == '')
	{
	    fine_records = $('#fine_records_area').html();
		fine_records_pagination = $('#pagination_area').html();
	}
	if(s_fine_by_fine_no != '' || s_fine_plate_no != '' || s_fine_licence_no != '')
	{   // s_fine_by_fine_no  s_fine_plate_no  s_fine_licence_no
		$.ajax({
			url:"model/fine_model.php",
			type:'POST',
			data:'s_fine_by_fine_no='+s_fine_by_fine_no+'&s_fine_plate_no='+s_fine_plate_no+'&s_fine_licence_no='+s_fine_licence_no,
			beforeSend: function(){
				$('#pagination_area').html('');
				$('#fine_records_area').html('<tr><td colspan="12" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);  
				if(data.result == '')
					$('#fine_records_area').html('<tr><td colspan="12" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#fine_records_area').html(data.result);
					$('#pagination_area').html(data.pagination);
					 
				}
			}
		});

	}
	else
	{
		if(fine_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/vehicles_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#pagination_area').html('');
					$('#fine_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#fine_records_area').html(fine_records);
					$('#pagination_area').html(fine_records_pagination);
				}
			});



		}
	}
}
// Ajax Pagination
function fine_master_pagination(page)
{
	$.ajax({
		url: 'model/fine_model.php',
		type:'POST',
		data: 'action=master_fine_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#master_fine_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#master_fine_records_area').html(data.result);
			if(data.pagination != '')
			    $('#master_pagination_area').html(data.pagination);
		}
	});
}

//// Ajax Pagination
function fine_pay_pagination(page)
{
	$.ajax({
		url: 'model/fine_model.php',
		type:'POST',
		data: 'action=fine_pay_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#fine_pay_detail_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#fine_pay_detail_area').html(data.result);
			if(data.pagination != '')
			    $('#fine_pay_pagination_area').html(data.pagination);
		}
	});
}
// Ajax calls for search for fine pay section...
var s_fine_pay_by_fine_no = '', s_fine_pay_plate_no = '', s_fine_pay_licence_no = '', fine_pay_records = '', fine_pay_records_pagination = '';
function get_fine_pay_data_by_fine_no(val)
{ 
	s_fine_pay_by_fine_no = val;
	get_traffic_fine_pay_data();
}
function get_fine_pay_data_by_plate_no(val)
{
	s_fine_pay_plate_no = val;
	get_traffic_fine_pay_data();
}
function get_fine_pay_data_by_licence_no(val)
{
	s_fine_pay_licence_no = val;
	get_traffic_fine_pay_data();
}

// ajax call   fine_pay_detail_area  fine_pay_pagination_area
function get_traffic_fine_pay_data()
{
	if(fine_pay_records == '')
	{
	    fine_pay_records = $('#fine_pay_detail_area').html();
		fine_pay_records_pagination = $('#fine_pay_pagination_area').html();
	} 
	if(s_fine_pay_by_fine_no != '' || s_fine_pay_plate_no != '' || s_fine_pay_licence_no != '')
	{   // s_fine_pay_by_fine_no  s_fine_pay_plate_no  s_fine_pay_licence_no
		$.ajax({
			url:"model/fine_model.php",
			type:'POST',
			data:'s_fine_pay_by_fine_no='+s_fine_pay_by_fine_no+'&s_fine_pay_plate_no='+s_fine_pay_plate_no+'&s_fine_pay_licence_no='+s_fine_pay_licence_no,
			beforeSend: function(){
				$('#fine_pay_pagination_area').html('');
				$('#fine_pay_detail_area').html('<tr><td colspan="12" align="center" style="color:red;"> Loading..........</td></tr>');
			},
			success:function(result){
				var data = $.parseJSON(result);  
				if(data.result == '')
					$('#fine_records_area').html('<tr><td colspan="12" align="center" style="color:red;"> No record found</td></tr>');
				else
				{
					$('#fine_pay_detail_area').html(data.result);
					$('#fine_pay_pagination_area').html(data.pagination);
					 
				}
			}
		});

	}
	else
	{
		if(fine_pay_records != '')
		{
		 	// remove session data from search statement...
				$.ajax({
				url:"model/vehicles_model.php",
				type:'POST',
				data:'action=Remove_session_value_of_search_statement',
				beforeSend: function(){
					$('#fine_pay_pagination_area').html('');
					$('#fine_pay_detail_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
				},
				success:function(result){
					$('#fine_pay_detail_area').html(fine_pay_records);
					$('#fine_pay_pagination_area').html(fine_pay_records_pagination);
				}
			});



		}
	}
}

// -------------------------------------------------

// Users Master section
// Ajax Pagination
function user_master_v_type_pag(page)
{  
	$.ajax({
		url: 'model/master_model.php',
		type:'POST',
		data: 'action=user_master_v_type_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#u_m_v_type_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#u_m_v_type_area').html(data.result);
			if(data.pagination != '')
			    $('#users_master_v_type_pagination').html(data.pagination);
		}
	});
} 
function  user_master_v_origin_pag(page)
{  
	$.ajax({
		url: 'model/master_model.php',
		type:'POST',
		data: 'action=user_master_v_origin_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#u_m_v_origin_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#u_m_v_origin_area').html(data.result);
			if(data.pagination != '')
			    $('#users_master_v_origin_pagination').html(data.pagination);
		}
	});
} 
function  user_master_plate_type_pag(page)
{  
	$.ajax({
		url: 'model/master_model.php',
		type:'POST',
		data: 'action=user_master_p_type_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#u_m_p_type_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#u_m_p_type_area').html(data.result);
			if(data.pagination != '')
			    $('#users_master_p_type_pagination').html(data.pagination);
		}
	});
} 

function  user_master_p_code_pag(page)
{  
	$.ajax({
		url: 'model/master_model.php',
		type:'POST',
		data: 'action=user_master_p_code_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#u_m_p_code_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#u_m_p_code_area').html(data.result);
			if(data.pagination != '')
			    $('#users_master_p_code_pagination').html(data.pagination);
		}
	});
} 

function  user_master_nationality_pag(page)
{  
	$.ajax({
		url: 'model/master_model.php',
		type:'POST',
		data: 'action=user_master_nationality_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#u_m_nationality_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){ 
			var data = $.parseJSON(result); 
			if(data.result != '')
			    $('#u_m_nationality_area').html(data.result);
			if(data.pagination != '')
			    $('#users_master_nationality_pagination').html(data.pagination);
		}
	});
} 

// Vehical Transfer History pagination
// Ajax Pagination
function vehicles_transfer_history_pagination(page)
{
	$.ajax({
		url: 'model/vehicles_transfer_model.php',
		type:'POST',
		data: 'action=vehicles_trans_history_ajax_pagination&page='+page,
		beforeSend: function(){
			$('#vechicle_t_records_area').html('<tr><td colspan="10" align="center" style="color:red;"> Loading..........</td></tr>');
		},
		success: function(result){
			var data = $.parseJSON(result);
			if(data.result != '')
			    $('#vechicle_t_records_area').html(data.result);
			if(data.pagination != '')
			    $('#pagination_area_vehicle_t').html(data.pagination);
		}
	});
}

 </script>


  </body>
</html>
