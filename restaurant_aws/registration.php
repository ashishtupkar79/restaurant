<!-- Register modal -->   
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myRegister" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form action="registration_form.php" class="popup-form" id="myRegister" method="post">
                	<div class="login_icon"><i class="icon_lock_alt"></i></div>
					<input type="text" class="form-control form-white" placeholder="First Name" name="fname" id="fname" required>
					<input type="text" class="form-control form-white" placeholder="Last Name" name="lname" id="lname">
                    <input type="email" class="form-control form-white" name="email" placeholder="Your email" required="" data-rule-email="true" data-msg-email="enter a valid email address">
					<input type="text" class="form-control form-white" placeholder="Mobile Number" name="mobile_number" required="" digits="true" maxlength="10" id="mobile_number" required>

					<input type="text" class="form-control form-white" placeholder="House No."  name="address1" maxlength="50" id="address1" required>
					<input type="text" class="form-control form-white"  placeholder="Street Name / Area" name="address2"   maxlength="50" id="address2" required>
					<input type="text" class="form-control form-white" placeholder="Landmark" name="address3"   maxlength="50" id="address3" required>

                    <input type="password" class="form-control form-white"	placeholder="Password"  id="password1" name="reg_password1">
                    <input type="password" class="form-control form-white"  placeholder="Confirm password"  id="password2" name="reg_password2">

                    <div id="pass-info" class="clearfix"></div>
					<div class="checkbox-holder text-left">
						<!-- <div class="checkbox">
							<input type="checkbox" value="accept_2" id="check_2" name="check_2" />
							<label for="check_2"><span>I Agree to the <strong>Terms &amp; Conditions</strong></span></label>
						</div> -->
					</div>
					<button type="submit" class="btn btn-submit" name="btn_register">Register</button>
				</form>
				<div id="register_msg"></div>
			</div>
		</div>
</div><!-- End Register modal -->
