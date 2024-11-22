<!-- Login modal -->

<div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_login_popup"><i class="icon_close_alt2"></i></a>
				<form action="login_process.php" class="popup-form" id="myLogin" method="post">
                	<div class="login_icon"><i class="icon_lock_alt"></i></div>
					<input type="text" id="cust_login" autofocus name="cust_login" class="form-control form-white" placeholder="Enter Either Email id or Mobile Number" required >
					<input type="password" id="password" name="password"  class="form-control form-white" placeholder="Enter Password" required>
					 <div class="text-left">
						<a  onclick="close_login()" style="cursor:pointer">Forgot Password?</a>
					</div> 
					<div id="login_msg" style="color:red;font-weight:bold"></div>
					<button type="submit" class="btn btn-submit">Login</button>

					<div><br>OR</div>

					<a  href="OauthLogin/google_logina.php?oauth=google"  class="btn btn-submit"><i class="fa fa-google-plus"></i>&nbsp;&nbsp;Login with Google</a>
					
					

					<a  href="OauthLogin/google_logina.php?oauth=facebook"  class="btn btn-submit"><i class="fa fa-facebook"></i>&nbsp;&nbsp;Login with Facebook</a>

				</form>
				<div id="login_msg"></div>

				
						 
									<!-- <span style="margin:2px;"><a class="btn2 login-btn" onMouseOver="this.style.color='#fff'" style="margin-top:02px;" href="OauthLogin/google_logina.php?oauth=google"><i class="fa fa-google-plus"></i>Login with Google </a></span>	 -->						


			</div>
		</div>
	</div><!-- End modal -->  

<a href="0" data-toggle="modal" data-target="#forgot_2"  id="triggerForgot_2"></a>
<!--  forgot password modal --> 
	<div class="modal fade" id="forgot_2" tabindex="-1" role="dialog" aria-labelledby="myForgot" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form action="forgot_password_form.php" class="popup-form" id="myForgot" method="post">
                	<div class="login_icon"><i class="icon_lock_alt"></i></div>
					<input type="text" id="reset_email_id" autofocus name="reset_email_id" class="form-control form-white" placeholder="Please enter an email address" required title="Please enter an email address" data-rule-email="true" data-msg-email="enter a valid email address">
					 <!-- <div class="text-left">	<a href="#">Login or Registration</a></div>  -->
					<div id="login_msg" style="color:red;font-weight:bold"></div>
					<button type="submit" class="btn btn-submit">Forgot Password</button>
				</form>
				<div id="forgot_msg"></div>
			</div>
		</div>
	</div><!-- End forgot password modal -->


<a href="0" data-toggle="modal" data-target="#reset_forgot_2"  id="trigger_Reset_Forgot_2"></a>
<!--  forgot Reset password modal --> 
	<div class="modal fade" id="reset_forgot_2" tabindex="-1" role="dialog" aria-labelledby="myForgot" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
			
				<form action="reset_password_form.php" class="popup-form" id="myForgotReset" method="post">
                
						<h4 class="modal-title">Reset Password</h4>
						<label><b>Email Address : <?php echo $email_id_enc_reset; ?></b></label>
					<input type="hidden" name="reg_email_id_reset" id="reg_email_id_reset" value="<?php echo $email_id_enc_reset; ?>">
					<input type="hidden" name="ses_id" id="ses_id" value="<?php echo $ses_id; ?>">
					


					<input type="password" id="reg_password1a" autofocus name="reg_password1a" class="form-control form-white" placeholder="Password" required title="Please enter password">

					<input type="password" id="reg_password2a" autofocus name="reg_password2a" class="form-control form-white" placeholder="Confirm Password" required title="Please confirm your password">

					 <!-- <div class="text-left">	<a href="#">Login or Registration</a></div>  -->
					<div id="login_msg" style="color:red;font-weight:bold"></div>
					<button type="submit" class="btn btn-submit">Change Password</button>
				</form>
				<div id="forgot_reset_msg"></div>
			</div>
		</div>
</div><!-- End forgot password modal -->

<a href="#0" data-toggle="modal" data-target="#guest2"  id="guest2a" ></a>
<div class="modal fade" id="guest2" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_guest2"><i class="icon_close_alt2"></i></a>
				<form action="cart_order.php" class="popup-form" id="login_guest"  name="login_guest" method="POST">

					<input type="hidden" name="form_id" id="form_id">
					<input type="hidden" name="delivery_location" id="frm_Modal_address" value="">
					<input type="hidden" name="extra_charge" id="extra_charge" value=''>
					<input type="hidden" name="extra_charge_amount" id="extra_charge_amount" value=''>

                	<a href="#0" onclick="open_login()"  class="button_intro2">Login</a>
					<h5><b><div id="order_total_amount_conf"></div></b></h5>
					<div class="row">
						<a href="#0" onclick="guest_login();" class="button_intro2">Login as Guest</a>
						
					</div>
				</form>
			</div>
		</div>
	</div>

