<?php
	session_start();
	unset($_SESSION['order_inserted']);
	$delivery_day="";
	$extra_charge_amount="";
	$group_category_list_description="";
	$group_category_list_items_row_description="";
	$extra_charge="";
	$remaining_total="";
	if(isset($_SESSION['link']))
		unset($_SESSION['link']);

	$_SESSION['link'] ="detail_page.php";

	$add_more_items = true;
	 include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	 $db_connect = true;

	

	if(isset($_GET['delivery_address']) && $_GET['delivery_address'] !="")
	{
		$_SESSION['delivery_location'] = $_GET['delivery_address'];
	}
		/*	$address=$_SESSION['delivery_location'] ;
	$split_address = explode("~",$address);
	$pincode = $split_address[0];
	$area = $split_address[1];*/
	$show_cart_icon=true;
	$login_link = true;
?>
<!DOCTYPE html>
<!--[if IE 9]><html class="ie ie9"> <![endif]-->
<html>
<head>
	<noscript><meta http-equiv="refresh" content="01; URL=compatibility.html" target="_blank"/><h1>instructions how to enable JavaScript in your web browser</h1></noscript>
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"/> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
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
	
<link rel='stylesheet prefetch' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css'>

	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<!-- <link rel="stylesheet" href="css/new_font-awesome.min.css"> -->  

    <!-- BASE CSS -->
    <link href="css/base.css" rel="stylesheet">
    
    <!-- Radio and check inputs -->
    <link href="css/skins/square/grey.css" rel="stylesheet">

	<!-- <link rel="stylesheet" type="text/css" href="http://cdn.webrupee.com/font"> -->

    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->


<style>
div#spinner
{
    display: none;
    width:100px;
    height: 100px;
    position: fixed;
    top: 50%;
    left: 50%;
    text-align:center;
    margin-left: -50px;
    margin-top: -100px;
    z-index:2;
    overflow: auto;
}    
</style>


</head>

<body onload ="chkTenthorder();chk_mobile()">



<?php include 'analyticstracking.php'; ?>

 <div id="spinner"><img src="img/ajax-loader.gif"></div>

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

    <!-- Header ================================================== -->
	<?php 
		require 'menu.php';  
	    //<!-- End Header =============================================== -->
		$lines = $connection->get_menu_list();
	?>
