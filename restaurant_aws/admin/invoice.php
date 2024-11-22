<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object

	if(trim($_GET['order_id']=="") || trim($_GET['name']==""))
		header("Location:orders.php");
	
	$order_id =  $_GET['order_id'];
	$name = urldecode($_GET['name']);
	$OpOrder_detail=$connection->getOpOrder_detail($order_id);
	

	//$name = ucwords($OpOrder_detail[0]["ofname"].' '.$OpOrder_detail[0]["olname"]);

	$numItem     = count($OpOrder_detail);
	//print_r($OpOrder_detail);

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>ZAIKART</title>
		<!-- Description, Keywords and Author -->
		<meta name="description" content="Your description">
		<meta name="keywords" content="Your,Keywords">
		<meta name="author" content="ResponsiveWebInc">
		
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<!-- Styles -->
		<!-- Bootstrap CSS -->
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!-- jQuery UI -->
		<link rel="stylesheet" href="css/jquery-ui.css"> 
		<!-- jQuery Gritter -->
		<link rel="stylesheet" href="css/jquery.gritter.css">
		<!-- Font awesome CSS -->
		<link href="css/font-awesome.min.css" rel="stylesheet">		
		<!-- Custom CSS -->
		<link href="css/style.css" rel="stylesheet">
		<!-- Widgets stylesheet -->
		<link href="css/widgets.css" rel="stylesheet">   
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">
	</head>
	
	<body>

		<?php require 'header.php'; ?>

		<!-- Main content starts -->
		<div class="content">



			
			<?php require 'sidebar.php'; ?>





			<!-- Main bar -->
			<div class="mainbar">
			  
				<!-- Page heading -->
 <!-- <h2 class="pull-left">Invoice <span class="page-meta">Read Information</span>	</h2>  -->
				<div class="page-head">
					 
					  <?php
							if($OpOrder_detail[0]['order_status'] == 'ORPS')
							{
								echo '<span class="page-meta"><a class="btn btn-success" href="#acceptModal"  data-toggle="modal">Accept Order</a>';
								echo '&nbsp;&nbsp;&nbsp;<a class="btn btn-danger"  href="#rejectModal"  data-toggle="modal">Reject Order</a></span>';
							}
							else if($OpOrder_detail[0]['order_status'] == 'ORPSA')
							{
								echo '<h2 class="pull-left">Order Accepted</h2>';
								echo '<h2 class="pull-right"><span class="page-meta"><a class="btn btn-success"  onClick="order_completed()">Order Completed</a></h2></span>';
								
							}
							else if($OpOrder_detail[0]['order_status'] == 'ORPSR')
							{
								echo '<h2 class="pull-left">Order Rejected<span class="page-meta"><p>'.$OpOrder_detail[0]['order_cancel'].'</p></span></h2>';
									
								if($_SESSION['user_type'] == 'admin')
								{
									//echo '<h2 class="pull-right"><span class="page-meta"><a class="btn btn-success"  onClick="order_reject_accept()">Reaccept Order </a></h2></span>';
									echo '<h2 class="pull-right"><span class="page-meta"><a class="btn btn-success" href="#ReacceptModal"  data-toggle="modal">Reaccept Order</a></h2></span>';
									echo '<br><h2 class="pull-left" id="reject_to_accept_order_msg"></h2>';
								}

							}
					  ?>
					  <div class="clearfix"></div>
				</div> 

				<!-- Page heading ends -->



			

			

	<!-- Matter -->


			<div class="matter">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="widget wred">
								<div class="widget-head">

									  <div class="pull-left">Order Details for <?php echo $order_id ?></div>
											<div class="widget-icons pull-right">
												<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
												<a href="#" class="wclose"><i class="fa fa-times"></i></a>
											</div>
											<div class="clearfix"></div>
									</div>

									<div class="widget-content">
										 <div class="padd invoice">
											<div class="row">
												  <div class="col-md-4">
													<div class="well bviolet">
														<h4>Delivery Details</h4>
														<p>
														  <!-- 19/133, New New York Street<br>
														  Near Bus Stop, Right side <br>
														  Mexico, NY - 63442<br>
														  USA -->
														  <?php
														  echo 'Name: '.'<b>'.$name.'</b><br>';
																echo $OpOrder_detail[0]['delivery_address1'].', '.$OpOrder_detail[0]['delivery_address2'].', '.$OpOrder_detail[0]['delivery_address3'].' - Pincode : '.'<b>'.$OpOrder_detail[0]['pincode'];
																//echo  '<br>'.$OpOrder_detail[0]['delivery_address2'];
																//echo '<br>'.$OpOrder_detail[0]['delivery_address3'];
																echo '<br> Delivery Area: '.'<b>'.$OpOrder_detail[0]['area'].'</b>'; 
														 ?> 
														</p>
														<h4>Contact Details</h4>
														<p>
														  <!-- 24/133, Mexico Street<br>
														  Near Airport, Right side <br>
														  Mexico, CA - 53432<br>
														  Mexico -->
														  <?php echo 'Mobile No: '.'<b>'.$OpOrder_detail[0]['mobileno'].'</b>'.'<br>Email: '.'<b>'.$OpOrder_detail[0]['email_id'].'</b>'; ?>
														</p>                 
												</div>
											</div>

												  <div class="col-md-4">
													<div class="well blightblue">
														<h4>Invoice Details</h4>
														<p>
														 <?php 
															if($OpOrder_detail[0]['payment_type'] == 'cod')
																  $payment_type='Cash On Delivery';
																else if($OpOrder_detail[0]['payment_type'] == 'online')
																	$payment_type='Online';
																else
																	$payment_type=$OpOrder_detail[0]['payment_type'];


																if($OpOrder_detail[0]['free_meal'] == 'y')
																		$free_meal = 'Free Meal';
																	else
																		$free_meal="";
																			
																echo  'Payment Type: '.'<b>'.ucwords($payment_type).'</b>';
														 		echo '<br>Total Amount: '.'<b>&nbsp;<i class="fa fa-inr"></i> '.$OpOrder_detail[0]['order_amt_payable'].'</b>';
																

																/*if($OpOrder_detail[0]['payment_type'] == 'online' && $OpOrder_detail[0]['paytm_status']=='TXN_SUCCESS')
																{
																		if(strlen($OpOrder_detail[0]['paytm_banktxnid']) > 0)
																			echo '<br>Bank Transaction ID : '.'<b>'.$OpOrder_detail[0]['paytm_banktxnid'].'</b>';

																		//if(strlen($OpOrder_detail[0]['paytm_gatewayname']) > 0)
																			if(strlen($OpOrder_detail[0]['paytm_bankname']) > 0)
																				echo '<br>Bank : '.'<b>'.$OpOrder_detail[0]['paytm_bankname'].'</b>';

																		if(strlen($OpOrder_detail[0]['paytm_paymentmode']) > 0)
																		{
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='NB')		
																				echo '<br>Payment Mode : '.'<b>Net Banking</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='CC')		
																				echo '<br>Payment Mode : '.'<b>Credit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='DC')		
																				echo '<br>Payment Mode : '.'<b>Debit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='PPI')		
																				echo '<br>Payment Mode : '.'<b>Paytm Wallet</b>';
																		}

																		if(strlen($OpOrder_detail[0]['paytm_txndate']) > 0)
																			echo '<br>Transaction Date : '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['paytm_txndate'])).'</b>';



																}*/

																if($OpOrder_detail[0]['payment_type'] == 'online' )

																{
																	if($OpOrder_detail[0]['paytm_status']=='TXN_SUCCESS')
																	{
																		if(strlen($OpOrder_detail[0]['paytm_banktxnid']) > 0)
																			echo '<br>Bank Transaction ID : '.'<b>'.$OpOrder_detail[0]['paytm_banktxnid'].'</b>';

																		//if(strlen($OpOrder_detail[0]['paytm_gatewayname']) > 0)
																			if(strlen($OpOrder_detail[0]['paytm_bankname']) > 0)
																				echo '<br>Bank : '.'<b>'.$OpOrder_detail[0]['paytm_bankname'].'</b>';

																		if(strlen($OpOrder_detail[0]['paytm_paymentmode']) > 0)
																		{
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='NB')		
																				echo '<br>Payment Mode : '.'<b>Net Banking</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='CC')		
																				echo '<br>Payment Mode : '.'<b>Credit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='DC')		
																				echo '<br>Payment Mode : '.'<b>Debit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='PPI')		
																				echo '<br>Payment Mode : '.'<b>Paytm Wallet</b>';
																		}

																		if(strlen($OpOrder_detail[0]['paytm_txndate']) > 0)
																			echo '<br>Transaction Date : '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['paytm_txndate'])).'</b>';



																}
																else
																	{

																			
																			echo '<br><b>Payment Status : '.$OpOrder_detail[0]['paytm_status'];
																			echo '&nbsp;&nbsp;[ '.$OpOrder_detail[0]['paytm_respmsg'].' ]</b>';

																		if(strlen($OpOrder_detail[0]['paytm_banktxnid']) > 0)
																			echo '<br>Bank Transaction ID : '.'<b>'.$OpOrder_detail[0]['paytm_banktxnid'].'</b>';

																		//if(strlen($OpOrder_detail[0]['paytm_gatewayname']) > 0)
																			if(strlen($OpOrder_detail[0]['paytm_bankname']) > 0)
																				echo '<br>Bank : '.'<b>'.$OpOrder_detail[0]['paytm_bankname'].'</b>';

																		if(strlen($OpOrder_detail[0]['paytm_paymentmode']) > 0)
																		{
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='NB')		
																				echo '<br>Payment Mode : '.'<b>Net Banking</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='CC')		
																				echo '<br>Payment Mode : '.'<b>Credit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='DC')		
																				echo '<br>Payment Mode : '.'<b>Debit Card</b>';
																			if($OpOrder_detail[0]['paytm_paymentmode'] =='PPI')		
																				echo '<br>Payment Mode : '.'<b>Paytm Wallet</b>';
																		}

																	}
															}

														?>
													  <!-- Invoice No : 52322<br>
													  Date : 12/34/2012<br>
													  Account No : 4290293203 -->
													</p>              
												  </div>
												</div>

											  <div class="col-md-4">
												<div class="well bgreen">
													<h4>Dates</h4>
													<p>
														 <?php 

															//echo 'Order Placed: '.'<b>'.date('D jS \of F Y h:i A',strtotime($OpOrder_detail[0]['order_verify_date'])).'</b>'; 
															$order_entry_date = $OpOrder_detail[0]['order_entry_date'];
															$order_verify_date=$OpOrder_detail[0]['order_verify_date'];
															if(strlen($order_verify_date) <=0 || $order_verify_date  == null)
																$order_verify_date=$order_entry_date;

															echo 'Order Placed: '.'<b>'.date('d-m-Y h:i A',strtotime($order_verify_date)).'</b>'; 
															
															echo '<br>Delivery Requested: '.'<b>'.$OpOrder_detail[0]['delivery_day'].' '.$OpOrder_detail[0]['delivery_time'].'</b>'; 
															
															if($OpOrder_detail[0]['order_status'] == 'ORP')
																{
																echo '<br>Order Status: <b>Payment type not Selected</b>'; 
																}

																else if($OpOrder_detail[0]['order_status'] == 'ORPOTP')
																{
																echo "<br>Order Status: <b>OTP Verification Pending</b>"; 
																}

																else if($OpOrder_detail[0]['order_status'] == 'ORPOPG')
																{
																echo "<br>Order Status: <b>Online Payment Pending / Cancel</b>"; 
																}

															if($OpOrder_detail[0]['order_status'] == 'ORPSR')
															{
																//echo '<br>Order Reject: '.'<b>'.date('D jS \of F Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 

																echo '<br>Order Reject: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 
															}

															else if($OpOrder_detail[0]['order_status'] == 'ORPSA')
															{
																if($OpOrder_detail[0]['reject_to_accept'] == 'y')
																{
																		echo '<br>Order Rejected: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 
																		echo '<br>Order Reaccepted: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['reject_to_accept_date'])).'</b>'; 
																}
																else
																	echo '<br>Order Accepted: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 

																echo '<br>Delivery Scheduled: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_delivery_date'])).'</b>'; 
															}

															else if($OpOrder_detail[0]['order_status'] == 'ORPSC')
															{
																if($OpOrder_detail[0]['reject_to_accept'] == 'y')
																{
																	echo '<br>Order Rejected: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 
																	echo '<br>Order Reaccepted: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['reject_to_accept_date'])).'</b>'; 
																}
																else
																	echo '<br>Order Accepted: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_accept_reject_date'])).'</b>'; 

																echo '<br>Delivery Scheduled: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_delivery_date'])).'</b>'; 

																echo '<br>Order Completed: '.'<b>'.date('d-m-Y h:i A',strtotime($OpOrder_detail[0]['order_complete_date'])).'</b>'; 
															}

					
														?>
													  <!-- Invoice No : 52322<br>
													  Date : 12/34/2012<br>
													  Account No : 4290293203 -->
													</p>
											  </div>
											</div>

									</div><!-- Row Ends Here -->
								<br />

								<div class="row">

									<div class="col-md-4">
										<div class="well blightblue">
											<h4>Comments</h4>
												<p>	<?php  echo $OpOrder_detail[0]['comments'] ;	?></p>															
										</div>
									</div>

										 <div class="col-md-4">
												<h4 style="color:red"><b><?php  echo $free_meal ?></b></h4>
										</div>

									
								

								</div>
									<?php
											if($OpOrder_detail[0]['bring_change_for'] != '' && $OpOrder_detail[0]['bring_change_for'] != '0')
											{
										?>
									<br>				
										<div class="row">
											<div class="widget-head">
												<div class="pull-left">Bring Change For : <i class="fa fa-inr"></i> <?php  echo $OpOrder_detail[0]['bring_change_for'] ;	?></div>
												<div class="clearfix"></div>
												</div>
										</div>
										<?php
											}
											?>
								<br>

								<div class="row">

								  <div class="col-md-12">
									<div class="table-responsive">
										<table class="table table-bordered">
										  <thead>
											<tr>
											  <th>#</th>
											  <th>Item Name</th>
											  <th>Quantity</th>
											  <th>Unit Price</th>
											  <th>Amount</th>
											</tr>
										  </thead>
										  <tbody>
										  <?php
										  for ($i = 0; $i < $numItem; $i++) 
										  {
											echo '<tr>';
											  echo '<td>'.($i+1).'</td>';
											  echo '<td>';
												  echo $OpOrder_detail[$i]['item_name'];
												  if(strlen(trim($OpOrder_detail[$i]['detail_description'])) > 0)
													{
														
														echo '[ <b>'.$OpOrder_detail[$i]['detail_description'].'</b> ]';
													}
												echo  '</td>';
											
											   echo '<td>'.$OpOrder_detail[$i]['Qty'].'</td>';
											  echo '<td> <i class="fa fa-inr"></i>  '.$OpOrder_detail[$i]['SaleRate'].'</td>';
											  echo '<td align="right"> <i class="fa fa-inr"></i>  '.$OpOrder_detail[$i]['Qty'] *$OpOrder_detail[$i]['SaleRate'] .'</td>';
											echo '</tr>';     
										  }
										  echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total</td><td  align="right"><i class="fa fa-inr"></i> '.'<b>'.$OpOrder_detail[0]['order_amt'].'</b>'.'</td></tr>';
										  echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Discount ('.$OpOrder_detail[0]['discount_percent'].'%)</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.$OpOrder_detail[0]['order_discount'].'</b>'.'</td></tr>';

											if($OpOrder_detail[0]['extra_charges'] > 0)
													echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><i class="fa fa-inr"></i> '.$connection->get_order_settings('minuimum_order_amount').' Minimum, Remaining Charges</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.$OpOrder_detail[0]['extra_charges'].'</b>'.'</td></tr>';
										
										$free_credit_remain=$OpOrder_detail[0]['free_credit_remain'];
										$free_meal_discount=($connection->get_order_settings('free_meal_credit_amount'))-$free_credit_remain;
										 if($OpOrder_detail[0]['free_meal'] =='y')
										 {
												echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Free Meal Discount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.$free_meal_discount.'</b>'.'</td></tr>';
										 }


										 if($OpOrder_detail[0]['delivery_charges']  > 0)
										 {
												$delivery_charges=$OpOrder_detail[0]['delivery_charges'];
												echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Amount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.($OpOrder_detail[0]['order_amt_payable'] - $delivery_charges).'</b>'.'</td></tr>';

												echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Delivery Charges</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.($delivery_charges).'</b>'.'</td></tr>';

												  echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Grand Total Amount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.$OpOrder_detail[0]['order_amt_payable'].'</b>'.'</td></tr>';
										 }
										 else
										 {

										  echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Total Amount</td><td align="right"><i class="fa fa-inr"></i> '.'<b>'.$OpOrder_detail[0]['order_amt_payable'].'</b>'.'</td></tr>';
										 }
									   ?>
									   
									    <!-- <tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td><a class="btn btn-success" href="#acceptModal"  data-toggle="modal">Accept Order</a></td><td align="right"><a class="btn btn-danger"  href="#rejectModal"  data-toggle="modal">Reject Order</a></td></tr> -->
											
										  </tbody>
										</table>
									</div>
								  </div>
								</div><!-- Row Ends Here -->


							  </div>
							</div>

							<!-- Accept Modal -->
							<div id="acceptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Accept Order For <?php echo $order_id  ?></h4>
								  </div>
								  <?php
									if($OpOrder_detail[0]['payment_type'] == 'cod')
										echo '<form action="accept_order_cod.php" method="POST" id="frm_accept_order" name="frm_accept_order">';
									else
										echo '<form action="accept_order.php" method="POST" id="frm_accept_order" name="frm_accept_order">';
								?>
										  <!-- <div class="modal-header" style="border:0px;"><h5 class="modal-title">Expected Delivery Date and Time</h5></div> -->

										   <!-- <div class="row">
												 <div class="col-md-9"> -->
													<div class="modal-header" style="border:0px;"><div class="well bgreen"><h5 class="modal-title">Delivery Requested: <?php echo $OpOrder_detail[0]['delivery_day'].' '.$OpOrder_detail[0]['delivery_time'];  ?></h5></div></div>
												<!-- </div>
											</div> -->

										  <div class="modal-header" style="border:0px;"><h5 class="modal-title">Expected Delivery Time</h5></div>
								<input type="hidden" name="order_id" value="<?php echo $order_id  ?>">
								<input type="hidden" name="email_id" value="<?php echo $OpOrder_detail[0]['email_id']  ?>">
								<input type="hidden" name="mobile_no" value="<?php echo $OpOrder_detail[0]['mobileno']  ?>">
								<input type="hidden" name="delivery_day" value="<?php echo $OpOrder_detail[0]['delivery_day'];  ?>">
								<input type="hidden" name="delivery_time" value="<?php echo $OpOrder_detail[0]['delivery_time'];  ?>">
								<input type="hidden" name="payment_type" value="<?php echo $OpOrder_detail[0]['payment_type'];  ?>">
								<input type="hidden" name="ofname" value="<?php echo $OpOrder_detail[0]['ofname'];  ?>">
								<input type="hidden" name="olname" value="<?php echo $OpOrder_detail[0]['olname'];  ?>">

								<input type="hidden" name="delivery_address1" value="<?php echo $OpOrder_detail[0]['delivery_address1'];  ?>">
								<input type="hidden" name="delivery_address2" value="<?php echo $OpOrder_detail[0]['delivery_address2'];  ?>">
								<input type="hidden" name="delivery_address3" value="<?php echo $OpOrder_detail[0]['delivery_address3'];  ?>">

								<input type="hidden" name="pincode" value="<?php echo $OpOrder_detail[0]['pincode'];  ?>">

								<input type="hidden" name="delivery_address" value="<?php echo $OpOrder_detail[0]['delivery_time'];  ?>">

								  <div class="modal-body">
									

									<div class="row">
											<!-- <div class="col-md-6 col-sm-6">
												<div class="form-group"> -->
													<?php
														/*$request_delivery_day=$OpOrder_detail[0]['delivery_day'];
														$tommorow_delivery_day = date('d-m-Y',strtotime($request_delivery_day . "+1 days"));
														echo '<select class="form-control" id="order_date" name="order_date" required="" title="Please select order delivery date" onChange="get_timings()">';
															echo '<option value="" selected>Select delivery date</option>';
															echo '<option value="'.'1~'.$request_delivery_day.'">'.$request_delivery_day.'</option>';
															echo '<option value="'.'2~'.$tommorow_delivery_day.'">'.$tommorow_delivery_day.'</option>';
														echo '</select>';*/
													?>

												

												<!-- </div>
											</div> -->
											<div class="col-md-5 col-sm-3">
												<div class="form-group">
													<div id="my_delivery_time">
														<select class="form-control" id="order_time" name="order_time" required="" title="Please select order delivery time"								onChange="get_delivery_timings()">
															<option value="" selected>Select delivery time</option>
															<option value="00">0 min</option>
															<option value="15">15 mins</option>
															<option value="30">30 mins</option>
															<option value="45">45 mins</option>
															<option value="60">1 hr</option>
															<option value="75">1.15 hrs</option>
															<option value="90">1.3 hrs</option>
															<option value="105">1.45 hrs</option>
															<option value="120">2 hrs</option>
														</select>
													</div>
												</div>
											</div>


											<!-- <div class="col-md-8 col-sm-9">
												<div class="form-group">
													<div style="border:0px;display:none" id="modal_expect_delivery_time"><div class="well bred" style="padding:4px 15px"><h5 class="modal-title"  id="expect_delivery_time"></h5></div></div>				
												</div>
											</div> -->

										</div>
									<div id="accept_order_msg"></div>

									<div class="form-group">
													<div style="border:0px;display:none" id="modal_expect_delivery_time"><div class="well bred" style="padding:4px 15px"><h5 class="modal-title"  id="expect_delivery_time"></h5></div></div>				
									</div>
									
								 </div>

								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="close_aceept_order">Close</button>
									<input type="submit" class="btn btn-primary" value="Accept Order">
								  </div>

								  </form>



								</div>
								</div>
								</div>

							<!-- Accept Modal -->


							<!-- Reject Modal -->
							<div id="rejectModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Reject Order</h4>
								  </div>
								<form action="reject_order.php" method="POST" id="frm_reject_order" name="frm_reject_order">
								<input type="hidden" name="order_id" value="<?php echo $order_id  ?>">
								  <div class="modal-body">

									<!-- <input type="text" name="reason" id="reason"  placeholder="Order Reject Reason"> -->
									<textarea name="reason" rows="" cols="" class="form-control"  id="reason" placeholder="Order Reject Reason" maxlength="45"></textarea>
									<div id="reject_order_msg"></div>
								 </div>

								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="close_reject_order">Close</button>
									<input type="submit" class="btn btn-primary" value="Reject Order">
								  </div>

								  </form>

								</div>
								</div>
								</div>

							<!-- Reject Modal -->



							<!-- Reaccept Modal -->
							<div id="ReacceptModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
								  <div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
									<h4 class="modal-title">Reaccept Order</h4>
								  </div>
								<form action="order_accept_to_reject.php" method="POST" id="frm_accept_reject_order" name="frm_accept_reject_order">

								<input type="hidden" name="order_id" value="<?php echo $order_id  ?>">

							<input type="hidden" name="email_id" value="<?php echo $OpOrder_detail[0]['email_id']  ?>">
								<input type="hidden" name="delivery_day" value="<?php echo $OpOrder_detail[0]['delivery_day'];  ?>">
								<input type="hidden" name="delivery_time" value="<?php echo $OpOrder_detail[0]['delivery_time'];  ?>"> 

								  <div class="modal-body">
										<?php

												//$opening_time=array('06.30','06.45','07.00','07.15','07.30','07.45','08.00','08.15','08.30','08.45','09.00','09.15','09.30','09.45','10.00','10.15','10.30','10.45','11.00','11.15','11.30','11.45','12.00','12.15','12.30','12.45','01.00','01.15','01.30','01.45','02.00');

												$opening_time = array('18:30' => '06:30','18:45' => '06:45','19:00' => '07:00','19:15' => '07:15','19:30' => '07:30','19:45' => '07:45','20:00' => '08:00','20:15' => '08:15','20:30' => '08:30','20:45' => '08:45','21:00' => '09:00','21:15' => '09:15','21:30' => '09:30','21:45' => '09:45','22:00' => '10:00','22:15' => '10:15','22:30' => '10:30','22:45' => '10:45','23:00' => '11:00','23:15' => '11:15','23:30' => '11:30','23:45' => '11:45');


											?>
									<!-- <input type="text" name="order_time" id="order_time"  placeholder="Enter Delivery time" required> -->
									<?php echo  'Delivery Date : '.date('d-m-Y'); ?>
									<br>
									<select class="form-control" id="order_time" name="order_time" required="" title="Please select order delivery time">
										<option value="" selected>Select delivery time</option>
										<?php
											foreach($opening_time as $key=> $value)
												{
													echo '<option value="'.$key.'">'.$value.'</option>';
												}
										?>
									</select>
									<div id="accept_order_msg"></div>
								 </div>

								  <div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true" id="close_reaccept_order">Close</button>
									<input type="submit" class="btn btn-primary" value="Accept Order">
								  </div>

								  </form>



								</div>
								</div>
								</div>

							<!-- Accept Modal -->


							  <div class="widget-foot">
								<!-- <button class="btn btn-danger pull-right">Reject Order</button> -->
								<div class="clearfix"></div>
							  </div>
				</div>
		</div>




		




	</div>
