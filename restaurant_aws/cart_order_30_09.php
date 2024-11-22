<?php
	session_start();
	if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$extra_charge="";
	$extra_charge_amount="";
	$remaining_total="";
	$delivery_day="";
	$provider_email_id="";

	$_SESSION['link'] ="cart_order.php";
	$add_more_items = false;
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object
	
	$message=session_id()."~checkout";
	$connection->logEvent($message);

	if(isset($_POST['extra_charge']) && $_POST['extra_charge'] !="")
		$extra_charge=$_POST['extra_charge'];

	if(isset($_POST['extra_charge_amount']) && $_POST['extra_charge_amount'] !="")
		$extra_charge_amount =$_POST['extra_charge_amount'];

	$remaining_total=$_POST['remaining_total'];
	if($remaining_total > 0 && $extra_charge != 'y')
	{
		echo 'error';
		exit;
	}
	$sid = session_id();
	$cartContent=$connection->getCartContent($sid);
	$numItem     = count($cartContent);
	if($numItem == 0)
	{
	?>
	<script type="text/javascript">
		window.location.href="detail_page.php";
	</script>
	<?php	
	}

	if((!isset($_POST['delivery_location'])  && !$_POST['delivery_location'] =="") || (!isset($_SESSION['delivery_location'])  && !$_SESSION['delivery_location'] ==""))   
	{
		header("Location:detail_page.php");
		exit;
	}
	if(isset($_POST['delivery_location']) && $_POST['delivery_location'] !="")
	{
		$_SESSION['delivery_location']=$_POST['delivery_location'] ;
	}
	$address=$_SESSION['delivery_location'] ;
	$split_address = explode("~",$address);
	$pincode = $split_address[0];
	$area = $split_address[1];
	
	if($pincode == "" ||  $area=="")
	{
		header("Location:detail_page.php");
		exit;
	}
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>
<head>
	<noscript><meta http-equiv="refresh" content="01; URL=compatibility.html" target="_blank"/><h1>instructions how to enable JavaScript in your web browser</h1></noscript>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0 ,maximum-scale=1.0, user-scalable=no">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="description" content="Order food online from Zaikart and enjoy the fastest home delivery you've ever experienced in Nagpur. Let us make your meal the best meal of the day.">
	<meta name="keywords" content="Order Food online, home delivery, Order Dinner, Order Snacks online, order dinner, order dessert, Nagpur , Nagpur food delivery , cheap eats in nagpur , fast delivery">
    <meta name="author" content="">
    <title>Zaikart</title>

    <!-- Favicons-->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114" href="img/apple-touch-icon-114x114-precomposed.png">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144" href="img/apple-touch-icon-144x144-precomposed.png">
    
    <!-- GOOGLE WEB FONT -->
   
	<link href="css/google_font.css" rel="stylesheet">

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	
    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
    
    <!-- Radio and check inputs -->
    <link href="css/skins/square/grey.css" rel="stylesheet">

	
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<?php
	 echo '<body onload="get_timings(false)">';
	 include 'analyticstracking.php'; 
 ?>

<!--[if lte IE 8]>
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

	<div id="preloader">
        <div class="sk-spinner sk-spinner-wave" id="status">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div><!-- End Preload -->

    <!-- Header ================================================== -->
	<?php  require 'menu.php';	?>


	<!-- SubHeader =============================================== -->
    <div id="subheader2" style="margin-top:30px;">
    	<div id="sub_content2">
    	 <h1>Place your order</h1>
            <div class="bs-wizard">
                <div class="col-xs-4 bs-wizard-step active">
                  <div class="text-center bs-wizard-stepnum"><strong>1.</strong> Your details</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>
                               
                <div class="col-xs-4 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum"><strong>2.</strong> Payment</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>
            
              <div class="col-xs-4 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum"><strong>3.</strong> Finish!</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>  
		</div><!-- End bs-wizard --> 
        </div><!-- End sub_content -->
	</div><!-- End subheader -->

<!-- End SubHeader ============================================ -->
<!-- End Header =============================================== -->
<!-- Content ================================================== -->