<!-- Content ================================================== -->
<div class="container margin_60_35" style="margin-top:30px;">
	<div class="row" >
		<div class="col-md-9">
			<div class="box_style_2" id="main_menu" style="padding:05px;"> 
				<div class="scroller scroller-left"><i class="glyphicon glyphicon-chevron-left"></i></div>
				<div class="scroller scroller-right"><i class="glyphicon glyphicon-chevron-right"></i></div>
				<div class="wrapper">
					<ul class="nav nav-tabs list" id="myTab1">
						 <?php
								$i=0;
								foreach($lines as $key=> $values)
								{
									$group_code_split = explode("~",$values);
									$group_name =$group_code_split[0];
									$group_category_list =$group_code_split[1];
									$group_category_id = str_replace(" ","",$group_name);

									$active="";
									if($i==0)
										$active="class='active'";

									echo '<li '.$active.'><a href="#'.$group_category_id.'" data-toggle="tab">'.$group_name.'</a></li>';
									$i++;
								}
						?>
					</ul>
				</div>
			</div>

			<!-- Add New Row For Menu Items -->
			<div  class="row">
				<div class="col-md-12">
					<div class="box_style_2" id="main_menu" > 
						<h2 class="inner">Menu</h2> 
							<?php
								echo '<div class="tab-content" style="border:0px;padding:0px 10px 10px 10px;">';
									foreach($lines as $key=> $values)
									{
										$group_code_split = explode("~",$values);
										$group_name =$group_code_split[0];
										$group_category_list =$group_code_split[1];
										$group_name_id =$group_code_split[0];
										$group_name_id = str_replace(" ","",$group_name_id);
										echo  '<div id="'.$group_name_id.'"" class="tab-pane">';
										$group_category_split = explode("#",$group_name_id);
										$group_category_list_split = explode("^",$group_category_list);
										foreach($group_category_split as $key1=>$value1)
										{
											$group_category_id = str_replace(" ","",$group_name);
											echo '<h3 id="'.$group_category_id.'" style="color:#ec008c">'.$group_name.'</h3>';
											foreach($group_category_list_split as $key1a=>$value1a)
											{
												$group_category_list_splitA = explode("|",$value1a);
												$group_category_id = str_replace(" ","",$group_name);
												if(strlen($group_category_list_splitA[0])>0 && $group_category_list_splitA[0] !='-' )
													echo '<hr class="hr2"><h4>'.$group_category_list_splitA[0].'</h4>';
												echo '<table class="table table-striped" id="widthId">';
												echo '<thead><tr><th style="width:58%"></th><th></th><th></th><th> </th></tr></thead>';
												echo '<tbody>';
												$group_category_list_split2a =  explode("$",$group_category_list_splitA[1]);
												$i=1;
												foreach($group_category_list_split2a as $key2a=>$value2a)
												{
													$group_category_list_split2 =  explode("!",$value2a);
													$group_category_list_name = $group_category_list_split2[0];
													$group_category_list_description="";
													if(isset($group_category_list_split2[1]) && $group_category_list_split2[1]!="")
														$group_category_list_description = $group_category_list_split2[1];
													$group_category_list_image="";
													if(isset($group_category_list_split2[2]) && $group_category_list_split2[2]!="")
														$group_category_list_image = $group_category_list_split2[2];
													$group_category_list_item_status="";
													if(isset($group_category_list_split2[3]) && $group_category_list_split2[3]!="")
														$group_category_list_item_status = $group_category_list_split2[3];
													$group_category_list_items="";
													if(isset($group_category_list_split2[4]) && $group_category_list_split2[4]!="")
														$group_category_list_items= $group_category_list_split2[4];
													$group_category_list_items_split =   explode("#",$group_category_list_items);
													if(strpos($group_category_list_name," (") !== false)
														{
															$group_category_list_name=str_replace(" (","<br> (",$group_category_list_name);
														}
													if(strlen($group_category_list_name) <=0)
														continue;
													echo '<tr>';
														echo '<td>';
															echo '<p style="font-weight: bold; color:#111;font-size:14px;">'.$i.'.&nbsp;'. ucwords($group_category_list_name).'</p>';
															echo '<p id="hide">';
																echo ucfirst($group_category_list_description);
															echo '</p>';
														echo '</td>';
														$group_category_list_items_row_description_val='';
														$group_category_list_items_row_price_val='';
														$plus_val='';
														foreach($group_category_list_items_split as $key2=>$value2)
														{
															$group_category_list_items_row_split =   explode("@",$value2);
															$group_category_list_items_row_id  = $group_category_list_items_row_split[0];
															$group_category_list_items_row_description="";
															if(isset($group_category_list_items_row_split[1]) && $group_category_list_items_row_split[1] !="")
																$group_category_list_items_row_description  = $group_category_list_items_row_split[1];
															$group_category_list_items_row_price ="";
															if(isset($group_category_list_items_row_split[2]) && $group_category_list_items_row_split[2] !="")
																$group_category_list_items_row_price  = $group_category_list_items_row_split[2];
															$group_category_list_items_row_qty_in_hand="";
															if(isset( $group_category_list_items_row_split[3]) &&  $group_category_list_items_row_split[3] !="")
																$group_category_list_items_row_qty_in_hand = $group_category_list_items_row_split[3];
															$group_category_list_items_row_max_order_qty="";
															if(isset( $group_category_list_items_row_split[4]) &&  $group_category_list_items_row_split[4] !="")
																$group_category_list_items_row_max_order_qty  = $group_category_list_items_row_split[4];
															if(strlen($group_category_list_items_row_price) <=0)
																continue;
															$group_category_list_items_row_description_val1="";
															$group_category_list_items_row_description_val2="";
															if(strlen($group_category_list_items_row_description)<=0)
																$group_category_list_items_row_description='&nbsp;';
															else
															{
																if(strpos($group_category_list_items_row_description," (") !== false)
																	{
																		$group_category_list_items_row_description_val1 = substr($group_category_list_items_row_description, 0,strpos($group_category_list_items_row_description," ("));     
																		$group_category_list_items_row_description_val2 = substr($group_category_list_items_row_description, strpos($group_category_list_items_row_description," (")); $group_category_list_items_row_description = $group_category_list_items_row_description_val1;
																	}
																	else
																	{
																		$group_category_list_items_row_description = $group_category_list_items_row_description;
																	}
															}
															$group_category_list_items_row_description_val.='<p>'.$group_category_list_items_row_description;
															if(strlen($group_category_list_items_row_description_val2) > 0 )
															{
																$group_category_list_items_row_description_val.='<small id="hide">&nbsp;'.$group_category_list_items_row_description_val2.'</small>';
															}
															$group_category_list_items_row_description_val.='</p>';
															$group_category_list_items_row_price_val.='<p><b>'.$group_category_list_items_row_price.'</b></p>';
															if($group_category_list_item_status=='y')
																$plus_val.='<p><a style="cursor:pointer"  onClick="cart_detail('."'".$group_category_list_items_row_id."','add'".')"><i class="icon_plus_alt2"></i></a></p>';
															else
																$plus_val.='<p><b style="color:red"><small>No Stock</small></b></p>';
														}
														echo '<td>'.$group_category_list_items_row_description_val.'</td>';
														echo '<td>'.$group_category_list_items_row_price_val.'</td>';
														echo '<td class="options2">'.$plus_val.'</td>';
														$i++;
														echo '</tr>';
												}
												echo '</tbody></table>';
											}
										}
										echo '</div>';
									}
								echo '</div>';
							?>
					</div> <!-- End box_style_1 -->
				</div><!-- End col-md-6 -->	
			</div>
			<!-- End New Row For Menu Items -->
		</div>

		<div class="col-md-8" id="sidebar" style="padding:0px;">
				<div class="theiaStickySidebar">
					<div id="cart_box" >
						<h3>Your order <img src="img/food_24.png" style="float:right"></h3>
						<div id="frmCart_msg" style="display:none;"></div>
						<form action="cart_order.php" method="post" name="frm_Cart" id="frm_Cart">
							<div class="row">
									<div class="col-md-6 col-sm-6">
										<div class="form-group" style="margin-bottom:10px;">
											Delivery at
										</div>
									</div>
									<div class="col-md-6 col-sm-6">
										<div class="form-group">
											<select id="delivery_location" name="delivery_location" class="form-control " required="" title="Please select an area" style="height:33px;" onChange="copyTofrm_Modal(this.value);">
												<option selected="" value="">Select Area</option>
													<?php
														$result_addr=$connection->get_data("location_master","location,pincode",null,'location');
														foreach($result_addr as $result_address)
														{
															$selected="";
															if(isset($_SESSION['delivery_location']) && $_SESSION['delivery_location']== $result_address['pincode'].'~'.$result_address['location'])
																$selected="selected";
															echo '<option value="'.$result_address['pincode'].'~'.$result_address['location'].'"  '.$selected.'>'.$result_address['location'].'</option>';
														}
													?>
											</select>
										</div>
									</div>
								</div>
								<hr class="hr2">
								<div id="cart">
									<?php require 'cart.php' ?>
										</div>
							
						</form>
					</div><!-- End cart_box -->
                </div><!-- End theiaStickySidebar -->
			</div><!-- End col-md-3 -->
		</div>
		
		
            
			
            
		</div><!-- End row -->
