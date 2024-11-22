<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$OpOrders=$connection->getOpOrders();
	$numItem     = count($OpOrders);
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


		<style type="text/css">
				table thead th{
				background-repeat: no-repeat;
				background-position: center right;
				cursor: pointer;
			}
			.ascending{
				background-image: url('img/asc.gif');
			}
			.decending{
				background-image: url('img/desc.gif');
			}
			</style>

			<style type="text/css">
				table.tablesorter thead tr .headerSortUp {
				background-image: url("img/asc.gif");
			}
			table.tablesorter thead tr .headerSortDown {
				background-image: url("img/desc.gif");
			}
</style>

	</head>
	
	<body>

		<?php require 'header.php'; ?>

		<!-- Main content starts -->
		<div class="content">



			
			<?php require 'sidebar.php'; ?>





			<!-- Main bar -->
			<div class="mainbar">
			  
				<!-- Page heading -->
				<div class="page-head">
					  <!-- <h2 class="pull-left">Invoice <span class="page-meta">Something Goes Here</span></h2> -->
				</div>
				<!-- Page heading ends -->



				<!-- Matter -->





			<div class="matter">
					<div class="container">


							<!-- <div class="row">
								<div class="col-md-3">
									<div id="datetimepicker1" class="input-append">
										<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="select date to display records" id="picker" required="" style="width:90%">
										<span class="add-on"><i data-date-icon="fa fa-calendar"></i></span>
									</div> 
								 </div>
								<div class="col-md-4"><a class="btn btn-info"  onClick="display_records()">Display Records</a></div>
							</div> -->


						<div class="row">
							<div class="col-md-12">
								

								<div class="widget wviolet">
									<div class="widget-head">
										<div class="pull-left">Order Status From <?php  echo date('d-m-Y',strtotime( "-1 days")); ?> To <?php echo date('d-m-Y');  ?></div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
										<div class="table-responsive"  id="myrecords">
											<table class="table table-bordered " id="myTable">
												<thead>
													<tr>
													  <th class="decending ascending">#</th>
													  <th>Order Id</th>
													  <th>Mobile No. / Email</th>
													  <th>Name</th>
													  <th>Payment Type</th>
													  <th>Amount</th>
													  <th>Order Date</th>
													  <th>Requested Delivery Date</th>
													  <th>Scheduled Delivery Date</th>
													  <th class="decending ascending">Order Status</th>
													  <th>Order Details</th>
													</tr>
												</thead>
		
												<tbody>
												<?php
													$count_pending_orders=0;
													$count_rejected_orders=0;
													$count_accepted_orders=0;
													$j=0;
													for ($i = 0; $i < $numItem; $i++) 
													{
														if($OpOrders[$i]['order_status'] == 'ORPSC')
															continue;

														$free_meal = $OpOrders[$i]['free_meal'];
														if($free_meal == 'y')
															$free_meal='&nbsp;<b style="color:red">Free Meal</b>';
														else
															$free_meal="";

															echo '<tr>';
															echo '<td>'.($j=$j+1).'</td>';
															echo '<td>'.$OpOrders[$i]['orderid'].'<br>'.$free_meal.'</td>';
															echo '<td>'.$OpOrders[$i]['mobileno']. ' / '.$OpOrders[$i]['email_id'].'</td>';
															echo '<td>'.$OpOrders[$i]['name'].'</td>';
															echo '<td>'.$OpOrders[$i]['payment_type'].'</td>';
															echo '<td>'.$OpOrders[$i]['order_amt_payable'].'</td>';
															echo '<td>'.date('d-m-Y h:i A',strtotime($OpOrders[$i]['order_verify_date'])).'</td>';

															echo '<td>'.$OpOrders[$i]['delivery_day'].' '.$OpOrders[$i]['delivery_time'].'</td>';

															echo '<td>';
																if(strlen($OpOrders[$i]['order_delivery_date']) >0)
																	$order_delivery_date = date('d-m-Y h:i A',strtotime($OpOrders[$i]['order_delivery_date']));
																else
																	$order_delivery_date  ="&nbsp;";
															echo $order_delivery_date.'</td>';
															
															
															if($OpOrders[$i]['order_status'] == 'ORPS')
															{
																$order_status='Pending';
																$class='class="label btn btn-primary"';
																$count_pending_orders = $count_pending_orders +1;
															}
															else if($OpOrders[$i]['order_status'] == 'ORPSA')
															{
																$order_status='Accepted';
																$class='class="label label-success"';
																$count_accepted_orders = $count_accepted_orders +1;
															}
															else if($OpOrders[$i]['order_status'] == 'ORPSR')
															{
																$order_status='Rejected';
																$class='class="label label-important"';
																$count_rejected_orders = $count_rejected_orders +1;
															}
															
															
															echo '<td><span '.$class.'>'.$order_status.'</span></td>';
															echo '<td><a href="invoice.php?order_id='.$OpOrders[$i]['orderid'].'&name='.urlencode($OpOrders[$i]['name']).' " class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a></td>';
													echo '</tr>';
												}
												?>
				
													   
												</tbody>
											</table>
										</div>
									</div>
									<div class="widget-foot">
										<!-- <ul class="pagination pull-right">
										  <li><a href="#">Prev</a></li>
										  <li><a href="#">1</a></li>
										  <li><a href="#">2</a></li>
										  <li><a href="#">3</a></li>
										  <li><a href="#">4</a></li>
										  <li><a href="#">Next</a></li>
										</ul> -->
										<div class="clearfix"></div> 
									</div>
								</div>
							</div>
						</div>
						
							
						</div>
					</div>
				</div><!--/ Matter ends -->
			</div><!--/ Mainbar ends -->	    	
			<div class="clearfix"></div>
		</div><!--/ Content ends -->

	

			
		<!-- Notification box ends here -->

		<!-- Scroll to top -->
		<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span> 

		<!-- Javascript files -->
		<!-- jQuery -->
		
		<script src="js/jquery.js"></script>
		<script src="js/jquery.tablesorter.js"></script>

		<script type="text/javascript">
		
		$(document).ready(function()
		{
			$("#myTable").tablesorter();
		}
		);
		
		</script>
		
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

		<!-- Date picker -->
		<script src="js/bootstrap-datetimepicker.min.js"></script> 
		<!-- Bootstrap Toggle -->
		<script src="js/bootstrap-switch.min.js"></script> 

	</body>	
</html>


<script>
			/* Bootstrap Switch */
			$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
			/* Date picker */
			$(function() {
				$('#datetimepicker1').datetimepicker({
					
				 
				});
			});

		
			
			
			/* *************************************** */
</script>

<script type="text/javascript">
function display_records()
	{
		try
		{
			var order_date_from = document.getElementById("picker").value;
			
			if(order_date_from=="")
			{
				alert("Please select date");
				return false;
			}
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
					document.getElementById("myrecords").innerHTML = response;
				}
			}
			xmlhttp.open("GET", "display_previous_record.php?order_date="+order_date_from,true);
			xmlhttp.send();
	}
	catch (ex)
	{
		alert(ex);
	}
}
</script>
<script type="text/javascript">
$('#slide-box2').load('notifications.php').fadeIn("slow");
</script>