</div>








				  </div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->
		
		
			


		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<!-- Javascript files -->
		<!-- jQuery -->
		<script src="js/jquery.js"></script>
		<!-- Bootstrap JS -->
		<script src="js/bootstrap.min.js"></script>
		<!-- jQuery UI -->
		<script src="js/jquery-ui.min.js"></script> 
		<!-- jQuery Gritter -->
		<script src="js/jquery.gritter.min.js"></script>
		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
	</body>	
</html>

<script type="text/javascript">
	function delivery_time12()
	{
		document.getElementById("order_time").style.display = "";
		document.getElementById("submit_order").style.display = "";
	}
</script>



<script src="../js/jquery.validate.js"></script>
		<script src="../js/additional-methods.js"></script>
		<script src="../js/jquery.form.js"></script>

		<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_accept_order').validate({}); // For Validation should be there

	var options = { 
        target:        '#accept_order_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_accept_order').ajaxForm(options); 
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
		var response_val = response.split("~")
		if(response_val[1]=='error')
			document.getElementById("accept_order_msg").innerHTML = response_val[0];
		else
		{
			$( "#close_aceept_order" ).trigger( "click" );
			window.location.assign("orders.php");
		}


	}	 
});

</script>




		<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_reject_order').validate({}); // For Validation should be there

	var options = { 
        target:        '#reject_order_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_reject_order').ajaxForm(options); 
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
		var response_val = response.split("~")
		if(response_val[1]=='error')
			document.getElementById("reject_order_msg").innerHTML = response_val[0];
		else
		{
			$( "#close_reject_order" ).trigger( "click" );
			window.location.assign("orders.php");
		}


	}	 
});

