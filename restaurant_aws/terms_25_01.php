<?php
 session_start();
  include ('db_connect.php');
  $connection = new createConnection(); //i created a new object
  
	if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$_SESSION['link'] ="terms.php";

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
	<div class="row">
    
    <div class="col-md-3" id="sidebar">
    <div class="theiaStickySidebar">
        <div class="box_style_1" id="faq_box">
			<ul id="cat_nav">
				<li><a href="#zaikartserviceuse" class="active" >Zaikart Service Use</a></li>
				<li><a href="#ordering">Ordering</a></li>
				<li><a href="#prices">Prices & Payment</a></li>
				<li><a href="#delivery">Delivery</a></li>
				<li><a href="#personal">Personal Information & Privacy</a></li>
                <li><a href="#ownership">Ownership Of Intellectual Property</a></li>
				 <li><a href="#ownership">Terms & Conditions for Free Meal</a></li>
                
			</ul>
		</div><!-- End box_style_1 -->
        </div><!-- End theiaStickySidebar -->
     </div><!-- End col-md-3 -->
        
        <div class="col-md-9">
        	<div class="box_style_2">
       			 <div class="row">
                  
					



	<h4 class="nomargin_top"  id="zaikartserviceuse">Zaikart Service Use</h4>
	<ul>
    <li>User is hereby allowed to use the Zaikart Service subject to acceptance of the terms and conditions and the Privacy Policy on the Zaikart Website ("Terms"). Zaikart retains the right to change the Terms from time to time and such modified Terms shall be immediately applicable. Every time you use the Zaikart Service, shall constitute your acceptance of changes made to Terms. For detailed terms, please refer our website www.Zaikart.com</li>
	</ul>
<br>
 <h4 class="nomargin_top" id="ordering">Ordering</h4>
<ul>
    <li> As user you agree that, any contract for the Food and Food Delivery ordered through use of Zaikart Website is between you and Zaikart; any contract for the supply of Zaikart Service from the Zaikart Website is between you and Zaikart. You agree to take reasonable care when providing Zaikart with your details and warrant that these details are accurate and complete at the time of ordering food. You also warrant that the credit or debit card details that you provide are of your own credit or debit card.</li>
   <li>Zaikart ensures quality standards and is solely responsible and liable for all and any issues and cases pertaining to the quality of the food or order for eg. veg/non-veg labelling etc but not limited to this, to the User directly. </li>
    <li>User understands that some type of Food may be suitable for Users within certain age ranges only. It is your sole responsibility to check whether the Food you are ordering is suitable for the intended recipient.</li>
</ul>
	<br>
 <h4 class="nomargin_top" id="prices">Prices & Payment</h4>
<ul>
    <li>All prices listed on the Zaikart Website for Food is correct at the time of publication. While Zaikart takes great care to keep them up-to-date, the final price charged to you by the Zaikart may change at the time of delivery ,based on the latest menu and prices. Zaikart reserves the right to alter the menu of Food available for sale on the Zaikart Website and to delete and remove from listing their menu of Food and Food Delivery options, if any.</li>
    <li>All prices listed on the Zaikart Website for Food Delivery reflect the price charged by Zaikart at the time of listing. In the event of change in price for Food Delivery, Zaikart will try to make every possible effort to inform the User about the price difference and the User can choose to opt-out of the order at that time.</li>
   <li> User agrees that in case of change in price, Zaikart or its employees will not be liable in any manner.</li>
    <li>The total price for Food and Food Delivery including all other charges, taxes, costs, if any, will be displayed on the Zaikart Website when you place your order. Full payment must be made for all the particulars mentioned in the order.</li>
    <li>If you choose online payment, you shall ensure that online payment mode is secured, your debit/credit card details will be encrypted to prevent the possibility of someone being able to read them as they are sent over the internet. Your credit card company may also conduct necessary security checks to confirm about your identification before making any such payment.</li>