</div><!-- End container -->
<!-- End Content =============================================== -->

<!-- Footer ================================================== -->
	<?php  require 'footer.php'; ?>
<!-- End Footer =============================================== -->

<div class="layer"></div><!-- Mobile menu overlay mask -->
    
<?php require 'detail_login.php'; ?>


    
<?php //require 'registration.php'; ?>

<!--10th order  modal popup-->   
	
	<a href="0" data-toggle="modal" data-target="#tenth_order"  id="tenth_order_2a"></a>

	<div class="modal fade" id="tenth_order" tabindex="-1" role="dialog" aria-labelledby="tenth_order" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				 <div class="modal-header" style="border-bottom: 0 solid #e5e5e5;">
					<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
			   		<h4 class="modal-title">This is your 10th order, your meal is on us.</h4>
				</div>
			</div>
		</div>
	</div><!-- End 10th order  modal popup -->


<!-- Restaurant Close  modal popup-->   



	<!-- Extra Amount  modal popup-->   
	
	<a href="#0" data-toggle="modal" data-target="#extra_amt"  id="extra_amt_2a"></a>

	<div class="modal fade" id="extra_amt" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_extra_charge_popup"><i class="icon_close_alt2"></i></a>
				<form action="cart_order.php" class="popup-form" id="my_extra_amt"  name="my_extra_amt" style="max-width:500px;" method="POST">
					<input type="hidden" name="delivery_location" id="frm_Modal_address" value="">
					<input type="hidden" name="extra_charge" id="extra_charge" value='y'>
					<input type="hidden" name="extra_charge_amount" id="extra_charge_amount" value='<?php echo $remaining_total ?>'>
                	<h4>The minimum order amount for Zaikart is Rs.  <?php echo $connection->get_order_settings('minuimum_order_amount'); ?> </h4>
					<h5><b><div id="order_total_amount_conf"></div></b></h5>
					<div class="row">
						<a href="#0" onClick="close_popup()" class="button_intro2">Choose more items</a>
						 <input type="button" name="frm_nodal_submit" id="frm_nodal_submit" class="button_intro2" value="" onClick="chk_login_session();return false;" >
					</div>
				</form>
			</div>
		</div>
	</div><!-- End Extra Amount  modal popup -->

