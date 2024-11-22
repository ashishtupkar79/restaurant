<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$Items=$connection->getItems();
	//print_r($Items);
	$numItem     = count($Items);
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
				<div class="page-head">
					  <!-- <h2 class="pull-left">Invoice <span class="page-meta">Something Goes Here</span></h2> -->
				</div>
				<!-- Page heading ends -->



				<!-- Matter -->





			<div class="matter">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								

								<div class="widget wviolet">
									<div class="widget-head">
										<div class="pull-left">Menu Items</div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
										<div class="table-responsive">
											<table class="table table-bordered ">
												<thead>
													<tr>
													  <th>#</th>
													  <th>Item Name</th>
													  <th>Status</th>
													</tr>
												</thead>
		
												<tbody>
												<?php
													
													for ($i = 0; $i < $numItem; $i++) 
													{
														
														$item_id = $Items[$i]['item_id'];
														echo '<tr>';
														echo '<td>'.($i+1).'</td>';
														echo '<td>'.ucwords($Items[$i]['item_name']).'</td>';

															if($Items[$i]['status'] == 'y')
															{
																$order_status='Active';
																$class='class="btn btn-success"';
															}
															else 
															{
																$order_status='Inactive';
																$class='class="btn btn-danger"';
															}

															echo '<td><a '.$class.' onclick="toggle_status('."'".$item_id."'".');" id="'.$item_id.'">'.$order_status.'</a></td>';
															
															
															
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

		<script type="text/javascript">
			var auto_refresh = setInterval(
			function ()
			{
					$('#slide-box1').load('notifications.php').fadeIn("slow");
			}, 10000); // refresh every 10000 milliseconds
			</script>

		<!-- Notification box starts -->
			<div  id="slide-box1">
			</div><!-- Notification box ends here -->

			
		<!-- Notification box ends here -->

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

<script>
function toggle_status(item_id)
{
		try
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
					//document.getElementById("accept_order_msg").innerHTML = response_val[0];
					window.location.assign("items.php");
				}
			}
			xmlhttp.open("GET", "item_status.php?item_id="+item_id,true);
			xmlhttp.send();
	}

		catch (ex)
		{
			alert(ex);
		}
	}
</script>