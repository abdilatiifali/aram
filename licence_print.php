<?php /* ###############
         Header
	  */
	  include_once('inc/config.php');
	  include_once('inc/header.php');
	  $logged_in_user = $_SESSION['logged_in_user_data'];
	   // Edit...


?>
    <style>
	#gallery img{ width:120px; height:160px;}
	#pictures_2 img{ width:120px; height:160px;}
	</style>
    <div class="right-nav">
      	<ul class="nav nav-tabs">
            <li <?php if(!isset($_SESSION['licence_section']) ){ ?>class="active"<?php } ?>>
            	<a  href="licence.php" > Licence</a>
            </li>
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

            <!-- --------------------------------------------------------- -->


             <!-- ------------------ -->
             <div  id="tab3" style="display:none;width:200px;height:200px;">
				<div id="Licence_image_card" style="height:920px;">
                   <img src="create_licence_image/Licence.jpg" style="border:1px solid #666666;"/>
                </div>
                <div id="Licence_image_card" style="height:300px;">
                   <img src="create_licence_image/Main_images/licence_back.png" style="border:1px solid #666666;"/>
                </div>
             </div>
          <!-- ///////////////////////////////////////////////////////////////////
               *******************************************************************
          -->

        </div>
    </div>

<script>
    $(document).ready(function(e) {
                $('#show_print_btn').show().html('<button onclick="getImages()"> Print Again </button>');
				$('#show_error_msg').show().html('Please Wait...');


			 PrintLicence_img('#tab3');

	});
	function getImages()
	{
		PrintLicence_img('#tab3');
	}
</script>


 <?php /* ###############
         Footer
	  */
	  unset($_SESSION['search_statement']);
	   unset($_SESSION['licence_section']);
	  include_once('inc/footer.php');
?>