<!--Rs. 500 Message popup-->   
	<a href="#0" data-toggle="modal" data-target="#500_MsgBox"  id="a_500_MsgBox"></a>
	<div class="modal fade" id="500_MsgBox" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true" >
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_extra_charge_popup"><i class="icon_close_alt2"></i></a>
					
						<h4 style="line-height:25px;">Get 25% off every Wednesday between 08:00 - 10:00 p.m.</h4>
						<h5 style="color:#FF0000;font-weight:bold">*Offer valid only on orders of Rs.500 and above.</h5>
						<h5 style="color:#FF0000;font-weight:bold">*Offer not valid for free meals.</h5>
						
					
			</div>
		</div>
	</div>
	
	<!-- Rs. 500 Message popup -->

	<!-- Check Session Popup-->   
	
	<a href="#0" data-toggle="modal" data-target="#chk_login_session"  id="chk_login" chk_login_session></a>

	<div class="modal fade" id="chk_login_session" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" id="close_login_session"><i class="icon_close_alt2"></i></a>
				<form action="cart_order.php" class="popup-form" id="login_guest"  name="login_guest" method="POST">
					<input type="hidden" name="form_id" id="form_id">

					<input type="hidden" name="delivery_location" id="frm_Modal_address" value="">
					<input type="hidden" name="extra_charge" id="extra_charge" value=''>
					<input type="hidden" name="extra_charge_amount" id="extra_charge_amount" value=''>

					<div class="row">
								<a onclick="open_login()" class="button_intro2">Login</a>
							<H4>OR</H4>
							   <a class="button_intro2"  onclick="guest_login();">Checkout as guest</a>
            		</div>
				</form>
				<p style="color:red;font-weight:bold">All the offers can only be availed by logging in.</p>
			</div>
		</div>
	</div>
	
	<!-- Check Session Popup ends here-->   


<!-- Restaurant Close  modal popup-->   
	
  
	
	<a href="0" data-toggle="modal" data-target="#extra_amt_3"  id="extra_amt_3a"></a>

	<div class="modal fade" id="extra_amt_3" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link"><i class="icon_close_alt2"></i></a>
				<form action="#" class="popup-form" id="frm_close_restaurant"  name="frm_close_restaurant"  method="GET">
					
					<input type="hidden" name="close_rest" id="close_rest" value="y">
					<input type="hidden" name="pdid" id="pdid" value="">
					<input type="hidden" name="action" id="action" value="y">
					<input type="hidden" name="add_more_items" id="add_more_items" value="">


                	<!-- <h4>Delivery Timings will be <br> 12:00 pm to 04:00 pm & 07:00 pm to 02:00 am</h4> -->
					<h4>Sorry! We only deliver between</h4><h4> 12:00 pm - 03:00 pm & 07:00 pm - 02:00 am</h4><h4>Please select a different time</h4>
					 <div class="row">
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label>Select Date</label>
													<select class="form-control " name="delivery_day" id="delivery_day"  onChange="get_timings()" required>
														<option value="" selected>Select Date</option>
														<option value="1~<?php echo date("d-m-Y") ?>"><?php echo date("d-m-Y") ?></option>
														<option value="2~<?php echo date('d-m-Y',strtotime($delivery_day . "+1 days")) ?>"><?php echo date('d-m-Y',strtotime($delivery_day . "+1 days")) ?></option>
														<option value="3~<?php echo date('d-m-Y',strtotime($delivery_day . "+2 days")) ?>"><?php echo date('d-m-Y',strtotime($delivery_day . "+2 days")) ?></option>
													</select>
												</div>
											</div>
											
											<div class="col-md-6 col-sm-6">
												<div class="form-group">
													<label>Delivery Time</label>
													<div id="my_delivery_time">
													<select class="form-control" id="delivery_time1" name="delivery_time" required>
														<option value="" selected>Select Time</option>
														
													</select>
													</div>
												</div>
											</div>
										</div>
					
					

					<div class="row">
						<input type="button" name="frm_day_submit" id="frm_day_submit" class="button_intro2" value="Continue" onClick="close_restaurant()">
				</div>

					
				</form>
			</div>
		</div>
	</div><!-- End Restaurant Close  modal popup -->
	
