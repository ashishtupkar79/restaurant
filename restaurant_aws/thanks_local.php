<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache");
header("Expires: 0");

include ('db_connect.php');
$connection = new createConnection(); //i created a new object
$send_mail = false;



if($_POST["ORDERID"] && $_POST["ORDERID"] !="") 
{
		if($_POST["STATUS"] == "TXN_SUCCESS") 
		{
			$order_id = $_POST["ORDERID"];
			//$order_id= $_POST['order_id'];
			
			$where = " orderid = '$order_id' ";
			$results=$connection->get_data("order_master","mobileno,email_id",$where,null);
			foreach($results as $usrinfo)
			{
				$mobile_no = $usrinfo['mobileno'];
				$order_email_id = $usrinfo['email_id'];
			}
			
		}
	}
	else
	{
		header("Location:index.php");
		exit;
	}

$getMyOrder_exist=$connection->getMyOrder_exist($_POST["ORDERID"]);
if(count($getMyOrder_exist) <= 0)
{
	header("Location:detail_page.php");
	exit;
}

session_start();
$sid = session_id();


// following files need to be included
require_once("./lib/config_paytm.php");
require_once("./lib/encdec_paytm.php");

$paytmChecksum = "";
$paramList = array();
$isValidChecksum = "FALSE";

$paramList = $_POST;
$paytmChecksum = isset($_POST["CHECKSUMHASH"]) ? $_POST["CHECKSUMHASH"] : ""; //Sent by Paytm pg

