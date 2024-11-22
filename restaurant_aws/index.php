<?php
	session_start();
	//print_r($_SESSION);


	 include ('db_connect.php');
    $connection = new createConnection(); //i created a new object

		if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$_SESSION['link'] ="index.php";

	$email_id_enc_reset = $_GET['email_id'];
	$ses_id= $_GET['ses_id'];
	$results=$connection->get_data("location_master","distinct (location) as location",null,null);
	$location_list="";
	foreach($results as $usrinfo)
	{
		$location_list .= $usrinfo['location'].'$';
	}
	$location_list = substr($location_list,0,-1);
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

    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
    
    <!-- SPECIFIC CSS -->
    <link href="layerslider/css/layerslider.css" rel="stylesheet">

	<link href="css/cloud.css" rel="stylesheet">
	<script src="js/index.js"></script>
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="css/new_font-awesome.min.css"> -->
	<style type="text/css">
		@media only screen and (min-width: 700px) 
		{
			#button_intro4
			{
					display: none;
				}

			#button_intro3
			{
					display: inline-block;
				}
		}

	@media only screen and (max-width: 700px) 
		{
			.opening
			{
				margin-left:0px;	
			}
	}

@media only screen and	 (max-width: 800px) 
{
		#button_intro3
			{
					display: none;
				}

		#button_intro4
		{
		 display: inline-block;
		}
}

	.opening_50
	{
		font-style:normal;
		margin-left:50px;
	}

	.opening_100
	{
		font-style:normal;
		margin-left:100px;
	}

	#callers {
    background-color: #555555;
    border-radius: 7px 7px 0 0;
    bottom: 0;
    color: #fff;
   font-size: 14px;
    font-weight: 500;
    padding: 10px;
    position: fixed;
    right: 5px;
    z-index: 999 !important;
}

@media only screen and (max-width: 700px) 
	{
		.parallax-mirror
			{
				left:0px;
				right:0px;
				visibility: visible;
			}
	}
	</style>

	<style type="text/css">
		@media only screen and (max-width: 700px) 
		{
			#offering_responsive1
			{
				background: #fff url('') no-repeat scroll center 40px;
				background-image: none;
				background-size: 30%;
			}
			#offering_responsive1_h3
			{
				margin-left:0px;
				font-size:16px;
				font-weight:bold;
			}

			/* End 1*/

			#offering_responsive2
			{
				background: #fff url('') no-repeat scroll center 40px;
				background-image: none;
				background-size: 30%;
				
			}
			#offering_responsive2_h3
			{
				margin-left:0px;
				font-size:16px;
				font-weight:bold;
			}

			/* end2*/

			#offering_responsive3
			{
				background: #fff url('') no-repeat scroll center 40px;
				background-image: none;
				background-size: 30%;
			}
			#offering_responsive3_h3
			{
				margin-left:0px;
				font-size:16px;
				font-weight:bold;
			}

			/* end3*/

			#offering_responsive4
			{
				background: #fff url('') no-repeat scroll center 40px;
				background-image: none;
				background-size: 30%;
			}
			#offering_responsive4_h3
			{
				margin-left:0px;
				font-size:16px;
				font-weight:bold;
			}
			#tc
			{
				margin:0px;
			}
		}

		.box_home1
			{
				background: #fff url('offers_img/1.jpg') no-repeat scroll center 40px;
			}
		.box_home1_h3
		{
			margin-top:-63px;margin-left:45px;
		}

		/*end1*/

		.box_home2
			{
				background: #fff url('offers_img/2.jpg') no-repeat scroll center 40px;
			}
		.box_home2_h3
		{
			margin-top:-63px;margin-left:45px;
		}
		/* end2*/
		.box_home3
			{
				background: #fff url('offers_img/3.jpg') no-repeat scroll center 40px;
			}
		.box_home3_h3
		{
			margin-top:-80px;margin-left:30px;
		}

	/* end3*/
		.box_home4
			{
				background: #fff url('offers_img/4.jpg') no-repeat scroll center 40px;
			}
		.box_home4_h3
		{
			margin-top:-63px;margin-left:45px;
		}
		.tc
		{
			 /*margin-top:110px;margin-right:100px;font-size:10px;*/

			 margin-top:-80px;margin-left:110px;
		}

	</style>