<!-- Restaurant Close Days modal  popup-->
	 <div class="modal-header" >
		<a href="#0" data-toggle="modal" data-target="#close_restaurant"  id="close_restaurant_link"></a>
	</div>
	<div class="modal fade" id="close_restaurant" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true" >
		<div class="modal-dialog"  data-keyboard="false" data-backdrop="static">
			<div class="modal-content modal-popup" style="background-color:#F9F9F9"  >
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<?php require 'alert.php'; ?> 

				
			</div>
		</div>
	</div><!-- Restaurant Close Days modal popup -->
	
   <!-- <a href="#0"  data-toggle="modal" data-target="#login_2"  id="login_2a" ></a>  -->
<!-- <div class="modal fade" id="login_2" tabindex="-1" role="dialog" aria-labelledby="addCharges" aria-hidden="true">
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
	</div> -->
	<a href="#0"  data-toggle="modal" data-target="#login_2b"  id="login_2c" ></a>
<div class="modal fade" id="login_2b" tabindex="-1" role="dialog" aria-labelledby="myLogin" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content modal-popup">
				<a href="#" class="close-link" onClick="login_2b_modal_close()"><i class="icon_close_alt2"></i></a>
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
	</div>

    
<?php require 'commonscripts.php' ?>

<?php
require 'mobile_check_popup.php';
$where ="status='y'";
$results=$connection->get_data("orders_stop_log","message_start_date,message_end_date",$where,null);
foreach($results as $usrinfo)
{
	$from = date($usrinfo['message_start_date']);
	$to = date($usrinfo['message_end_date']);
}

//$from = date('2016-08-01 06:00:00');
//$to = date('2016-08-02 06:00:00');
if(strtotime(date('Y-m-d H:i:s')) >= strtotime($from) && strtotime(date('Y-m-d H:i:s')) <= strtotime($to))
{
	
?>
<script>
	$("document").ready(function(){
		$( "#close_restaurant_link" ).trigger( "click" );
	});
</script>
<?php
}
?>

<script type="text/javascript">
    $('#extra_amt').on('hidden.bs.modal', function (e) {
  $(this)
    .find("text,textarea,select")
       .val('')
       .end()
    .find("input[type=checkbox], input[type=radio]")
       .prop("checked", "")
       .end();
		
		//alert("Hello");
	  
	})
</script>

<script type="text/javascript">

function login_2b_modal_close()
{
	$('#login_2b').on('hidden.bs.modal', function () {
    window.location.reload(true);
	});
}


</script>

<script type="text/javascript">
$('#extra_amt').on('shown.bs.modal', function (e) {    //alert("I want this to appear after the modal has opened!");
	
	document.getElementById('frm_nodal_submit').value ='Just charge me an extra  Rs. ' +document.getElementById('remaining_total').value ;

	document.getElementById('order_total_amount_conf').innerHTML ='The total of your selected items is  Rs. ' +document.getElementById('order_total_amount').value ;

	
	
});
</script>


