<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$btnVal = 'Add Category';
	if(isset($_POST['category']) )
	{
		$category_name= $_POST['category_name'];
		$status= $_POST['status'];
		$category_id= $_POST['category_id'];
		$display_position= $_POST['display_position'];

		if( $_POST['category'] =='Add Category')
		{
			if(strlen(trim($category_name)) > 0 && strlen(trim($status)) >0 && strlen(trim($display_position)) >0)
			{
				$where="";
				$max_category_id="";
				$results=$connection->get_data("menu_category_master","max(category_id)+1 as max_category_id",$where,null);
				foreach($results as $usrinfo)
				{
					$max_category_id = $usrinfo['max_category_id'];
				}
				$values=array($max_category_id,$category_name,$category_name,'-',$status,$display_position);
				$OrdertMast=$connection->insert_data("menu_category_master",$values,"category_id,category_name,description,search_options,status,display_position");
			}
		}
		
		if( $_POST['category'] =='Modify Category')
		{
			if(strlen(trim($category_name)) > 0 && strlen(trim($status)) >0)
			{
				$rows = array('category_name'=>$category_name, 'status'=>$status,'display_position'=>$display_position);
				$where = " category_id = '$category_id' ";
				$connection->update_data('menu_category_master',$rows,$where);
			}
		}
	}
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
					  
				</div>
				<!-- Page heading ends -->



				<!-- Matter -->





			<div class="matter">
					<div class="container">


					


						<div class="row">
							<div class="col-md-12">
								

								<div class="widget wviolet">
									<div class="widget-head">
										<div class="pull-left">Menu Category From </div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
									  <div class="padd">

										<?php
											if(isset($_GET['category_id']) && $_GET['category_id'] !='')
											{
													$category_id = $_GET['category_id'];
													$where=" category_id = $category_id ";
													$results=$connection->get_data("menu_category_master","category_id,category_name,status,display_position",$where,"display_position");
													foreach($results as $usrinfo)
													{
														$category_name = $usrinfo['category_name'];
														$display_position = $usrinfo['display_position'];
														$status = $usrinfo['status'];
														$btnVal='Modify Category';
													}

											}
											else
											{
													$category_name ="";
													$status="";
													$display_position="";
											}
										?>
										<!-- Form starts.  -->
											<form class="form-horizontal" role="form" action="category_master.php" method="POST">
												<input type="hidden" name="category_id" value="<?php echo $category_id ?>">
												<div class="form-group">
												  <label class="col-md-2 control-label">Category Name</label>
												  <div class="col-md-8">
													<input type="text" class="form-control" placeholder="Category Name" name="category_name" value="<?php echo $category_name; ?>">
												  </div>
												</div>

												<div class="form-group">
												  <label class="col-md-2 control-label">Display Position</label>
												  <div class="col-md-8">
													<input type="text" class="form-control" placeholder="Display Position" name="display_position" value="<?php echo $display_position; ?>">
												  </div>
												</div>
												
											<div class="form-group">
												  <label class="col-md-2 control-label">Status</label>
												  <div class="col-md-8">
													<div class="radio">
													  <label>
														<input type="radio" name="status" id="optionsRadios1" value="y" <?php if (@$status=='y') echo 'checked';?>>
														Active
													  </label>
													</div>
													<div class="radio">
													  <label>
														<input type="radio" name="status" id="optionsRadios2" value="n"  <?php if (@$status=='n') echo 'checked';?>>
														Inactive
													  </label>
													</div>
												  </div>
												</div>
												
												  
												<div class="form-group">
												  <div class="col-md-offset-2 col-md-8">
													
													<input type="submit" class="btn btn-success" value="<?php echo $btnVal; ?>" name="category">
													
												  </div>
												</div>
											</form>
									  </div>
									</div>
									<?php
										$where="";
										$results=$connection->get_data("menu_category_master","category_id,category_name,display_position,status",$where," display_position");
									?>
									<div class="widget-content">
										<div class="table-responsive"  id="myrecords">
											<table class="table table-bordered " id="myTable">
												<thead>
													<tr>
													  <th class="decending ascending">Category Id</th>
													  <th>Category Name</th>
													  <th>Status</th>
													  <th>Display Position</th>
													  <th>Control</th>
													</tr>
												</thead>
		
												<tbody>
											<?php
												if(count($results) >0)
												{
													
													foreach($results as $usrinfo)
													{
														echo '<tr><td>'.$usrinfo['category_id'].'</td><td>'.$usrinfo['category_name'].'</td><td>'.$usrinfo['status'].'</td><td>'.$usrinfo['display_position'].'</td><td><a href="category_master.php?category_id='.$usrinfo['category_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></td></tr>';
														
													}
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