</head>
<body onload="chk_mobile()">

	


<?php include 'analyticstracking.php'; ?>



 

  <div id="callers" align="center"><b>Call Now</b> <!-- <br> <a href="tel://07126600288" class="phone" style="color:#fff"><i class="icon-phone-circled"></i>  0712 - 6600288&nbsp;&nbsp</a> --><br><a href="tel://918080802711" class="phone" style="color:#fff"><i class="icon-phone-circled"></i>  +91 8080802711</a><br><a href="tel://917378845457" class="phone" style="color:#fff"><i class="icon-phone-circled"></i>  +91 7378845457</a></div> 

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
    <?php require 'menu.php'; ?>

	<!-- End Header =============================================== -->
    
    <!-- SubHeader =============================================== -->
    <section class="parallax-window" id="home" data-parallax="scroll" data-image-src="img/search_background.jpg" >
		<div id="subheader">
			<div id="sub_content">
				<h1><b>Welcome to Zaikart</b></h1>
				<p><b>Quality food delivered at your doorstep.</b></p>
					<form id="frm_location" name="frm_location" method="post" action="search_location.php"> 
						<div id="custom-search-input">
						   <div class="input-group ">
								<input id="autocomplete"  type="text" name="autocomplete2" class=" search-query" placeholder="Please enter your delivery area e.g Sadar, Dharampeth etc." autofocus></input>
									 <span class="input-group-btn">
											  <input type="submit" class="button_intro3" id="button_intro3"  value="Order Now"  onClick="location_name();" style="background:#85c99d none repeat scroll 0 0">	
									</span>
							   </div>
								<div id="map" style="display:none"></div>
								 <span class="input-group-btn">
							   <input type="submit" style="background:#85c99d none repeat scroll 0 0" value="Order Now"  onClick="location_name();" class="button_intro4"  id="button_intro4">
							   </span> 
							</div>
					</form>			
				<div id="result2" style="display:none"></div>
			</div><!-- End sub_content -->
		</div><!-- End subheader -->
    </section><!-- End section -->
    <!-- End SubHeader ============================================ -->
    <!-- Content ================================================== -->
         <div class="container margin_60">
		<div class="row">
			<div align="center" style="padding-bottom:40px;" class="col-md-3"><img align="middle" width="55%" src="img/zaikart_logo.png"></div>
			<div class="col-md-5"><div class="main_title"><h2 align="center" class="">Our Ongoing Offers</h2> </div></div>
		</div>
			<br>
		  <div class="row">
		 	<div class="col-md-3">
                <div class="box_home" id="one" style="background: #fff url('offers_img/1.jpg') no-repeat scroll center 10px;">
                    <span>1</span>
                    <h3>&nbsp;</h3>
                    <p>&nbsp;<br> &nbsp;</p>
                </div>
          </div>
          <div class="col-md-3">
                <a href="0" data-toggle="modal" data-target="#terms1"  id="tenth_order_2a">
					<div class="box_home" id="one" style="background: #fff url('offers_img/2.jpg') no-repeat scroll center 10px;">
						<span>2</span>
						<h3>&nbsp;</h3>
						<p>&nbsp;<br> &nbsp;</p>
					</div>
				</a>
          </div>
			<div class="col-md-3">
                <div class="box_home" id="one" style="background: #fff url('offers_img/3.jpg') no-repeat scroll center 10px;">
                    <span>3</span>
                    <h3>&nbsp;</h3>
                    <p>
                        &nbsp;
						<br> &nbsp;
                    </p>
                </div>
          </div>
			<div class="col-md-3">
               <a href="0" data-toggle="modal" data-target="#500_MsgBox"  id="id_500_msgbox"> <div class="box_home" id="one" style="background: #fff url('offers_img/4.jpg') no-repeat scroll center 10px;">
                    <span>4</span>
                    <h3>&nbsp;</h3>
                    <p>
                        &nbsp;
						<br> &nbsp;
                    </p>
                </div></a>
          </div>
       </div><!-- End row --> 
	</div><!-- End container -->
    <style type="text/css">
		.modal-backdrop {background: none;}
	</style>
	<a href="#0" data-toggle="modal" data-target="#myModal"  id="show_msg"></a>
	<div id="myModal" class="modal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-body" align="center">Cart Updated</div>
			</div> 
		</div>
	</div>
    <div class="white_bg">
		<div class="container margin_60" style="padding-bottom:30px;">
        <div class="main_title">
           <h2 class="nomargin_top">Choose from Most Popular Dishes</h2><br>
		</div>
		<div class="row">
            <div class="col-md-6">
                <a class="strip_list" id="strip_list" style="overflow:auto" >
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                            <img src="img/home_page_images/Murgh Makhani.jpg" alt="" width="240" height="240" style="position: relative;   top: 18%;">
                        </div>
                        <h3>Murgh Makhani</h3>
                        <div class="type">
                           Non Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 220</b></span>
						  </div>
						<div class="location">
                            The forvever popular and mighty butter chicken, need not say more.
                        </div>
                     
						<div style="float:right">
							<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"    onclick="cart('10','add')" style="cursor:pointer">
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
               <a  class="strip_list" style="overflow:auto">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                            <img src="img/home_page_images/safedmass.jpg" alt="" width="240" height="240" style="position: relative;   top: 18%;">
                        </div>
                        <h3>Safed Maas</h3>
                        <div class="type">
                           Non Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 260</b></span>
                        </div>
                        <div class="location">
                            Relish The Creamy Texture, Nutty Aroma And Subtle Spices Of This Authentic Rajasthani Meat Curry
                        </div>
                     	<div style="float:right">
						<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"   onclick="cart('20','add')" style="cursor:pointer">
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
                 <a  class="strip_list" style="overflow:auto">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                            <img src="img/home_page_images/Chicken Malai Tikka.jpg" alt="" style="position: relative; top: 18%;">
                        </div>
                        <h3>Murgh Malai Tikka</h3>
                        <div class="type">
                           Non Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 210</b></span>
                        </div>
                        <div class="location">
                            Succulent And Juicy Pieces Of Chicken Thigh Fillet, Marinated Overnight In A Subtle Mix Of Spices And Yogurt .
                        </div>
						<div style="float:right">
						<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"  onclick="cart('40','add')" style="cursor:pointer">	
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
            </div><!-- End col-md-6-->
            <div class="col-md-6">
                 <a  class="strip_list" style="overflow:auto">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                            <img src="img/home_page_images/Paneer Butter Masala.jpg" alt="" style="position: relative;   top: 15%;">
                        </div>
                        <h3>Paneer Butter Masala Bhurji</h3>
                        <div class="type">
                           Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 190</b></span>
                        </div>
                        <div class="location">
                            Scrambled Paneer(cottage cheese),simmered in satin smooth tomato gravy, accentured with the aromatic kasoori methi
                        </div>
						<div style="float:right">
						<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"  onclick="cart('26','add')" style="cursor:pointer">	
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
                 <a  class="strip_list" style="overflow:auto">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                             <img src="img/home_page_images/biryani.jpg" alt="" width="240" height="240" style="position: relative;   top: 18%;">
                        </div>
                        <h3>Mutton Biryani</h3>
                        <div class="type">
                           Non Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 240</b></span>
                        </div>
                        <div class="location">
                            The mutton is prepared with stock and spices, then layered with rice and cooked in traditional ' Dum ' style
                        </div>
						<div style="float:right">
						<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"  onclick="cart('47','add')" style="cursor:pointer">	
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
                 <a class="strip_list" style="overflow:auto">
                <div class="ribbon_1">Popular</div>
                    <div class="desc">
                        <div class="thumb_strip" style="border:0px;">
                            <img src="img/home_page_images/Paneer Tikka.jpg" alt="" style="position: relative;   top: 18%;">
                        </div>
                        <h3>Paneer Tikka</h3>
                        <div class="type">
                           Veg <span class="opening" style="font-style:normal;margin-left:100px;"><b><i class="fa fa-inr"></i> 180</b></span>
                        </div>
                        <div class="location">
                            Paneer Is Vegetarian First-class Fare And A Subtle Cheese To Taste. Marinated Then Gently Charred With Red, Green Capsicums And Onions.
                        </div>
						<div style="float:right">
						<br><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Add to Cart" style="cursor:pointer"  onclick="cart('33','add')" style="cursor:pointer">	
						</div>
                    </div><!-- End desc-->
                </a><!-- End strip_list-->
            </div>
        </div><!-- End row -->   
		<div id="cart_index" style="display:none"></div>
			<h4 class="nomargin_top" align="center"><a class="nomargin_top" style="color:#F2006D" href="detail_page.php"><u>Click here to see our full menu</u></a></h4>
    </div><!-- End parallax-content-2-->
    </section><!-- End section --> 
	</div><!-- End container -->
    </div><!-- End white_bg -->
 <section class="parallax-window-2" style="background-image:url('img/home_page_images/bulk_orders.jpg'); no-repeat center center;">
	<div class="parallax-content">
    	<div class="sub_content"></div>
    </div>
