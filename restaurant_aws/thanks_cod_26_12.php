<?php
	session_start();
	$hide_login= true;
	$cod_type=$_GET['cod'];
	if($cod_type != 'cod' && $cod_type != 'pcod')
	{
		header("Location:index.php");
		exit;
	}
	$order_id= $_GET['order_id'];
	$mobile_no= trim($_GET['mobile_no']);
	$email_id= trim($_GET['email_id']);
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object

	

	//require 'pdf.php';
	$sid = session_id();
		
	
	if($mobile_no =="" || $email_id =="" || $order_id =="")
	{
		header("Location:index.php");
		exit;
	}
		
	
	$getMyOrders=$connection->getMyOrders($order_id);
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
	
	$message=session_id()."~ $cod_type order processed";
	$connection->logEvent($message);

	$rows = array('order_verify_date'=>$connection->get_date(), 'order_status'=>'ORPS');
	$where = " orderid = '$order_id'  and order_verify_date is null and payment_type='$cod_type' and order_status = 'ORPOTV' ";
	$connection->update_data('order_master',$rows,$where);


	$where = " ct_session_id = '$sid' ";
	$results=$connection->delete_data("cart",$where);
	unset($_SESSION['delivery_location']);
	unset($_SESSION['later_order']);
	$exist = false;
	
	
	/* <!-- 06-10-2016 -->
	//if($mobile_no !="" && $email_id !="" && $order_id !="" )
	{
		$where = " mobile_number ='".trim($mobile_no). "'   and  active is null and active_date is null";
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
	 <!-- <header> -->
    <!-- <header class="sticky"> -->
    
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
					<p><img src="img/zaikart_logo.png" width="30%" height="30%">	
					</p>

					<h3>Order Number: <?php echo urldecode($_GET['order_id']); ?> </h3>
					<h3>We will confirm your order shortly.</h3>
					
					<a href="index.php" class="button_intro2">Back to Order Online</a> 

					<?php
					   /*
					   $where = " orderid = '$order_id' and payment_type = 'cod'  ";
						$request_date_time=$connection->get_data("order_master","delivery_day,delivery_time",$where,null);
						foreach($request_date_time as $request_date_time_val)
						{
							$delivery_day = $request_date_time_val['delivery_day'];
							$delivery_time = $request_date_time_val['delivery_time'];
						}

						
						
						$file = 'invoice/'.$order_id.'_invoice.pdf';
						
						$file_size = filesize($file);
						$handle = fopen($file, "r");
						$content = fread($handle, $file_size);
						fclose($handle);
						$content = chunk_split(base64_encode($content));
						$uid = md5(uniqid(time()));
						$name = basename($file);
						$body="";

						if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
							$protocol = 'https://';
						else
							$protocol = 'http://';

						$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
						$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
						$body.='<div  style="background: #fff none repeat scroll 0 0;border: 5px solid #ededed;border-radius: 3px;margin-bottom: 10px;padding: 2px;text-align:center"><h2 style="background-color: #78cfcf;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 22pxpx;font-weight: 600;margin: -25px -25px 25px;padding: 12px 15px;">Thank you! Your order was placed at</h2><div id="confirm"><h3></h3><p><img src="'.$img_src.'" width="252" height="218"/></p><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Number: <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$order_id.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Time requested for : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$delivery_day.' - '.$delivery_time.'</b></h3><hr style=" -moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #eee moz-use-text-color -moz-use-text-color;border-image: none;border-style: solid none none;border-width: 1px 0 0;margin-bottom: 10px;margin-top: 10px;"><h4 align="center">You will receive an SMS with an estimated time for delivery via SMS<br>Sit back, relax and your food will arrive at your door in no time.</h4><h4 align="center">This order will be delivered directly by</h4><h4 align="center"><b>Zaikart</b></h4><h4 align="center"><b>Plot No. 17, House- Sneha, Gayatri Nagar, Near IT park,  Nagpur, 440022</b></h4><h3 style="color: #78CFCF;font-size: 24px;font-family: inherit;font-weight: 500;line-height: 1.1;"><b>For any changes, please contact the restaurant directly on:</b></h3>	<h3><b>+91 7378845457, 7378845458</b></h3><h4 align="center"><i>Please note: if you are paying by credit card, the description on your statement will appear as Zaikart PVT LTD Nagpur.</i></h4></div></div>';
									
						$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
						$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
						$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
						$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
						$body .="<br> &#169; Zaikart 2016. All rights reserved";

						
									
						
						
						$to= $email_id;
						//$to='ashishtupkar@gmail.com';
						$files[0]='invoice/'.$order_id.'_invoice.pdf';
						$from="noreply@zaikart.com";
						$sendermail=$from;
						$subject = "Congratulations...Your order was placed successfully at Zaikart";
						$message =$body;
						$headers = "From: $from";
 
						// boundary 
						$semi_rand = md5(time()); 
						$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x"; 
 
						// headers for attachment 
						$headers .= "\nMIME-Version: 1.0\n" . "Content-Type: multipart/mixed;\n" . " boundary=\"{$mime_boundary}\""; 
					 
						// multipart boundary 
						$message = "--{$mime_boundary}\n" . "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
						"Content-Transfer-Encoding: 7bit\n\n" . $message . "\n\n"; 
					 
						// preparing attachments
						for($i=0;$i<count($files);$i++){
							if(is_file($files[$i])){
								$message .= "--{$mime_boundary}\n";
								$fp =    @fopen($files[$i],"rb");
							$data =    @fread($fp,filesize($files[$i]));
										@fclose($fp);
								$data = chunk_split(base64_encode($data));
								$message .= "Content-Type: application/octet-stream; name=\"".basename($files[$i])."\"\n" . 
								"Content-Description: ".basename($files[$i])."\n" .
								"Content-Disposition: attachment;\n" . " filename=\"".basename($files[$i])."\"; size=".filesize($files[$i]).";\n" . 
								"Content-Transfer-Encoding: base64\n\n" . $data . "\n\n";
								}
							}
						$message .= "--{$mime_boundary}--";
						$returnpath = "-f" . $sendermail;
						$ok = @mail($to, $subject, $message, $headers, $returnpath); 

						unlink($files[0]);
						
			*/
					?>
				
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
<?php //require 'registration.php'; ?>
    
    
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