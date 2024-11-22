<?php
	$hide_login= true;
	$order_id= $_GET['order_id'];
	$mobile_no= trim($_GET['mobile_no']);
	$email_id= trim($_GET['email_id']);
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	//require 'pdf.php';
	session_start();
	$sid = session_id();
	$mobile_no= trim($_GET['mobile_no']);
	$email_id= trim($_GET['email_id']);
	$order_id= $_GET['order_id'];
	$free_credit_remain= $_GET['free_credit_remain'];
	$free_meal= $_GET['free_meal'];
	if($mobile_no =="" || $email_id =="" || $order_id =="" || $free_meal =="")
	{
		header("Location:index.php");
		exit;
	}
	$getMyOrders=$connection->getMyOrders2($order_id);
	$numItem = count($getMyOrders);
	if($numItem == 0)
	{
		header("Location:index.php");
		exit;
	}
	$getMyOrder_exist=$connection->getMyOrder_exist($order_id);
	if(count($getMyOrder_exist) <= 0)
	{
		header("Location:detail_page.php");
		exit;
	}
	$rows = array('order_verify_date'=>$connection->get_date(), 'order_status'=>'ORPS', 'free_meal'=>'y','free_credit_remain'=>$free_credit_remain,'payment_type'=>'free');
	$where = " orderid = '$order_id'  and order_verify_date is null and payment_type is null  and order_status='ORP' ";
	$connection->update_data('order_master',$rows,$where);
	$where = " ct_session_id = '$sid' ";
	$results=$connection->delete_data("cart",$where);
	unset($_SESSION['delivery_location']);
	unset($_SESSION['later_order']);
	$exist = false;
	/*
	if($mobile_no !="" && $email_id !="" && $order_id !="" && $email_id !="")
	{
		$where = " mobile_number ='".trim($mobile_no). "   and  active is null and active_date is null";
		$results=$connection->get_data("customer_master","mobile_number,email_id",$where,null);
		$exist = false;
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['mobile_number'])>0)
				$exist= true;
		}
	}*/

	if(isset($_SESSION['login_tag']) && $_SESSION['login_tag']!="" &&  isset($_SESSION['email_id']) && $_SESSION['email_id']!="" &&  isset($_SESSION['mobile_number']) && $_SESSION['mobile_number']!="" &&  isset($_SESSION['login_tag']) && $_SESSION['login_tag']!="")
	{
		$exist= false;
	}	
	else
	{
		$where = " mobile_number ='".trim($mobile_no). "'   and  password is null and email_id is null ";
		$results=$connection->get_data("customer_master","mobile_number,email_id",$where,null);
		$exist = false;
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['mobile_number'])>0)
				$exist= true;
		}
	}
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="pizza, delivery food, fast food, sushi, take away, chinese, italian food">
    <meta name="description" content="">
    <meta name="author" content="Ansonika">
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
$('#frm_comfirmationPassword').validate({}); // For Validation should be there

	var options = { 
        target:        '#msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_comfirmationPassword').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
		if(responseText == 'success')
		{
				document.getElementById("msg").innerHTML = "<h3>Your password is set</h3>";
				document.getElementById("passwordbox").style.display = "none";
		}
	}	 
});

</script>
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

	<?php require 'menu.php'; ?>
    <!-- Header ================================================== -->
	<!-- SubHeader =============================================== -->
    <div id="subheader2">
    	<div id="sub_content2">
    	 <h1>Place your order</h1>
            <div class="bs-wizard">
                <div class="col-xs-4 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum"><strong>1.</strong> Your details</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>
                               
                <div class="col-xs-4 bs-wizard-step disabled">
                  <div class="text-center bs-wizard-stepnum"><strong>2.</strong> Payment</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>
            
              <div class="col-xs-4 bs-wizard-step active">
                  <div class="text-center bs-wizard-stepnum"><strong>3.</strong> Finish!</div>
                  <div class="progress"><div class="progress-bar"></div></div>
                  <a href="#0" class="bs-wizard-dot"></a>
                </div>  
		</div><!-- End bs-wizard --> 
        </div><!-- End sub_content -->
	</div><!-- End subheader -->

<!-- End SubHeader ============================================ -->

    <!-- </header> -->
    <!-- End Header =============================================== -->

<!-- Content ================================================== -->

<div class="container margin_60_35_2" style="padding-top:20px;">
	<div class="row">
		<div class="col-md-offset-3 col-md-6">
			<div class="box_style_2">
				<h2 class="inner">Thank you, your order was placed at</h2>
				<div id="confirm">
					<h3></h3>
					<p><img src="img/zaikart_logo.png" width="30%" height="30%"></p>
					<h3>Order Number: <?php echo urldecode($_GET['order_id']); ?> </h3>
					<h3>We will confirm your order shortly.</h3>
					<a href="index.php" class="button_intro2">Back to Order Online</a> 
				</div>
				<?php
					if($exist == true)
					{
						echo '<form id="frm_comfirmationPassword" method="POST" action="thanks_procees.php" >' ;
						echo '<input type="hidden" name="mobile_no" value="'.$mobile_no.'">';
						echo '<input type="hidden" name="email_id" value="'.$email_id.'">';
						echo '<div align="center" id="passwordbox">';
						echo '<h5>Set a password and Login with your email next time for faster checkouts.</h3>';
						echo '<div class="row" ><div class="col-md-6 col-sm-6" ><div class="form-group">
								<input type="text" class="form-control" name="password"  id="password" placeholder="Password" required="" required="" autofocus>
							</div></div><div class="col-md-3 col-sm-6"><div class="form-group"><input type="submit" class="button_intro2" name="confirm_pwd" id="confirm_pwd"  value="Confirm and Set Password" style="cursor:pointer"  onClick="frm_submit();">	</div></div></div>';
						echo '</div>';
						echo '</form>';
						echo '<div id="msg"></div>';
					}
			?>
				
			</div>
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
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/jquery.validate.js"></script>
<script src="js/additional-methods.js"></script>
<script src="js/jquery.form.js"></script>
<script type="text/javascript">
	$(document).ready(function () {

		$('#frm_Address').validate({}); // For Validation should be there
});
</script>
<style type="text/css">
	 label.error {
	color: red;
	line-height:15px;
}
</style>
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
			window.location.reload();s
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

<script src="js/map.js"></script>
<script src="js/infobox.js"></script>
<script src="js/ion.rangeSlider.js"></script>
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
function show_button()
{
	document.getElementById("show_continue").style.display = "";
}
</script>
<script type="text/javascript">
	function confirmation_code()
	{
		try
		{
			var mobile_code = "<?php echo  $mobile; ?>";
			var email_id = "<?php echo  $email; ?>";
			var order_id = "<?php echo  $order_id; ?>";
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
					document.getElementById("mob_payment_select").style.display = "";
				}
			}
			xmlhttp.open("GET", "request_order_code.php?mobile_code="+mobile_code+"&order_id="+order_id+"&email_id="+email_id,true);
			xmlhttp.send();
		}
		catch (ex)
		{
			alert(ex);
		}
	}
</script>
<script>
$(document).ready(function(){
   $("#pickup").click(function()
		{
			$("#address").removeAttr("required");
		});

		$("#delivery").click(function()
		{
			$("#address").prop('required',true);
		});
});
</script>
</body>
</html>