<script type="text/javascript">
function close_popup()
{
		window.location.reload();
}
</script>
<script type="text/javascript">
function copyTofrm_Modal(address_val) 
{
	//alert(address_val);
	var spinnerVisible = false;
	var add_more_items = "<?php echo  $add_more_items ?>";
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
				 if (!spinnerVisible) 
				 {
					 $(document).ready(function () {
						$("div#spinner").fadeIn("fast");
					 });
					spinnerVisible = true;
				}
			}

		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var response =  xmlhttp.responseText;
			//alert(response);
			document.getElementById("cart").innerHTML = response;
			if (spinnerVisible) {
            var spinner = $("div#spinner");
            spinner.stop();
            spinner.fadeOut("fast");
            spinnerVisible = false;
        }
		
		}
	}
	xmlhttp.open("GET", "cart.php?delivery_address="+address_val+"&add_more_items="+add_more_items,true);
	xmlhttp.send();
}
</script>
<script type="text/javascript">
	function cart_detail(pdid,action)
	{
		var add_more_items = "<?php echo  $add_more_items ?>";
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
				
				if(response == 'error')
				{
					//alert("Here");
					document.getElementById("pdid").value = pdid;
					document.getElementById("action").value = action;
					document.getElementById("add_more_items").value = add_more_items;

					$("document").ready(function(){
						$( "#extra_amt_3a" ).trigger( "click" );
					});
				}
				else
				{
					document.getElementById("cart").innerHTML = response;
					total_cart_items();
				}
			}
		}
		xmlhttp.open("GET", "cart.php?pdid="+pdid+"&action="+action+"&add_more_items="+add_more_items,true);
		
		xmlhttp.send();
	}
</script>



<script type="text/javascript">
	function cart(pdid,action,row_id)
	{
		var add_more_items = "<?php echo  $add_more_items ?>";
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
				document.getElementById(row_id).style.display = "";
			}
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				document.getElementById(row_id).style.display = "none";
				var response =  xmlhttp.responseText;
				document.getElementById("cart").innerHTML = response;

				//alert(response);
				total_cart_items();
			}
		}
		xmlhttp.open("GET", "cart.php?pdid="+pdid+"&action="+action+"&add_more_items="+add_more_items,true);
		
		xmlhttp.send();
	}
</script>

<script type="text/javascript">
	function total_cart_items()
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
				$("document").ready(function(){
						$( "#show_msg" ).trigger( "click" );

						setTimeout(function()
							{
								
								$( "#show_msg" ).trigger( "click" )
							}, 1000);

					});
					
				
				document.getElementById("show_cart").innerHTML = response;
			}
		}
		xmlhttp.open("GET", "cart_items.php",true);
		xmlhttp.send();
	}
</script>


<script type="text/javascript">

	$(document).ready(function () {
	$("#frm_Cart").validate({
	invalidHandler: function(event, validator) 
	{
		// 'this' refers to the form
		var errors = validator.numberOfInvalids();
		if (errors) 
		{
			alert("Please select an area");   
			$('html, body').animate({ scrollTop: $('#cart_box').offset().top }, 'slow');
		} 
	}
});


	var spinnerVisible = false;
	var options = { 
        target:        '#frmCart_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_Cart').ajaxForm(options); 
	// pre-submit callback 
	function showRequest(formData, jqForm, options) 
		{ 
			 if (!spinnerVisible) 
			 {
            $("div#spinner").fadeIn("fast");
            spinnerVisible = true;
			}
			var queryString = $.param(formData); 
			return true; 
		} 
	// post-submit callback 
	function showResponse(responseText, statusText, xhr, $form)  
	{ 
	
		response = responseText;
		//alert(response);
		if (spinnerVisible) {
            var spinner = $("div#spinner");
            spinner.stop();
            spinner.fadeOut("fast");
            spinnerVisible = false;
        }

		if(response == 'error')
		{
			document.getElementById("extra_charge_amount").value =	document.getElementById("remaining_total").value;
				$( "#extra_amt_2a" ).trigger( "click" );
		}
		else
		{
			
			var email_id = "<?php echo $_SESSION['email_id'] ?>";
			var mobile_number = "<?php echo $_SESSION['mobile_number'] ?>";
			var login_tag = "<?php echo $_SESSION['login_tag'] ?>";
			var login_verified = "<?php echo $_SESSION['login_verified'] ?>";

			if(email_id.length <=0 ||  mobile_number.length <=0 ||  login_tag.length <=0 ||  login_verified.length <=0)
			{
				document.getElementById("form_id").value="frm_Cart";
				$( "#chk_login" ).trigger( "click" );
			}
			else
			{
				window.name="";
				document.getElementById("frm_Cart").submit();
			}
		}
	}	 
});
</script>