</ul>
<br>
 <h4 class="nomargin_top" id="delivery">Delivery</h4>
<ul>
    <li>Delivery period quoted at the time of ordering are approximate only and may vary. Food will be delivered to the address as intimated by you while ordering.</li>

    <li>Zaikart will make every effort to deliver within the time stated; however, Zaikart will not be liable for any loss caused to you by late delivery. If the Food is not delivered within the estimated delivery time quoted, User shall contact  Zaikart. You may also contact Zaikart by email and Zaikart will try to ensure that you receive your order as quickly as reasonably possible.</li>

   <li>In case of a late delivery, the delivery charge will neither be voided nor refunded by Zaikart.</li>

    <li>If you fail to accept delivery of Food at the time they are ready for delivery or Zaikart is unable to deliver at the nominated time due to your failure to provide appropriate instructions or authorizations, then the Food shall be deemed to have been delivered to you and all risk and responsibility in relation to such Food shall pass on to you. Any storage, insurance and other costs which Zaikart incur as a result of the inability to deliver shall be your responsibility and you shall indemnify Zaikart in full for such cost.</li>

    <li>You must ensure that at the time of delivery of Food adequate arrangements, including access where necessary, are in place for the safe delivery of the Food. Zaikart cannot be held liable for any damage, cost or expense incurred to such Food as a result of a failure to provide adequate access or arrangements for delivery.</li>

</ul>
<br>
 <h4 class="nomargin_top" id="personal">Personal Information & Privacy</h4>
<ul>
    <li>User understands and acknowledges that by choosing Zaikart you have allowed Zaikart to use your personal information.</li>
    <li>User understands, acknowledges and agrees that although Zaikart provides appropriate firewalls and protections, the Zaikart Service is not hack proof. Data pilferage due to unauthorized hacking, virus attacks, technical issues is possible.</li>
   <li> In case Zaikart is required to disclose your personal information in order to assist the Government Authority or in adherence to the Court Order or to protect the interest of the Zaikart Service and/or any particular user(s), Zaikart will disclose it without obtaining prior permission from you. You authorize us to disclose your personal information.</li>

</ul>
<br>
 <h4 class="nomargin_top" id="ownership">Ownership Of Intellectual Property</h4>
<ul>
    <li>All intellectual property rights of the Zaikart, including but not limited to copyright, logos, names, trademarks, service marks, design, text, sound recordings, images, links, concepts and themes are exclusively owned by the Zaikart. Any reproduction, transmission, publication, performance, broadcast, alteration, license, hyperlink, creation of derivative works or other use in whole or in part in any manner is strictly prohibited.</li>
</ul>

<br>
 <h4 class="nomargin_top" id="ownership">Terms & Conditions for Free Meal</h4>
<ul>
	<li>Every 10th meal free will serve only one person.</li>
	<li>The maximum amount of food products that the customer can avail on his/her's 10th order is Rs.230..</li>
	<li>This offer is applicable on every 10th order. (Example: If a person orders 20 times from Zaikart he/she is eligible for two free meals.).</li>
	<li>Every 10th meal free offer can only be availed through the website.</li>
	<li>To provide this offer Zaikart will track the customers mobile number only.</li>
	<li>The lucky customer to receive a free meal every month can order upto Rs.500.</li>
	<li>The lucky customer will receive an email in which all the information will be given to avail that offer.</li>
	<li>This offer can only be availed by logging in.</li>
</ul>

<br>
 <h4 class="nomargin_top" id="ownership">Terms & Conditions for 25% off ( Only on Wednesdays )</h4>
<ul>
	<li>Get 25% off every Wednesday between 08:00 - 10:00 p.m.</li>
	<li>Offer valid only on orders of Rs.500 and above.</li>
	<li>Offer not valid for free meals.</li>
</ul>


					
				</div><!-- End box_style_1 -->
			</div>
		</div><!-- End row -->


		

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