//Verify all parameters received from Paytm pg to your application. Like MID received from paytm pg is same as your application�s MID, TXN_AMOUNT and ORDER_ID are same as what was sent by you to Paytm PG for initiating transaction etc.
$isValidChecksum = verifychecksum_e($paramList, PAYTM_MERCHANT_KEY, $paytmChecksum); //will return TRUE or FALSE string.


	if($_POST["ORDERID"] && $_POST["ORDERID"] !="") 
	{
		$order_id = $_POST["ORDERID"];
		$rows = array('paytm_currency'=>$_POST['CURRENCY'],'paytm_txnid'=>$_POST['TXNID'],'paytm_banktxnid'=>$_POST['BANKTXNID'],'paytm_status'=>$_POST['STATUS'],'paytm_respcode'=>$_POST['RESPCODE'],'paytm_txndate'=>$_POST['TXNDATE'],'paytm_gatewayname'=>$_POST['GATEWAYNAME'],'paytm_bankname'=>$_POST['BANKNAME'],'paytm_paymentmode'=>$_POST['PAYMENTMODE']);
		$where = " orderid = '$order_id' and payment_type ='online' ";
		$connection->update_data('order_master',$rows,$where);

		
		$rows = array('order_verify_date'=>$connection->get_date());
		$where = " orderid = '$order_id'  and order_verify_date is null ";
		$connection->update_data('order_master',$rows,$where);
		

		$where = " ct_session_id = '$sid' ";
		$results=$connection->delete_data("cart",$where);

		unset($_SESSION['delivery_location']);
		unset($_SESSION['later_order']);

		$where = " orderid = '$order_id' ";
		$results=$connection->get_data("order_master","mobileno,email_id",$where,null);
		foreach($results as $usrinfo)
		{
			$mobile_no = $usrinfo['mobileno'];
			$order_email_id = $usrinfo['email_id'];
		}
		if(strlen($mobile_no) > 0 && strlen($order_email_id) > 0)
		{
			$where = " mobile_number ='".trim($mobile_no). "  and  active is null and active_date is null";
			$results=$connection->get_data("customer_master","mobile_number",$where,null);
			$exist = false;
			foreach($results as $usrinfo)
			{
				if(strlen($usrinfo['mobile_number'])>0)
					$exist= true;
			}
		}
	}
		
		
		

	
	else
	{
		header("Location:index.php");
		exit;
	}

	//echo 'exists='.$exist;

	$where = " ct_session_id = '$sid' ";
	$results=$connection->delete_data("cart",$where);
	unset($_SESSION['delivery_location']);

	$exist = false;
	if($mobile_no !="" && $order_email_id !="" && $order_id !="" && $order_email_id !="")
	{
		$where = " mobile_number ='".trim($mobile_no). "' and email_id='".$order_email_id."'   and  active is null and active_date is null";
		$results=$connection->get_data("customer_master","mobile_number",$where,null);
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
		//alert(responseText);
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

				<?php
					if($isValidChecksum == "TRUE") 
					{
						if($_POST["STATUS"] == "TXN_SUCCESS") 
						{

							$order_id = $_POST["ORDERID"];
							$rows = array('order_status'=>'ORPS');
							$where = " orderid = '$order_id' and payment_type = 'online' and paytm_status='TXN_SUCCESS' ";
							$OrdertStat=$connection->update_data('order_master',$rows,$where);
							if($OrdertStat)
							{
									$where = " orderid = '$order_id' and payment_type = 'online' and paytm_status='TXN_SUCCESS' ";
									$request_date_time=$connection->get_data("order_master","delivery_day,delivery_time",$where,null);
									foreach($request_date_time as $request_date_time_val)
									{
										$delivery_day = $request_date_time_val['delivery_day'];
										$delivery_time = $request_date_time_val['delivery_time'];
									}

								//echo "<b>Transaction status is success</b>" . "<br/>";
								echo '<h2 class="inner">Thank you! your order was placed at</h2>
								<div id="confirm">
								<h3></h3>
								<p><img src="img/zaikart_logo.png" width="30%" height="30%"></p>
								<h3>Your payment was processed successfully, </h3>
								<h3>Order Number: '.$_POST['ORDERID'].'</h3>
								<h3>We will confirm your order shortly.</h3>';
								

								$send_mail = true;

							}

						}
						else 
						{

							$order_id = $_POST["ORDERID"];
							$rows = array('order_status'=>'ORPF');
							$where = " orderid = '$order_id' and payment_type = 'online'  ";
							$connection->update_data('order_master',$rows,$where);


							
							echo '<h2 class="inner"  align="center">Sorry, your payment failed.</h2>
							<div id="confirm">
							<h3></h3>
							<p><img src="img/zaikart_logo.png" width="30%" height="30%"></p>
							<h3>We could not process your order.</h3>';
						}
					}
					else 
					{
						$order_id = $_POST["ORDERID"];
							$rows = array('order_status'=>'ORPF');
							$where = " orderid = '$order_id' and payment_type = 'online'  ";
							$connection->update_data('order_master',$rows,$where);

						
							echo '<h2 class="inner" align="center">Sorry, your payment failed</h2>
							<div id="confirm">
							<h3></h3>
							<p><img src="img/zaikart_logo.png" width="30%" height="30%"></p>
							<h3>We could not process your order.</h3>';
					}
			?>
				





					
					<a href="index.php" class="button_intro2">Back to Order Online</a> 
					

					<?php
					if($exist == true)
					{
						echo '<form id="frm_comfirmationPassword" method="POST" action="thanks_procees.php" >' ;
						echo '<input type="hidden" name="mobile_no" value="'.$mobile_no.'">';
						echo '<input type="hidden" name="email_id" value="'.$order_email_id.'">';
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
			$("document").ready(function(){
				$( ".close-link" ).trigger( "click" );
			});
			window.location.reload();
		}
		if(type == 'error')
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
				//document.getElementById("cart").innerHTML = response;
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

<?php
if($send_mail)
{

	/* confirmation mail */

						require 'pdf.php';
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

						
									
						
						
						$to= $order_email_id;
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
						mail($to, $subject, $message, $headers, $returnpath); 
							/* confirmation mail script ends here*/
						
						//unlink($files[0]);

}
?>