<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object

	
	
	$order_id =  $_GET['order_id'];
	$name = urldecode($_GET['name']);
	$OpOrder_detail=$connection->getOpOrder_detail($order_id);

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
								

									<div class="widget-content">
										 <div class="padd invoice">
										
								

								
							

							
							<?php
								//$sql="select distinct DATE_FORMAT(order_complete_date,'%b-%Y') from order_master";
							?>
					
								<div class="container">
									<div class="panel-group" id="accordion">

										<?php
											//$sql="select distinct DATE_FORMAT(order_complete_date,'%b-%Y') as month from order_master";
											$where ="DATE_FORMAT(order_complete_date,'%b-%Y') is not null";
											$months_array=$connection->get_data("order_master"," distinct DATE_FORMAT(order_complete_date,'%M-%Y') as month",$where,null);
											$i=1;
											foreach($months_array as $key=>$months)
											{
												{
														$month = $months['month'];
														$month_val = explode("-",$month);
														$month_name = $month_val[0];
														$year = $month_val[1];
										?>
										<div class="panel panel-default">

											 <div class="panel-heading">
												<h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $i?>"><?php echo $month_name.' - ' .$year?></a></h4>
											  </div>

											  <div id="collapse<?php echo $i?>" class="panel-collapse collapse">
													<div class="panel-body" id="May">
														
														<div class="row">

															<div class="col-md-4">
																	<div class="widget wlightblue">
																		
																		<div class="widget-head">
																			<div class="pull-left">Most Popular Product</div>
																				<?php
																					$getPopularProducts=$connection->getPopularProducts($month_name);
																					$num_most_popular_items     = count($getPopularProducts);
																				?>
																			<div class="clearfix"></div>
																		</div>

																		<div class="widget-content referrer">
																		
																			<div class="padd">
																				<ul class="list-unstyled latest-news">
																					<li>
																						<h6><a href="#"><?php echo $getPopularProducts[0]['item_name'];  ?></a></h6>
																						
																					</li>
																				</ul> 
																			</div>
																		</div>
																	</div>
																</div>



															


																<div class="col-md-4">
																	<div class="widget wlightblue">
																		
																		<div class="widget-head">
																			<div class="pull-left">Most Valuable Customer</div>
																				<?php
																					$valuable_customer=$connection->valuable_customer($month_name);
																					$num_valuable_customer     = count($valuable_customer);
																				?>
																			<div class="clearfix"></div>
																		</div>

																		<div class="widget-content referrer">
																		
																			<div class="padd">
																				<ul class="list-unstyled latest-news">
																					<li>
																						<h6><a href="#"><?php echo ucwords($valuable_customer[0]['ofname'].' '.$valuable_customer[0]['olname']); ?></a></h6>
																					
																							<p>Mobile: <b><?php echo $valuable_customer[0]['mobileno'];  ?></b></p>
																							<p>Email: <b><?php echo $valuable_customer[0]['email_id'];  ?></b></p>
																					</li>
																				</ul> 
																			</div>
																		</div>
																	</div>
																</div>


																<div class="col-md-4">
															<div class="widget wlightblue">
																
																<div class="widget-head">
																	<div class="pull-left">Most Popular Area</div>
																		<?php
																			$getPopularAreas=$connection->getPopularAreas($month_name);
																			$num_most_PopularAreas    = count($getPopularAreas);
																		?>
																	<div class="clearfix"></div>
																</div>

																<div class="widget-content referrer">
																
																	<div class="padd">
																		<ul class="list-unstyled latest-news">
																			<li>
																				<p>Area : <b><?php echo $getPopularAreas[0]['area'];  ?></b></p>
																				<p>Pincode : <b><?php echo $getPopularAreas[0]['pincode'];  ?></b></p>
																			</li>
																		</ul> 
																	</div>
																</div>
															</div>
														</div>


														</div>

														<div class="row">
																<div class="col-md-4">
																	<div class="widget worange">
																		<div class="widget-head">
																			<div class="pull-left">Top 5 Popular Product</div>
																			<div class="widget-icons pull-right">
																				<!-- <a class="wminimize" href="#"><i class="fa fa-chevron-up"></i></a> 
																				<a class="wclose" href="#"><i class="fa fa-times"></i></a> -->
																			</div>
																			<div class="clearfix"></div>
																		</div>
																		<div class="widget-content">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<thead>
																						<tr>
																							<th>#</th>
																							<th>Item Name</th>
																							<th>Count</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																							
																							
																							$j=1;
																							for ($i = 0; $i <$num_most_popular_items; $i++) 
																							{
																									echo '</tr>';
																									echo '<td>'.$j.'</td>';
																									echo '<td>'.$getPopularProducts[$i]['item_name'].'</td>';
																									echo '<td>'.$getPopularProducts[$i]['count_product'].'</td>';
																									echo '</tr>';
																									$j++;
																							}
																						?>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>


																<div class="col-md-4">
																	<div class="widget worange">
																		<div class="widget-head">
																			<div class="pull-left">Top 5 Customers</div>
																			<div class="widget-icons pull-right">
																				<!-- <a class="wminimize" href="#"><i class="fa fa-chevron-up"></i></a> 
																				<a class="wclose" href="#"><i class="fa fa-times"></i></a> -->
																			</div>
																			<div class="clearfix"></div>
																		</div>
																		<div class="widget-content">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<thead>
																						<tr>
																							<th>#</th>
																							<th>Customer Name</th>
																							<th>Count</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																							
																							
																							$j=1;
																							for ($i = 0; $i <$num_valuable_customer; $i++) 
																							{
																									echo '</tr>';
																									echo '<td>'.$j.'</td>';
																									echo '<td>'.ucwords($valuable_customer[$i]['ofname'].' '.$valuable_customer[$i]['olname']).'</td>';
																									echo '<td>'.$valuable_customer[$i]['max_users'].'</td>';
																									echo '</tr>';
																									$j++;
																							}
																						?>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>



																<div class="col-md-4">
																	<div class="widget worange">
																		<div class="widget-head">
																			<div class="pull-left">Top 5 Areas</div>
																			<div class="widget-icons pull-right">
																				<!-- <a class="wminimize" href="#"><i class="fa fa-chevron-up"></i></a> 
																				<a class="wclose" href="#"><i class="fa fa-times"></i></a> -->
																			</div>
																			<div class="clearfix"></div>
																		</div>
																		<div class="widget-content">
																			<div class="table-responsive">
																				<table class="table table-bordered">
																					<thead>
																						<tr>
																							<th>#</th>
																							<th>Area</th>
																							<th>Pincode</th>
																							<th>Count</th>
																						</tr>
																					</thead>
																					<tbody>
																						<?php
																							
																							
																							$j=1;
																							for ($i = 0; $i <$num_most_PopularAreas ; $i++) 
																							{
																									echo '</tr>';
																									echo '<td>'.$j.'</td>';
																									echo '<td>'.$getPopularAreas[$i]['area'].'</td>';
																									echo '<td>'. $getPopularAreas[$i]['pincode'].'</td>';
																									echo '<td>'. $getPopularAreas[$i]['count_area'].'</td>';
																									echo '</tr>';
																									$j++;
																							}
																						?>
																					</tbody>
																				</table>
																			</div>
																		</div>
																	</div>
																</div>

														</div><!-- End Row -->


														


												 </div>
											</div>
									</div><!-- End Collapse 1 -->	
									
								<?php 	
										}
									}		
								?>
									<!-- Second Accordin Starts -->

										 

									<!-- Second Accordin Ends -->






								</div>		
							</div>
						
								

								


							  </div>
							</div>

							


							



							


							
				</div>
		</div>




		




	</div>
</div>








				  </div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			
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

Orders!orders.php@Process Today's  Orders~order_history.php@Order History^Menu Items!items.php@Item Status^Reports!report1.php@Report1^Users!users.php@View Users~users_add.php@Add Users