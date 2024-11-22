<!-- Login modal -->   
<div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form action="login_process.php" class="popup-form" id="myLogin" method="post">
                	<div class="login_icon"><i class="icon_lock_alt"></i></div>
					<input type="text" id="cust_login" autofocus name="cust_login" class="form-control form-white" placeholder="Enter Either Email id or Mobile Number" required >
					<input type="password" id="password" name="password"  class="form-control form-white" placeholder="Enter Password" required>
					<!-- <div class="text-left">
						<a href="#">Forgot Password?</a>
					</div> -->
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