<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<!-- Title here -->
		<title>Users Zaikart</title>
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
				<!-- <div class="page-head">
					  <h2 class="pull-left">Users </h2>
				</div> -->
				<!-- Page heading ends -->



				<!-- Matter -->





			<div class="matter">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								

								<div class="widget wviolet">
									<div class="widget-head">
										<div class="pull-left">Users</div>
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
													  <th>Name</th>
													  <th>User Name</th>
													  <th>Type</th>
													  <th>Status</th>
													   <th>Modify</th>
													</tr>
												</thead>
												<tbody>
													<?php
															$where = "user_type='operator' ";
															$results=$connection->get_data("admin_users","*",$where,null);
															$i=1;
															foreach($results as $usrinfo)
															{
																echo '<tr>';
																echo '<td>'.$i.'</td>';
																echo '<td>'.ucfirst($usrinfo['name']).'</td>';
																echo '<td>'.$usrinfo['user_id'].'</td>';
																echo '<td>'.ucfirst($usrinfo['user_type']).'</td>';
													  			if($usrinfo['status'] == 'y')
																	echo '<td><span class="label label-success">Active</span></td>';
																else
																	echo '<td><span class="label label-important">In active</span></td>';

																echo '<td><a class="btn btn-sm btn-warning" href="users_add.php?user_id='.urlencode($usrinfo['user_id']).'"><i class="fa fa-pencil"></i> </a></td>';


													  			echo '</tr>';
																$i++;
																								
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