</script>

<script type="text/javascript">
function order_completed()
	{
		try
		{
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
					//alert(response);
					var response_val = response.split("~");
					if(response_val[1]=='error')
						document.getElementById("accept_order_msg").innerHTML = response_val[0];
					else
					{
						window.location.assign("orders.php");
					}
					
				}
			}
			xmlhttp.open("GET", "order_completed.php?order_id="+order_id,true);
			xmlhttp.send();
	}

		catch (ex)
		{
			alert(ex);
		}
	}
</script>

<script type="text/javascript">
/*
function order_reject_accept()
	{
		try
		{
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
					//alert(response);
					var response_val = response.split("~")
					if(response_val[1]=='error')
						document.getElementById("reject_to_accept_order_msg").innerHTML = response_val[0];
					else
					{
						window.location.assign("orders.php");
					}
					
				}
			}
			xmlhttp.open("GET", "order_accept_to_reject.php?order_id="+order_id,true);
			xmlhttp.send();
	}

		catch (ex)
		{
			alert(ex);
		}
	}
	*/
</script>

<script type="text/javascript">

	$(document).ready(function () {
	$('#frm_accept_reject_order').validate({}); // For Validation should be there

	var options = { 
        target:        '#reject_to_accept_order_msg',   // target element(s) to be updated with server response 
      	beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse  // post-submit callback 
    }; 
     // bind form using 'ajaxForm' 
    $('#frm_accept_reject_order').ajaxForm(options); 
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
		var response_val = response.split("~")
		if(response_val[1]=='error')
			document.getElementById("reject_to_accept_order_msg").innerHTML = response_val[0];
		else
		{
			$("#close_reaccept_order").trigger("click");
			window.location.assign("orders.php");
		}


	}	 
});
</script>


