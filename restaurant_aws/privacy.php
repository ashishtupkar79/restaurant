<?php
 session_start();
  include ('db_connect.php');
    $connection = new createConnection(); //i created a new object

	if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$_SESSION['link'] ="privacy.php";
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
    <link href='https://fonts.googleapis.com/css?family=Lato:400,700,900,400italic,700italic,300,300italic' rel='stylesheet' type='text/css'>
	

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

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
<script type="text/javascript">

	$(document).ready(function () {

		

			

$('#frm_comfirmationPay').validate({}); // For Validation should be there

	var options = { 
        target:        '#msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_comfirmationPay').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		
	}	 
});

</script>

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
    <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</li>
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
		<div class="col-md-12">
        	<div class="box_style_2">
       			 <div class="row">
                	<h4 class="nomargin_top">Privacy Policy</h4>
						<ul>
							<li>Your IP is logged when placing an order. This is for reasons of fraud protection. Fraudulent orders will be submitted to the appropriate authorities.</li>
							<li>Zaikart collects personally identifiable information that you may voluntarily provide on online forms, which may include: user registration, contact requests, guest comments, online surveys, and other online activities. The personally identifiable information (Personal Information) collected on this Site / our Mobile Application can include some or all of the following: your name, address, telephone number, email addresses, demographic information, and any other information you may voluntarily provide.</li>
						   <li> In addition to the Personal Information identified above, our web servers automatically identify computers by their IP addresses. Company may use IP addresses to analyze trends, administer the site track users movement and gather broad demographic information for aggregate use. To emphasize, IP addresses are not linked to Personal.</li>
						</ul>
						<br>
						 <h4 class="nomargin_top">Disclaimer</h4>
						<ul>
							<li>It is your own responsibility to ensure that you are fully aware of all of these terms and conditions when making a purchase on www.zaikart.com .</li>
							<li>Zaikart reserves the right to change / modify these terms & conditions at their own discretion anytime.</li>
						   <li> The images shown are only indicative in nature & the actual product may vary in size, colour etc.</li>
							<li>Zaikart reserves the right to change any part or piece of information on this web site without any notice to customers or visitors.</li>
						</ul>
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