</section>  

 <!-- Footer ================================================== -->
   <?php  require 'footer.php'; ?>
    <!-- End Footer =============================================== -->
<div class="layer"></div><!-- Mobile menu overlay mask -->
<?php require 'login.php'; ?>
	<!-- Invalid Delivery Location Message -->   
	<a href="#0" data-toggle="modal" data-target="#errbox"  id="errbox_2a"></a>
	<div class="modal fade" id="errbox" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form>
						<!-- <button type="submit" class="btn btn-submit">Register</button> -->
						<div id="error_msg"></div>
				</form>
			</div>
		</div>
	</div><!-- Invalid Delivery Location Message Ends-->


	
	<!-- Restaurant Close Days modal  popup-->
	 <div class="modal-header">
		<a href="#0" data-toggle="modal" data-target="#close_restaurant"  id="close_restaurant_link"></a>
	</div>
	<div class="modal fade" id="close_restaurant" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup" style="background-color:#F9F9F9">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<?php require 'alert.php'; ?>

				
			</div>
		</div>
	</div><!-- Restaurant Close Days modal  popup -->


	
	<!-- Mobile Number  modal popup-->
	
	


	
	<!-- End Mobile Number  modal popup -->

    
<!-- COMMON SCRIPTS -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>
<script src="assets/validate.js"></script>