<!-- Check Login Session-->
<script type="text/javascript">
function chk_login_session()
{
	
	var email_id = "<?php echo $_SESSION['email_id'] ?>";
		var mobile_number = "<?php echo $_SESSION['mobile_number'] ?>";
		var login_tag = "<?php echo $_SESSION['login_tag'] ?>";
		var login_verified = "<?php echo $_SESSION['login_verified'] ?>";

		if(email_id.length <=0 ||  mobile_number.length <=0 ||  login_tag.length <= 0 ||  login_verified.length <= 0)
		{
			document.getElementById("form_id").value="my_extra_amt";

			document.getElementById("login_guest").elements.namedItem("delivery_location").value = document.getElementById("my_extra_amt").elements.namedItem("delivery_location").value;



			document.getElementById("login_guest").elements.namedItem("extra_charge").value = document.getElementById("my_extra_amt").elements.namedItem("extra_charge").value;

			document.getElementById("login_guest").elements.namedItem("extra_charge_amount").value = document.getElementById("my_extra_amt").elements.namedItem("extra_charge_amount").value;

			

			

			$('#extra_amt').modal('hide');
			$( "#chk_login" ).trigger( "click" );
		}
		else
		{
			window.name="";
			document.getElementById("my_extra_amt").submit();
		}
}
</script>

<script type="text/javascript">
function open_login()
{
	$('#chk_login_session').modal('hide');
	$( "#login_2c" ).trigger( "click" );
 }
</script>


<script type="text/javascript">
function guest_login()
{
	var  form_id	=document.getElementById("form_id").value;
	if(form_id == 'frm_Cart')
		document.getElementById(form_id).submit();
	else if(form_id == 'my_extra_amt')
		document.getElementById("login_guest").submit();
	


}
</script>
<!-- Check Login Session ends here-->


<script type="text/javascript">
	function close_restaurant()
	{
			$(document).ready(function () {
			$('#frm_close_restaurant').validate({}); // For Validation should be there
		});
		try
		{
			
			
		var add_more_items = "<?php echo  $add_more_items ?>";
		var pdid = document.getElementById("frm_close_restaurant").elements.namedItem("pdid").value;;
		var action =document.getElementById("frm_close_restaurant").elements.namedItem("action").value;;

		var day = document.getElementById("frm_close_restaurant").elements.namedItem("delivery_day").value;;
		var time = document.getElementById("frm_close_restaurant").elements.namedItem("delivery_time1").value;;

		if(day =="" || time =="")
			return false;

		

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
				
				document.getElementById("cart").innerHTML = response;
				total_cart_items();
				$("document").ready(function(){
					$( ".close-link" ).trigger( "click" );
				});
			}
		}
		xmlhttp.open("GET", "cart.php?pdid="+pdid+"&action="+action+"&add_more_items="+add_more_items+"&day="+day+"&time="+time+"&later_order=y",true);
		
		xmlhttp.send();
		}
		catch (ex)
		{
			alert(ex);
		}
		
	}
</script>




<script type="text/javascript">
	function get_timings()
	{
		var my_delivery_date = document.getElementById("delivery_day").value;
		
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
				//alert( xmlhttp.responseText);
				document.getElementById("my_delivery_time").innerHTML= xmlhttp.responseText;
			}
		}
		xmlhttp.open("GET", "get_delivery_time.php?my_delivery_date="+my_delivery_date,true);
		
		xmlhttp.send();
	}
</script>


<script type="text/javascript">
$('#login_2b').on('shown.bs.modal', function (e) {    //alert("I want this to appear after the modal has opened!");
	document.getElementById("login_msg").innerHTML ="";
	$('#cust_login').focus();
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
		//alert(response);
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


<script>
	function close_login()
	{
		
		$("document").ready(function()
		{
			try
			{
				//$( "#close_login_popup" ).trigger( "click" );
				$( ".close-link" ).trigger( "click" );
			}
			catch (ex)
			{
				//alert(ex);
			}

			try
			{
				$( "#triggerForgot_2" ).trigger( "click" );	
			}
			catch (ex)
			{
				//alert(ex);
			}
			
		});
	}
	</script>

<script type="text/javascript">

	$(document).ready(function () {
	$('#myForgot').validate({}); // For Validation should be there

	var options = { 
        target:        '#forgot_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#myForgot').ajaxForm(options); 
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
		alert(response);
		window.location.reload();
	}	 
});
</script>


<script type="text/javascript">
	function chkTenthorder()
	{
		
		var xmlhttp;
		if (window.XMLHttpRequest)
		{
			xmlhttp=new XMLHttpRequest();
		}
		else
		{
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var response =  xmlhttp.responseText;
				
				if(response == 'success')
				{
					
					$("document").ready(function(){
						$( "#tenth_order_2a" ).trigger( "click" );
					});
				}
			}
		}
		xmlhttp.open("GET", "chk_freeorder.php",true);
		//xmlhttp.open("GET", "cart.php?add_more_items="+add_more_items,true);
		xmlhttp.send();
	}
