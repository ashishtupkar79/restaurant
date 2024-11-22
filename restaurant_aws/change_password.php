<?php
	session_start();
	
	if((!isset($_SESSION['email_id']) && !isset($_SESSION['mobile_number'])) || (!isset($_SESSION['email_id']) && !isset($_SESSION['login_tag'])))
		header("Location:logout.php");
	

	$add_more_items = false;
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object
	$sid = session_id();

	

?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>
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
    <!-- <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'> -->
	<link href="css/google_font.css" rel="stylesheet">

	<!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css"> -->
	<link rel="stylesheet" href="css/new_font-awesome.min.css">
    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
    
    <!-- Radio and check inputs -->
    <link href="css/skins/square/grey.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font">

    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->


      

</head>

<body>

<?php include 'analyticstracking.php'; ?>

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
   

<!-- End SubHeader ============================================ -->

   
<!-- End Header =============================================== -->

<!-- Content ================================================== -->

<div class="container margin_60_35" style="margin-top:10px;">
		<div class="row" >

			
<form action="changepassword_form.php" method="post" name="frm_Restpassword" id="frm_Restpassword">
			<div class="col-md-9">
				
					<div style="background-color:#fff" class="col-md-10">
						
						<div style="margin:0px;margin-top:15px;" class="main_title" id="main_title">
							<h4 class="nomargin_top"><a class="button_intro2" href="#0" data-toggle="modal" data-target="#login_2">Change Password</a> 
							
						</div><!-- First Column ends -->
									
									<!-- Third Column starts -->
									


							<div class="col-md-08" style="box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);">				
							<div class="box_style_2" id="order_process2" style="border:0px;padding-top: 0;">
								
								<h5>&nbsp;</h5>
										<div class="form-group">
											
									<input type="password" id="old_password" name="old_password" class="form-control" placeholder="Enter current password" required="" title="Please enter current password">
										</div>

										<div class="form-group">
											
											<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter new password" required=""  title="Please enter new password">

										</div>
										<div class="form-group">
											
											<input type="password" class="form-control" id="new_password2" name="new_password2" placeholder="Re enter new password" required=""  title="Please re enter new password">
										</div>
									
									

										

									<br>
									
										<input type="submit" class="btn_full" value="Change Password" name="update_frmProfile" style="background: #ec008c;font-size:15px;" >
									

									<div id="profile_msg" style="font-weight:bold;color:red"></div>

							</div><!-- End box_style_1 -->
				
					</div>
			</form>

				</div>
		</div><!-- End col-md-6 -->
      </div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->

<!-- Footer ================================================== -->
	<?php  require 'footer.php'; ?>
<!-- End Footer =============================================== -->

<div class="layer"></div><!-- Mobile menu overlay mask -->
    
  
<!-- COMMON SCRIPTS -->
<script src="js/jquery-1.11.2.min.js"></script>

<script src="js/jquery.validate.js"></script>
<script src="js/additional-methods.js"></script>
<script src="js/jquery.form.js"></script>


<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_Restpassword').validate({}); // For Validation should be there

	var options = { 
        target:        '#profile_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_Restpassword').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			//alert(queryString);
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		response = responseText;
		//alert(response);
	}	 
});

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
			//alert(this.hash.slice(1));
		  //if(this.hash.slice(1).indexOf('collapse')<0)
			{
				// alert(this.hash.slice(1));
	      target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
	      if (target.length) {
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

</body>
</html>