<link rel="stylesheet" href="css/jquery-ui.css">
<script src="js/jquery-ui.js"></script>

<script src="js/jquery.validate.js"></script>
<script src="js/additional-methods.js"></script>
<script src="js/jquery.form.js"></script>


<?php
require 'mobile_check_popup.php';

$where ="status='y'";
$results=$connection->get_data("orders_stop_log","message_start_date,message_end_date",$where,null);
foreach($results as $usrinfo)
{
	$from = date($usrinfo['message_start_date']);
	$to = date($usrinfo['message_end_date']);
}

//$from = date('2016-08-01 06:00:00');
//$to = date('2016-08-02 06:00:00');

if(strtotime(date('Y-m-d H:i:s')) >= strtotime($from) && strtotime(date('Y-m-d H:i:s')) <= strtotime($to))
{
	
?>
<script>
	$("document").ready(function(){
		$( "#close_restaurant_link" ).trigger( "click" );
	});
</script>
<?php
}
?>

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

<!-- Check Mobile Number and  Verification Code-->



<!-- Check Mobile Number and  Verification Code-->

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
			$("document").ready(function(){
				$( ".close-link" ).trigger( "click" );
			});
			window.location.reload();
		}
		if(response == 'error')
		{
			document.getElementById("login_msg").innerHTML = 'Either Username or Password is Incorrect';
		}
	}	 
});

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
		//alert(response);
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
<!-- SPECIFIC SCRIPTS -->
<script src="layerslider/js/greensock.js"></script>
<script src="layerslider/js/layerslider.transitions.js"></script>
<script src="layerslider/js/layerslider.kreaturamedia.jquery.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		'use strict';
        $('#layerslider').layerSlider({
            autoStart: true,
			responsive: true,
			responsiveUnder: 1280,
			layersContainer: 1170,
			navButtons:false,
			showCircleTimer:false,
			navStartStop:false,
            skinsPath: 'layerslider/skins/'
            // Please make sure that you didn't forget to add a comma to the line endings
            // except the last line!
        });
    });
