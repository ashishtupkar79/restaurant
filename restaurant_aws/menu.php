<style type="text/css">
	 label.error {
	/* remove the next line when you have trouble in IE6 with labels in list */
	color: red;
	line-height:15px;
}
</style>
<header class="sticky">
      <div class="container-fluid">
        <div class="row">
			<div class="col--md-4 col-sm-4 col-xs-4">
                <a href="index.php" id="logo"><img src="img/Zaikart_Text.png"  height="23" alt="" data-retina="true"></a>
			</div>
			<nav class="col--md-8 col-sm-8 col-xs-8">
			<a class="cmn-toggle-switch cmn-toggle-switch__htx open_close" href="javascript:void(0);"><span>Menu mobile</span></a> 
				<style type="text/css">
					.modal-backdrop {background: none;}
				</style>
				<a href="#0" data-toggle="modal" data-target="#myModal"  id="show_msg" class="hidden-lg hidden-md hidden-sm"></a>
				<div id="myModal" class="modal hidden-lg hidden-md hidden-sm">
					<div class="modal-dialog hidden-lg hidden-md hidden-sm">
						<div class="modal-content hidden-lg hidden-md hidden-sm">
							<div class="modal-body hidden-lg hidden-md hidden-sm" align="center">Cart Updated</div>
						</div> 
					</div>
				</div>
				<div class="main-menu">
					<div id="header_menu">
						<img height="23" data-retina="true" alt="" src="img/Zaikart_Text.png">
					</div>
                <a href="#" class="open_close" id="close_in"><i class="icon_close"></i></a>
                 <ul>
                    <li class="submenu"> <a href="index.php" class="show-submenu">Home</a></li>
						<?php
						
							if((isset($_SESSION['email_id']) && isset($_SESSION['mobile_number'])) && ($_SESSION['login_tag']!='google'  && $_SESSION['login_tag']!='facebook' ))
								{
									$email_id = $_SESSION['email_id'];
									$mobile_number = $_SESSION['mobile_number'];

									

									$where = " email_id = '$email_id' and  mobile_number = '$mobile_number' ";
									$results=$connection->get_data("customer_master","fname,lname,email_id,address1,address2,address3,mobile_number,active,password",$where,null);
									foreach($results as $usrinfo)
									{
										$fname	= $usrinfo['fname'];
										$lname		= $usrinfo['lname'];
										$address1 = $usrinfo['address1'];
										$address2 = $usrinfo['address2'];
										$address3 = $usrinfo['address3'];
									}
									echo '<li class="submenu">
											<a href="javascript:void(0);" class="show-submenu">My Account<i class="icon-down-open-mini"></i></a>
											<ul>
												<li><a href="myorder.php">My Orders</a></li>
												<li><a href="profile.php">Profile</a></li>
												<li><a href="change_password.php">Change Password</a></li>
												<li><a href="logout.php">Logout</a></li>
											</ul>
										</li>';
							}
							else 	if((isset($_SESSION['email_id']) && isset($_SESSION['login_tag'])))
								{
									if($_SESSION['login_tag']=='google'  || $_SESSION['login_tag']=='facebook' )
									{
										
										$fname	= '';
										$lname		= '';
										$address1 = '';
										$address2 = '';
										$address3 = '';
										$email_id = $_SESSION['email_id'];
										$login_tag=$_SESSION['login_tag'];
										$provider_email_id = $email_id;
										if($login_tag=='google')
											$where = " google_provider_email_id = '$provider_email_id'  ";
										else if($login_tag=='facebook')
											$where = " facebook_provider_email_id = '$provider_email_id'  ";
											$results=$connection->get_data("customer_master","fname,lname,email_id,address1,address2,address3,mobile_number,active,password",$where,null);
									
										
										foreach($results as $usrinfo)
										{
											$fname	= $usrinfo['fname'];
											$lname		= $usrinfo['lname'];
											$address1 = $usrinfo['address1'];
											$address2 = $usrinfo['address2'];
											$address3 = $usrinfo['address3'];
											$email_id = $usrinfo['email_id'];
											$mobile_number =$usrinfo['mobile_number'];
											$_SESSION['mobile_number'] = $mobile_number;
											
										}
										echo '<li class="submenu">
													<a href="javascript:void(0);" class="show-submenu">My Account<i class="icon-down-open-mini"></i></a>
													<ul>
														<li><a href="myorder.php">My Orders</a></li>
														<li><a href="profile.php">Profile</a></li>
														<li><a href="logout.php">Logout</a></li>
													</ul>
												</li>';
								}
						}
						else
							{
								if($hide_login == false)
								{
									if($login_link == true)
									echo '<li><a href="#0"  data-toggle="modal" data-target="#login_2b"  id="login_2c" >Login</a></li>';
										else
									echo '<li><a href="#0"  data-toggle="modal" data-target="#login_2"  id="login_2a" >Login</a></li>';
								}
							}
					?>
                    <li class="submenu"><a href="detail_page.php" class="show-submenu">Order Now</a></li>
					 <li class="submenu"><a href="contactus.php" class="show-submenu">Contact Us</a></li>
                </ul>
			</div>
			<?php 
					$myurl = strlen($_SERVER['QUERY_STRING']) ? basename($_SERVER['PHP_SELF'])."?".$_SERVER['QUERY_STRING'] : basename($_SERVER['PHP_SELF']);
					if($myurl == 'detail_page.php')
						echo '<a id="show_cart" style="float:right;" href="#cart_box">';
					else
						echo '<a id="show_cart"  style="float:right;" href="detail_page.php#cart_box">';

					$sid = session_id();
					$where = " ct_session_id = '$sid' ";
					$results=$connection->get_data("cart","count(*) as total_items",$where,null);
					foreach($results as $usrinfo)
					{
						$total_items = $usrinfo['total_items'];
					}
					echo '<img src="img/food_24.png" align="left" style="margin-left:-85px"> <b style="font-size: 13px;color:#000;margin-left:-60px">('.$total_items .')</b>';
					echo '</a>';
				?>
            </nav>
        </div>
    </div>
 </header>
 <?php 
		$current_order_number=0;
		if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']))
		{
			$Order_Number=$connection->getTenthOrderNumber($mobile_number);
			$current_order_number= $Order_Number[0]['orderid'];
		}
?>