<script type="text/javascript">
function get_report(month)
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
				document.getElementById(month).innerHTML = response;
			}
		}
		xmlhttp.open("GET", "get_reports.php?month="+month,true);
		xmlhttp.send();
	}
</script>


<script type="text/javascript">
	function get_timings()
	{
		var my_delivery_date_accept =document.getElementById("order_date").value ;
		var  my_delivery_time_accept ="<?php echo $OpOrder_detail[0]['delivery_time'] ?>";
		
		

		
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
		xmlhttp.open("GET", "get_delivery_time.php?my_delivery_date_accept="+my_delivery_date_accept+"&my_delivery_time_accept="+my_delivery_time_accept,true);
		
		xmlhttp.send();
	}
</script>

<script type="text/javascript">
	function get_delivery_timings()
	{
		var my_delivery_date ="<?php echo $OpOrder_detail[0]['delivery_day'];  ?>" ;
		var my_delivery_time ="<?php echo $OpOrder_detail[0]['delivery_time'];  ?>";
		var expect_order_time =document.getElementById("order_time").value ;
		

		
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
				document.getElementById("modal_expect_delivery_time").style.display="";
				document.getElementById("expect_delivery_time").innerHTML="Delivery Scheduled : "+xmlhttp.responseText;


			}
		}
		xmlhttp.open("GET", "get_expectdelivery_time.php?delivery_day="+my_delivery_date+"&delivery_time="+my_delivery_time+"&order_time="+expect_order_time,true);
		
		xmlhttp.send();
	}
</script>