</script>

<!-- SPECIFIC SCRIPTS -->
<!-- <script type="text/javascript" src="js/pop_up.min.js"></script>
<script type="text/javascript" src="js/pop_up_func.js"></script> -->
<script>
	var z = "<?php echo $location_list ?>";
	tags = z.split("$");
	var z2 = "<?php echo $location_list ?>";
	tags2= z2.split("$");
	var isHoverSelect = false;
	$( "#autocomplete" ).autocomplete({
	  source: function( request, response ) {
			  var matcher = new RegExp("^"+$.ui.autocomplete.escapeRegex( request.term ), "i" );
			  response( $.grep( tags, function( item ){
				  return matcher.test( item );
			  }) );
		  }
	});

	$( "#autocomplete2" ).autocomplete({
	  source: function( request, response ) {
			  var matcher = new RegExp($.ui.autocomplete.escapeRegex( request.term ), "i" );
			  response( $.grep( tags2, function( item ){
				  return matcher.test( item );
			  }) );
		  }
	});
</script>
<script>
function location_name()
{
	var location_name = document.getElementById("autocomplete").value;	
	$(document).ready(function () {
				
				var options = { 
				target:        '#result2',   // target element(s) to be updated with server response 
				beforeSubmit:  showRequest,  // pre-submit callback 
				success:       showResponse  // post-submit callback 
			}; 
			
			$('#frm_location').ajaxForm(options); 
			
			function showRequest(formData, jqForm, options) 
				{ 
					var queryString = $.param(formData); 
					return true; 
				} 
			
			function showResponse(responseText, statusText, xhr, $form)  
			{ 
				response = responseText;
				//alert(response);
				response_val=response.split("~");
				if(response_val[0] == 'error')
				{
					document.getElementById("error_msg").innerHTML=response_val[1];
					$("document").ready(function(){
						$( "#errbox_2a" ).trigger( "click" );
					});
				}
			}	 
		});
	}
	</script>
<script>
      var placeSearch, autocomplete;
      var componentForm = {
		 street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
      };
      function initAutocomplete() {
  		 var map = new google.maps.Map(document.getElementById('map'), { center: {lat: 21.1458, lng: 79.1036},
          zoom: 13,
          mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        // Create the search box and link it to the UI element.

		 var input = document.getElementById('autocomplete');
		 var searchBox = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
            {types: ['geocode'],componentRestrictions: {country: 'in'}});

        // Bias the SearchBox results towards current map's viewport.
        map.addListener('bounds_changed', function() {
          searchBox.setBounds(map.getBounds());
        });
      }
      function fillInAddress() {
    // Get the place details from the autocomplete object.
    var place = autocomplete.getPlace();
   document.getElementById("latitude").value = place.geometry.location.lat();
    document.getElementById("longitude").value = place.geometry.location.lng();
    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i];
		alert(addressType);
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
			alert(val);
            document.getElementById(addressType).value = val;
        }
    }
}
 </script>
 <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCJ2Drrr3QUeTv-kQxX_ddjyILuXxnWp4c&libraries=places&callback=initAutocomplete"
        async defer></script>
 <link rel="stylesheet" href="css/backtotop.css">