<div class="container margin_60_35_2">
	<div class="row" >
		<form action="frm_pay.php" method="post" name="frm_Order" id="frm_Order">
			<input type="hidden" name="delivery_day_selected" id="delivery_day_selected">
			<input type="hidden" name="delivery_time_selected" id="delivery_time_selected">
			<input type="hidden" name="provider_email_id" id="provider_email_id" value="<?php echo $provider_email_id ?>">
			<div class="col-md-9">
				<div style="background-color:#fff" class="col-md-12">
					<div style="margin:0px;margin-top:15px;" class="main_title" id="main_title">
							<?php
								if((!isset($_SESSION['email_id']) && !isset($_SESSION['mobile_number'])) || (!isset($_SESSION['email_id']) && !isset($_SESSION['login_tag'])))
								{
							?>
								<h4 class="nomargin_top" style="align:left">
									<a class="button_intro2" href="#0" data-toggle="modal" data-target="#login_2"> Login</a> </h4><h4>Or</h4><h4>Just continue checkout as guest</h4>
							<?php
								}
							?>
						</div>
						<!-- First Column ends -->
					<!-- Third Column starts -->
					<div class="col-md-6" style="box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);">			
						<div class="box_style_2" id="order_process" style="border:0px;padding-top: 0;">
							<input type="hidden" name="extra_charge_amount" value="<?php echo $extra_charge_amount ?>">				
								<h5><b>Your delivery details</b></h5> 
									<?php
											$now='';
											$style='display:none;';
											$checked="";

											/*$from_time1 = strtotime("03:30 pm");
											$to_time1 = strtotime("06:59 pm");
											$from_time = strtotime("01:30 am");
											$to_time = strtotime("11:59 am");
											
										
											if((strtotime(date("h.i a")) >= $from_time && strtotime(date("h.i a")) <= $to_time) || (strtotime(date("h.i a")) >= $from_time1 && strtotime(date("h.i a")) <= $to_time1) )
											{
												$now = 'disabled';
												$style='';
												$checked='checked';
											}*/


											/*$time_slots[] =  '12.00 am~02.00 am~n';
											$time_slots[] =  '12.00 pm~04.00 pm~y';
											$time_slots[] =  '07.00 pm~11.45 pm~y';*/

											$time_slots=$connection->get_time_slots();

											for($i=0;$i<count($time_slots);$i++)
											{

													if($i>=(count($time_slots)-1))
														continue;

													//echo $i.'***<br>'.$time_slots[$i].'<br>';

												$timeslots_val = explode('~',$time_slots[$i]);
												$from = $timeslots_val[0];
												$to = $timeslots_val[1];

												$timeslots_val = explode('~',$time_slots[$i+1]);
												$from2 = $timeslots_val[0];
												$to2 = $timeslots_val[1];



													$from_time= strtotime(date("h:i a", strtotime($to) - 1800));
													$to_time = strtotime(date("h:i a", strtotime($from2) - 1));

												if((strtotime(date("h.i a")) >= $from_time && strtotime(date("h.i a")) <= $to_time))
												{
														$now = 'disabled';
														$style='';
														$checked='checked';
												}
											}
									?>
										<div class="row">
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
														<input type="radio" name="now" id="now" value="now" onClick="select_date(false)" required="" <?php echo $now ?>> 
														<label>Now</label>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<input type="radio" name="now" id="later"  value="later" onClick="select_date(true)" required="" <?php echo $checked; ?>>
														<label>Later</label>
												</div>
											</div>
										</div>
										<div class="row"  id="day_time">
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label>Delivery Date</label>
													<select class="form-control" name="delivery_day" id="delivery_day" required="" title="Please select delivery date" onChange="get_timings(true);set_date()">
														<option value="" selected>Select Date</option>
														<?php
																$from_time = strtotime("11:23 pm");
																$to_time = strtotime("11:59 pm");
																if(strtotime(date("h.i a")) >= $from_time && strtotime(date("h.i a")) <= $to_time)
																{
																}
																else
																{
																	$selected="";
																	$sel_date_val = '1~'.date("d-m-Y");
																	if($sel_date_val  == $_SESSION['day'])
																		$selected='selected';
																	echo '<option value="'.$sel_date_val.'" '.$selected.'>'.date("d-m-Y").'</option>';
																}
														
																$selected="";
																$sel_date_val = '2~'.date('d-m-Y',strtotime($delivery_day . "+1 days"));
																if($sel_date_val  == $_SESSION['day'])
																	$selected='selected';
														
																echo '<option value="'.$sel_date_val.'" '.$selected.'>'.date('d-m-Y',strtotime($delivery_day . "+1 days")).'</option>';
																$selected="";
																$sel_date_val = '3~'.date('d-m-Y',strtotime($delivery_day . "+2 days"));
																if($sel_date_val  == $_SESSION['day'])
																	$selected='selected';
																echo '<option value="'.$sel_date_val.'" '.$selected.'>'.date('d-m-Y',strtotime($delivery_day . "+2 days")).'</option>';
														?>
													</select>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label>Delivery Time</label>
													<div id="my_delivery_time">
														<select class="form-control" id="delivery_time1" name="delivery_time" required="" title="Please select delivery time" onChange="set_date()">
															<option value="" selected>Select Time</option>
															
															</select>
														</div>
												</div>
											</div>
										</div>
										<div class="form-group">
												<input type="text" class="form-control" id="delivery_address1" name="delivery_address1" placeholder="House No." required="" value="<?php echo @$address1 ?>" title="Please enter house no." maxlength="255">
										</div>
										<div class="form-group">
												<input type="text" class="form-control" id="delivery_address2" name="delivery_address2" placeholder="Street Name / Area" required="" value="<?php echo @$address2 ?>" title="Please enter street name / area" maxlength="255">
										</div>
										<div class="form-group">
												<input type="text" class="form-control" id="delivery_address3" name="delivery_address3" placeholder="Landmark" required="" value="<?php echo @$address3 ?>" title="Please enter landmark" maxlength="255">
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label>Comments or Instructions</label>
													<textarea class="form-control" style="height:85px;resize: none;" placeholder="" name="comments" id="comments" maxlength="255"></textarea>
												</div>
											</div>
										</div>
								</div><!-- End box_style_1 -->
							</div>
							<div class="col-md-6" style="box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);">				
								<div class="box_style_2" id="order_process2" style="border:0px;padding-top: 0;">
									<h5><b>Contact Info</b></h5>
									<div class="form-group">
										<?php
												$readonly="";
												if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']))
													$readonly ='readonly';
											?>
										<input type="text" id="mob_order" name="mob_order" class="form-control" placeholder="Mobile number for SMS Confirmation" required="" digits="true" data-rule-required="true" data-msg-required="Please enter 10 digits mobile number" minlength="10" maxlength="10"  value="<?php echo @$mobile_number; ?>" <?php echo $readonly ?>>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="firstname_order" name="firstname_order" placeholder="First name" required="" value="<?php echo @$fname ?>" title="Please enter a first name" maxlength="50">
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="lastname_order" name="lastname_order" placeholder="Last name" required="" value="<?php echo @$lname ?>" title="Please enter a last name" maxlength="50">
									</div>
									<div class="form-group">
										<input type="email" id="email_order" name="email_order" class="form-control" placeholder="Your email" required="" data-rule-email="true" data-msg-email="enter a valid email address" maxlength="50"  value="<?php echo @$email_id ?>" title="Please enter an email address">
									</div>
									<div class="row">
										<div class="col-md-6 col-sm-6">
											<div class="form-group">
													<input type="text" id="city_order" name="area_order" class="form-control" value="<?php echo  $area ?>" readonly>
												</div>
											</div>
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<input type="text" id="pincode_order" name="pincode_order" class="form-control"  value="<?php echo  $pincode ?>" readonly>
												</div>
											</div>
										</div> 
										<br>
										<div class="form-group">
											<input type="submit" class="btn_full" value="Place Your Order" name="submit_frmPay" style="background: #ec008c;font-size:15px;" >
										</div>
					</div><!-- End box_style_1 -->
				</div>
			</div>
		</div><!-- End col-md-6 -->
        <div class="col-md-8" id="sidebar" style="padding:0px;">
			<div class="theiaStickySidebar">
				<div id="cart_box" >
					<h3>Your order <img src="img/food_24.png" style="float:right"></h3>
						<div class="row">
							<div class="col-md-6 col-sm-6">
								<div class="form-group" style="margin-bottom:10px;">
										Delivery at
								</div>
							</div>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<?php echo  '<b style="color:#EC008C">'.ucfirst($area).'</b>' ?>
								</div>
							</div>
						</div>
						<hr class="hr2">
						<div id="cart">
							<?php require 'cart.php' ?>
						</div>
					</div><!-- End cart_box -->
                </div><!-- End theiaStickySidebar -->
			</div><!-- End col-md-3 -->
          </form>  
	</div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->

