<!-- Mobile Number  modal popup-->
	
	<?php
		if(!isset($_SESSION)) 
		{ 
			session_start(); 
		} 
		if(isset($_SESSION['active_chk']) && $_SESSION['active_chk']=='n' && isset($_SESSION['email_id_chk']) && $_SESSION['email_id_chk']!='' && isset($_SESSION['login_tag_chk']) && $_SESSION['login_tag_chk']!='')
		{
			echo '<a href="#0" data-toggle="modal" data-target="#mobile_number_popup"  id="mobile_number_id"></a>';
		}
	?>
	
	<div class="modal fade" id="mobile_number_popup" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup" style="padding: 1px 0 0;">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form action="chk_mobilenumber.php" class="popup-form" id="frm_mobile_number"  name="frm_mobile_number" method="POST" style="margin-bottom:10px;">
					
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<div class="form-group">
									<input type="hidden" name="active_chk" value="<?php echo $_SESSION['active_chk'] ?>">
									<input type="hidden" name="email_id_chk" value="<?php echo $_SESSION['email_id_chk'] ?>">
									<input type="hidden" name="login_tag_chk" value="<?php echo $_SESSION['login_tag_chk'] ?>">

									<input type="text" class="form-control " name="mobile_number" id="mobile_number"   required  placeholder="Enter Mobile Number" digits="true" data-rule-required="true" data-msg-required="Please enter 10 digits mobile number" minlength="10" maxlength="10" autofocus>
							 </div>
						</div>
						<div class="col-md-2 col-sm-2">
							<input type="submit" class="button_intro2" name="submit_mobile_number" id="submit_mobile_number"  value="Submit" style="margin-top:20px;">
						</div>

					</div>
				</form>
				
				<form action="chk_mobilenumber.php" class="popup-form" id="frm_verification_number"  name="frm_verification_number" method="POST" style="margin-top:0px;margin-bottom:0px;">
					
					<div class="row">
						<div class="col-md-9 col-sm-9">
							<div class="form-group">
									<input type="hidden" name="active_chk" value="<?php echo $_SESSION['active_chk'] ?>">
									<input type="hidden" name="email_id_chk" value="<?php echo $_SESSION['email_id_chk'] ?>">
									<input type="hidden" name="login_tag_chk" value="<?php echo $_SESSION['login_tag_chk'] ?>">
									<input type="hidden" name="mobile_number1" value="" id="mobile_number1">
									

									<input type="text" class="form-control " name="mobile_verification_code" id="mobile_verification_code"   required  placeholder="Enter Mobile Verification Code" digits="true" data-rule-required="true" data-msg-required="Please enter 06 digits mobile verification code" minlength="06" maxlength="06" style="display:none" autofocus>
							 </div>
						</div>
						<div class="col-md-2 col-sm-2">
							<input type="submit" class="button_intro2" name="btn_mobile_verification_code" id="btn_mobile_verification_code"  value="Verify" style="margin-top:20px;display:none">
						</div>

					</div>
				</form>
				<div id="myverification_msg" style="color:red;font-weight:bold;padding-bottom:10px;display:none"></div>
				<div id="mymobile_msg" style="display:none"></div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function chk_mobile()
		{
			
			var active_chk = "<?php echo $_SESSION['active_chk'] ?>";
			var email_id_chk = "<?php echo $_SESSION['email_id_chk'] ?>";
			var login_tag_chk = "<?php echo $_SESSION['login_tag_chk'] ?>";
			if(active_chk.length > 0 && email_id_chk.length > 0 && login_tag_chk.length > 0)
			{

				
				$( "#mobile_number_id" ).trigger( "click" );
				
				
				destroy_session();
			}
			
		}
		function destroy_session()
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
					//alert(response);
					document.getElementById("mobile_number").focus();
				}
			}
			xmlhttp.open("GET", "oauth_session.php",true);
			xmlhttp.send();
	
		}
	</script>


	

<!-- Check Mobile Number and  Verification Code-->
<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_mobile_number').validate({}); // For Validation should be there

	var options = { 
        target:        '#mymobile_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_mobile_number').ajaxForm(options); 
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
		if(response_val[0]=='save')
		{
			document.getElementById("mobile_number").readOnly = true;
			document.getElementById("submit_mobile_number").style.display = "none";
			document.getElementById("mobile_verification_code").style.display = "";
			document.getElementById("btn_mobile_verification_code").style.display = "";
			document.getElementById("mobile_number1").value=response_val[1];
			document.getElementById("mobile_verification_code").focus();
		}
		else if(response_val[0]=='error')
		{
			alert(response_val[1]);
		}
		
		/*else if(response_val[0]=='success')
		{
			alert(response_val[1]);
			window.location.reload();
		}*/
	}	 
});
</script>

<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_verification_number').validate({}); // For Validation should be there

	var options = { 
        target:        '#myverification_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_verification_number').ajaxForm(options); 
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
		/*if(response_val[0]=='save')
		{
			document.getElementById("mobile_number").readOnly = true;
			document.getElementById("submit_mobile_number").style.display = "none";
			document.getElementById("mobile_verification_code").style.display = "";
			document.getElementById("btn_mobile_verification_code").style.display = "";
			document.getElementById("mobile_number1").value=response_val[1];
		}*/
		if(response_val[0]=='error')
		{
			alert(response_val[1]);
			document.getElementById("myverification_msg").style.display = "";
			document.getElementById("myverification_msg").innerHTML = response_val[1];
		}
		else if(response_val[0]=='success')
		{
			alert(response_val[1]);
			document.getElementById("myverification_msg").style.display = "";
			document.getElementById("myverification_msg").innerHTML = response_val[1];
			window.location.reload();
		}
	}	 
});
</script>


<!-- Check Mobile Number and  Verification Code-->


	
	<!-- End Mobile Number  modal popup -->