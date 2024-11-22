<?php
 session_start();
  include ('db_connect.php');
    $connection = new createConnection(); //i created a new object

	if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$_SESSION['link'] ="aboutus.php";
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


<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/additional-methods.js"></script>
<script src="js/jquery.form.js"></script>


<style type="text/css">
	 label.error {
	color: red;
	line-height:15px;
}
</style>
</head>

<body onload ="chk_mobile()">
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
	
	<?php require 'menu.php'; ?>
    

<!-- Content ================================================== -->
<div class="container margin_60_35">
		<div class="row">
        
			<div class="col-md-3">
				
				<div class="box_style_2 hidden-xs" id="help">
					<i class="icon_lifesaver"></i>
					<h4>Need <span>Help?</span></h4>
					<a href="tel://917387423888" class="phone" style="font-size:20px;">+91 7387423888</a>
								<small>Monday to Sunday <br> 12.00 noon till 12.00 midnight</small>
				</div>
			</div>
            
			<div class="col-md-9">
				<div class="box_style_2">
					<h2 class="inner">About us</h2>
                       <div align="center"><img align="middle" width="15%" src="img/zaikart_logo.png"></div><br>
                    <h3>How it all started and why we are here!</h3>
					<p>
						One surprisingly cool summer night in Nagpur, three hungry friends sitting on the terrace decided to order for some good food. After a lot of phone calls and searching on the internet they couldn't really come up with a place which could provide them with good food at that time."Only if we were in a metro city!".
					</p>
					<p class="add_bottom_30">
						They decided to come up with a solution for people to satisfy their hunger pangs just through clicks of a few buttons and decided to come up with Zaikart.
					</p>
					<p class="add_bottom_30">
						They focused on 4 major factors which today are the pillars at Zaikart : Simple process , delectable food, good experience and being on time. 
					</p>
					<p class="add_bottom_30">
						Zaikart focuses on how can it make the experience of the customer more pleasurable, exciting and satisfactory. We are heading out on a mission to serve some of the best tasting Indian food you've had in Nagpur right at your doorstep.
					</p>

					<p class="add_bottom_30">
						With just a few clicks or a phone call away we will make sure that our customers get an unforgettable experience in terms of taste and service. 
					</p>

					<p class="add_bottom_30">Please give us the opportunity to provide one of the best experiences you have ever had!</p>

					
                    
				</div><!-- End box_style_1 -->
			</div>
		</div><!-- End row -->
</div><!-- End container -->

<!-- End Content =============================================== -->

<!-- Footer ================================================== -->
	<?php  require 'footer.php'; ?>
<!-- End Footer =============================================== -->

<div class="layer"></div><!-- Mobile menu overlay mask -->
    
<?php require 'login.php'; ?>

    
<!-- COMMON SCRIPTS -->

<?php 
require 'commonscripts.php' ;
require 'mobile_check_popup.php';
?>

</body>
</html>