<!-- Footer ================================================== -->
	<?php  require 'footer.php'; ?>
<!-- End Footer =============================================== -->
<div class="layer"></div><!-- Mobile menu overlay mask -->
<?php require 'login.php'; ?>
<!-- COMMON SCRIPTS -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/additional-methods.js"></script>
<script src="js/jquery.form.js"></script>
<script type="text/javascript">
    $('#login_2').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
	})
</script>

<script type="text/javascript">
    $('#register').on('hidden.bs.modal', function (e) {
  $(this)
    .find("input,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
	})
</script>

<script type="text/javascript">
$('#login_2').on('shown.bs.modal', function (e) {    //alert("I want this to appear after the modal has opened!");
	document.getElementById("login_msg").innerHTML ="";
	$('#cust_login').focus();
});
</script>
<script type="text/javascript">
$('#register').on('shown.bs.modal', function (e) {    //alert("I want this to appear after the modal has opened!");
	$('#fname').focus();
});
</script>
<script type="text/javascript">

	$(document).ready(function () {
	$('#myLogin').validate({}); // For Validation should be there

	var options = { 
        target:        '#login_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#myLogin').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
	
		if(response == 'success')
		{
			window.location.reload();
			$("document").ready(function(){
				$( ".close-link" ).trigger( "click" );
			});
			
		}
		if(response == 'error')
		{
			document.getElementById("login_msg").innerHTML = 'Either Username or Password is Incorrect';
		}
	}	 
});

