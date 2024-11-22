<?php
session_start();
if((!isset($_SESSION['email_id']) && !isset($_SESSION['mobile_number'])) || (!isset($_SESSION['email_id']) && !isset($_SESSION['login_tag'])))
	header("Location:logout.php");

include ('db_connect.php');
$connection = new createConnection(); //i created a new object


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

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="css/new_font-awesome.min.css">-->
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

<body>
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
    <!-- Header ================================================== -->
	<!-- SubHeader =============================================== -->
	<!-- End SubHeader ============================================ -->
    <!-- </header> -->
    <!-- End Header =============================================== -->
	<!-- Content ================================================== -->
<div class="container margin_60_35">
	<div class="row">
    
    <div class="col-md-3" id="sidebar">
    <div class="theiaStickySidebar">
        <div class="box_style_1" id="faq_box">
			
		</div><!-- End box_style_1 -->
        </div><!-- End theiaStickySidebar -->
     </div><!-- End col-md-3 -->
        
        <div class="col-md-9">
        	<div class="box_style_2">
       			 <div class="row">
                	<?php
						$where = " mobileno = '$mobile_number' and order_status='ORPSC'   ";
						$order = "order_complete_date desc";
						$results=$connection->get_data("order_master","orderid,order_amt_payable,order_verify_date,free_meal",$where,null);
					?>
					<h4 class="nomargin_top"  id="zaikartserviceuse">My Orders</h4>
						<div class=" table-responsive">
							<table class="table">
									<thead>
									  <tr>
										
										<th>Order Id</th>
										<th>Order Date</th>
										<th>Amount</th>
										<th>Show Order Detail</th>
										<th>Re Order</th>
									   
									  </tr>
									</thead>
									<tbody>
										<?php
											foreach($results as $usrinfo)
											{
												
												$order_id =$usrinfo['orderid'];
												$order_amt_pay = $usrinfo['order_amt_payable'];
												$order_verify_date = $usrinfo['order_verify_date'];
												$free_meal = $usrinfo['free_meal'];
												if($free_meal == 'y')
													$free_meal='&nbsp;<b style="color:red">Free Meal</b>';
												else
													$free_meal="";
												  echo '<tr>';
													echo '<td>'.$order_id.$free_meal.'</td>';
													echo '<td>'.date('d-m-Y', strtotime($order_verify_date)).'</td>';
													echo '<td><i class="fa fa-inr"></i> '.$order_amt_pay.'</td>';
													echo '<td><a href="#0"  data-toggle="modal" data-target="#show_my_orders"  data-id="'.$order_id.'" class="button_intro2" style="cursor:pointer;padding: 2px 15px;">Show</a></td>';
													echo '<td><a href="reorder.php?orderid='.urlencode($order_id).'"  class="button_intro2" style="cursor:pointer;padding: 2px 15px;">Reorder</a></td>';
												 echo ' </tr>';
											}
										?>
								</tbody>
							</table>
						</div>
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
<?php require 'show_order_details.php'; ?>
<!-- COMMON SCRIPTS -->
<?php require 'commonscripts.php'  ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#show_my_orders').on('show.bs.modal', function(event) {
        $("#orderId").val($(event.relatedTarget).data('id'));
    });
});

$(document).ready(function() {
$('#show_my_orders').on('shown.bs.modal', function() {
    
	var order_id = document.getElementById("orderId").value;
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
				
			}
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response =  xmlhttp.responseText;
				document.getElementById("myorders").innerHTML = response;
			}
		}
		xmlhttp.open("GET", "myorderdetails.php?orderid="+order_id,true);
		//xmlhttp.open("GET", "cart.php?add_more_items="+add_more_items,true);
		xmlhttp.send();

})
});
</script>
</body>
</html>