</script>

<script type="text/javascript">
function touchStart(event) {
   if (event.target.tagName != 'SELECT') {
      event.preventDefault();
   }
}
</script>
<?php
$dayOfWeek=date('l');
$order_from_time = date('00:01:00');
$order_to_time = date('22:00:00');
if($dayOfWeek == 'Wednesday' && strtotime(date('H:i:s')) >= strtotime($order_from_time) && strtotime(date('H:i:s')) <= strtotime($order_to_time))
{
	if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']) && $current_order_number > 0)
	{
		if(($current_order_number % ($connection->get_order_settings('offer_free_meal_order'))) !=0)
		{
			echo '<script type="text/javascript">$(window).load(function(){$( "#a_500_MsgBox" ).trigger( "click" );});</script>';
		}
	}
	else
	{
		echo '<script type="text/javascript">$(window).load(function(){$( "#a_500_MsgBox" ).trigger( "click" );});</script>';
	}
}

?>

<style type="text/css">
	.wrapper {
    position:relative;
    margin:0 auto;
    overflow:hidden;
	padding:5px;
  	height:35px;
}

.list {
    position:absolute;
    left:0px;
    top:0px;
  	min-width:3000px;
  	margin-left:06px;
    margin-top:0px;
}

.list li{
	display:table-cell;
    position:relative;
    text-align:center;
    cursor:grab;
    cursor:-webkit-grab;
    color:#efefef;
    vertical-align:middle;
}

.scroller {
  text-align:center;
  cursor:pointer;
  display:none;
  padding:7px;
  padding-top:11px;
  white-space:no-wrap;
  vertical-align:middle;
  background-color:#fff;
}

.scroller-right{
  float:right;
}

.scroller-left {
  float:left;
}
</style>

<script type="text/javascript">
var hidWidth;
var scrollBarWidths = 10;

var widthOfList = function(){
  var itemsWidth = 0;
  $('.list li').each(function(){
    var itemWidth = $(this).outerWidth();
    itemsWidth+=itemWidth;
  });
  return itemsWidth;
};

var widthOfHidden = function(){
  return (($('.wrapper').outerWidth())-widthOfList()-getLeftPosi())-scrollBarWidths;
};

var getLeftPosi = function(){
  return $('.list').position().left;
};

var reAdjust = function(){
  if (($('.wrapper').outerWidth()) < widthOfList()) {
    $('.scroller-right').show();
  }
  else {
    $('.scroller-right').hide();
  }
  
  if (getLeftPosi()<0) {
    $('.scroller-left').show();
  }
  else {
    $('.item').animate({left:"-="+getLeftPosi()+"px"},'slow');
  	$('.scroller-left').hide();
  }
}

reAdjust();

$(window).on('resize',function(e){  
  	reAdjust();
});

$('.scroller-right').click(function() {
  
  $('.scroller-left').fadeIn('slow');
 // $('.scroller-right').fadeOut('slow');
  
  /*$('.list').animate({left:"+="+widthOfHidden()+"px"},'slow',function(){

  });*/

 // alert(widthOfHidden());

 $('.list').animate({left:"+="+"-100px"},'slow',function(){

  });

  if(widthOfHidden() > -100)
	   $('.scroller-right').fadeOut('slow');

});

$('.scroller-left').click(function() {
  
	$('.scroller-right').fadeIn('slow');
	//$('.scroller-left').fadeOut('slow');
  
  /*	$('.list').animate({left:"-="+getLeftPosi()+"px"},'slow',function(){
  	
  	});*/
	
	  $('.list').animate({left:"-="+"-100px"},'slow',function(){
  	
  	});

	//alert(getLeftPosi());

	if(getLeftPosi()>=-100)
		$('.scroller-left').fadeOut('slow');

});
</script>

<!-- COMMON SCRIPTS -->
<script src="js/jquery-1.11.2.min.js"></script>
<script src="js/common_scripts_min.js"></script>
<script src="js/functions.js"></script>
<script src="assets/validate.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		$('.list a:first').tab('show');
		});    
</script>
</body>
</html>