</script>

<script>
	function close_login()
	{
		
		try
		{
			try
			{
				//$( "#close_login_popup" ).trigger( "click" );	
				$( ".close-link" ).trigger( "click" );
			}
			catch (ex)
			{
				//alert(ex);
			}
			
			try
			{
				$( "#triggerForgot_2" ).trigger( "click" );		
			}
			catch (ex)
			{
				//alert(ex);
			}
		}
		catch (ex)
		{
			//alert(ex);
		}
	}
</script>

	<script type="text/javascript">

	$(document).ready(function () {
	$('#myForgot').validate({}); // For Validation should be there

	var options = { 
        target:        '#forgot_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#myForgot').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
		alert(response);
		window.location.reload();
	}	 
});
</script>



<script type="text/javascript">

	$(document).ready(function () {
	$('#myRegister').validate({}); // For Validation should be there

	var options = { 
        target:        '#register_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#myRegister').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
	
		var response_val = response.split("~");
		if(response_val[1] == 'success')
		{
			$("document").ready(function(){
				$( ".close-link" ).trigger( "click" );
			});
			window.location.reload();
		}
		if(response_val[1] == 'error')
		{
			document.getElementById("register_msg").innerHTML = response_val[0];
		}
	}	 
});

</script>
<script type="text/javascript">
	$(document).ready(function () {
		$('#frm_Order').validate({	
		invalidHandler: function(event, validator) 
		{
		// 'this' refers to the form
		var errors = validator.numberOfInvalids();
		var numbers = /^[0-9]+$/;
		if (errors) 
		{

			if (document.getElementById("delivery_day").value == "")
			{
				alert("Please select Delivery date");
			}

			else if (document.getElementById("delivery_time1").value == "")
			{
				alert("Please select Delivery time");
			}

			else if (document.getElementById("delivery_address1").value == "")
			{
				alert("Please enter house no.");
				document.getElementById("delivery_address1").focus();
				return false;
			}
			else if (document.getElementById("delivery_address2").value == "")
			{
				alert("Please enter street name / area");
				document.getElementById("delivery_address2").focus();
				return false;
			}
			else if (document.getElementById("delivery_address3").value == "")
			{
				alert("Please enter landmark");
				document.getElementById("delivery_address3").focus();
				return false;
			}
			else if (document.getElementById("mob_order").value == "")
			{
				alert("Please enter  Mobile Number");
				document.getElementById("mob_order").focus();
				return false;
			}
			else if(!document.getElementById("mob_order").value.match(numbers))
			{
				alert("Please enter only digits");
				document.getElementById("mob_order").focus();
				return false;
			}
			else if(document.getElementById("mob_order").value.length < 10)
			{
				alert("Please enter 10 characters.");
				document.getElementById("mob_order").focus();
				return false;
			}

			else if (document.getElementById("firstname_order").value == "")
			{
				alert("Please enter a first name");
				document.getElementById("firstname_order").focus();
				return false;
			}
			else if (document.getElementById("lastname_order").value == "")
			{
				alert("Please enter a last name");
				document.getElementById("lastname_order").focus();
				return false;
			}
			else if (document.getElementById("email_order").value == "")
			{
				alert("Please enter an email address");
				document.getElementById("email_order").focus();
				return false;
			}
			else if(document.getElementById("email_order").value != "")
			{
				var x = document.getElementById("email_order").value;
				var atpos = x.indexOf("@");
				var dotpos = x.lastIndexOf(".");
				if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length) 
				{
					alert("Not a valid e-mail address");
					document.getElementById("email_order").focus();
					return false;
				}
			}
		}
	}

		}); // For Validation should be there
});
</script>
<style type="text/css">
	 label.error {
	color: red;
	line-height:15px;
}
</style>
<script>
	//var jq=$.noConflict();