<a href="#123" class="cd-top">Top</a>
<script src="js/main.js"></script> <!-- Gem jQuery -->
<script type="text/javascript">
	function cart(pdid,action)
	{
		var add_more_items =true;
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
			if(xmlhttp.readyState >=0 && xmlhttp.readyState <=3)
			{
				document.getElementById(row_id).style.display = "";
			}
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response =  xmlhttp.responseText;
				document.getElementById("cart_index").innerHTML = response;
				total_cart_items();
			}
		}
		xmlhttp.open("GET", "cart_index.php?pdid="+pdid+"&action="+action+"&add_more_items="+add_more_items,true);
		xmlhttp.send();
	}
</script>

<script type="text/javascript">
	function total_cart_items()
	{
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
				var response =  xmlhttp.responseText;
				$("document").ready(function(){
				$( "#show_msg" ).trigger( "click" );
				setTimeout(function()
				{
					$( "#show_msg" ).trigger( "click" )
							}, 1000);
					});
				document.getElementById("show_cart").innerHTML = response;
			}
		}
		xmlhttp.open("GET", "cart_items.php",true);
		xmlhttp.send();
	}
</script>


<!--10th order  modal popup-->   
<div class="modal fade" id="terms1" tabindex="-1" role="dialog" aria-labelledby="terms_1" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				 <div class="modal-header" style="border-bottom: 0 solid #e5e5e5;">
					<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
			   		<h4 class="modal-title">Terms and Conditions</h4>
					<ul style="text-align:left">	
						<li>Every 10th meal free will serve only one person.</li>
						<li>The maximum amount of food products that the customer can avail on his/her's 10th order is Rs.230..</li>
						<li>This offer is applicable on every 10th order. (Example: If a person orders 20 times from Zaikart he/she is eligible for two free meals.).</li>
						<li>Every 10th meal free offer can only be availed through the website.</li>
						<li>To provide this offer Zaikart will track the customers mobile number only.</li>
						<li>The lucky customer to receive a free meal every month can order upto Rs.500.</li>
						<li>The lucky customer will receive an email in which all the information will be given to avail that offer.</li>
						<li>This offer can only be availed by logging in.</li>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- End 10th order  modal popup -->


	<!--Rs. 500 Message popup-->   
	
	<div class="modal fade" id="500_MsgBox" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true" >
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_extra_charge_popup"><i class="icon_close_alt2"></i></a>
					
						<h4 style="line-height:25px;">Get 25% off every Wednesday between 08:00 - 10:00 p.m.</h4>
						<h5 style="color:#FF0000;font-weight:bold">*Offer valid only on orders of Rs.500 and above.</h5>
						<h5 style="color:#FF0000;font-weight:bold">*Offer not valid for free meals.</h5>
						
					
			</div>
		</div>
	</div>
	
	<!-- Rs. 500 Message popup -->

	<script>
	function close_login()
	{
		$("document").ready(function()
		{
			$( ".close-link" ).trigger( "click" );
			$( "#triggerForgot_2" ).trigger( "click" );
		});
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
var password_reset = "<?php echo $_GET['password_reset']; ?>";
if(password_reset=='y')
{
	$("document").ready(function()
	{
		$( "#trigger_Reset_Forgot_2" ).trigger( "click" );
	});
}
</script>


<script type="text/javascript">

	$(document).ready(function () {
	$('#myForgotReset').validate({}); // For Validation should be there

	var options = { 
        target:        '#forgot_reset_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#myForgotReset').ajaxForm(options); 
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
		window.location.assign("index.php");
	}	 
});
</script>



</body>
</html>