</script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>
<script src="assets/validate.js"></script>
<!-- SPECIFIC SCRIPTS -->
<script  src="js/cat_nav_mobile.js"></script>
<script>$('#cat_nav').mobileMenu();</script>
<script src="js/theia-sticky-sidebar.js"></script>
<script>
    jQuery('#sidebar').theiaStickySidebar({
      additionalMarginTop: 80
    });

	  jQuery('#sidebar2').theiaStickySidebar({
      additionalMarginTop: 80
    });
</script>
<script>
 $(function() {
	 'use strict';
	  $('a[href*=#]:not([href=#media])').click(function() {
	    if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
	      var target = $(this.hash);
			{
			 target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			  if (target.length) 
				  {
						$('html,body').animate({
						scrollTop: target.offset().top - 70
						}, 1000);
						return false;
				 }
			}
	    }
	  });
	});
</script>
<script>
    $(function () {
		 'use strict';
        $("#range").ionRangeSlider({
            hide_min_max: true,
            keyboard: true,
            min: 0,
            max: 15,
            from: 0,
            to:5,
            type: 'double',
            step: 1,
            prefix: "Km ",
            grid: true
        });
    });
</script>
<script type="text/javascript">
	$('.collapse').on('show.bs.collapse', function (e) {
	 $('.collapse').not(e.target).removeClass('in');
});
</script>
<script>
function display_day_time()
{
	if(document.getElementById("day_time").style.display == "none")
	{
		document.getElementById("day_time").style.display = "";
		document.getElementById("delivery_day").value = "";
		document.getElementById("delivery_time1").value = "";
	}
}
function hide_day_time()
{
	if(document.getElementById("day_time").style.display == "")
	{
		document.getElementById("day_time").style.display = "none";
	}
}
</script>
<script type="text/javascript">
	function select_date(flag)
	{
		if(flag)
		{
		document.getElementById("delivery_day").selectedIndex = "0";
		document.getElementById("delivery_day").disabled = false;
		document.getElementById("delivery_time1").disabled = false;
		get_timings(false);
		}
		else
		{
			document.getElementById("delivery_day").selectedIndex = "1";
			document.getElementById("delivery_day").disabled = true;
			get_timings(false);
		}
	}
</script>
<script type="text/javascript">
	function get_timings(flag)
	{
		var my_delivery_date =document.getElementById("delivery_day").value ;
		var my_delivery_time ="<?php echo $_SESSION['time']; ?>";
		if(flag)
			my_delivery_time="";
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("my_delivery_time").innerHTML= xmlhttp.responseText;
				if(document.getElementById("delivery_day").disabled == true)
					get_timings_now();
			}
		}
		xmlhttp.open("GET", "get_delivery_time.php?my_delivery_date="+my_delivery_date+"&my_delivery_time="+my_delivery_time,true);
		xmlhttp.send();
	}
</script>
<script type="text/javascript">
  function get_timings_now()
	{
		var my_delivery_date = document.getElementById("delivery_day").value;
		var xmlhttp;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById("my_delivery_time").innerHTML= xmlhttp.responseText;
				document.getElementById("delivery_time1").disabled = true;
				var my_delivery_time1=document.getElementById("delivery_time1").value;
				set_date();
			}
		}
		xmlhttp.open("GET", "get_delivery_time.php?now=y&my_delivery_date="+my_delivery_date,true);
		xmlhttp.send();
	}
</script>
<script>
function set_date()
{
	try
	{
		document.getElementById("delivery_day_selected").value = document.getElementById("delivery_day").value;
		document.getElementById("delivery_time_selected").value = document.getElementById("delivery_time1").value;
	}
	catch (e)
	{
		alert(e);
	}
}
</script>
</body>
</html>