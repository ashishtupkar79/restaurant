<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	

	if(isset($_POST['items']) )
	{
		$category= trim($_POST['category']);
		$item_id= trim($_POST['item_id']);

		$category= trim($_POST['category']);
		$sub_category= trim($_POST['sub_category']);
		$item_name= trim($_POST['item_name']);
		$item_description= trim($_POST['item_description']);
		$status= trim($_POST['status']);
		$category_id= trim($_POST['category_id']);

		if( $_POST['items'] =='Add Items')
		{
			if(strlen($item_name) > 0 && strlen($sub_category) > 0 && strlen($status) >0 && strlen($category) >0)
			{
				$where="";
				$max_item_id="";
				$results=$connection->get_data("menu_items_master","max(item_id)+1 as max_item_id",$where,null);
				foreach($results as $usrinfo)
				{
					$max_item_id = $usrinfo['max_item_id'];
					$item_image =$max_item_id.'.jpg';
				}
				if(strlen($max_item_id) > 0 && strlen($item_image) > 0)
				{
					$values=array($max_item_id,$category,addslashes($sub_category),addslashes($item_name),addslashes($item_description),$item_image,$status);
					$OrdertMast=$connection->insert_data("menu_items_master",$values,"item_id,category_id,sub_category_code,item_name,item_description,item_image,status");
					$_POST['items']="";
				}
			}
		}
		
		if( $_POST['items'] =='Modify Items')
		{
			if(strlen(trim($item_id)) > 0 && strlen(trim($status)) >0)
			{
				$rows = array('category_id'=>$category,'sub_category_code'=>addslashes($sub_category),'item_name'=>addslashes($item_name),'item_description'=>addslashes($item_description), 'status'=>$status);
				$where = " item_id = '$item_id' ";
				$connection->update_data('menu_items_master',$rows,$where);
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
										<div class="pull-left">Menu Item From </div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
									  <div class="padd">

										<?php

											$sub_category_name ="";
											$item_name ='';
											$item_description='';
											$status="";
											$btnVal = 'Add Items';
											if(isset($_GET['item_id']) && $_GET['item_id'] !='' && isset($_GET['category_id']) && $_GET['category_id'] !='')
											{
													$get_item_id = $_GET['item_id'];
													$get_category_id = $_GET['category_id'];

													$where=" c.category_id=i.category_id and i.item_id = $get_item_id  ";

													$results=$connection->get_data("menu_category_master c, menu_items_master i","c.category_id,c.category_name,i.item_id,i.sub_category_code,i.item_name,i.item_description,i.status",$where,null);
													foreach($results as $usrinfo)
													{
														$sub_category_name = stripslashes($usrinfo['sub_category_code']);
														$item_name = stripslashes($usrinfo['item_name']);
														$item_description = stripslashes($usrinfo['item_description']);
														$status = $usrinfo['status'];
														$btnVal='Modify Items';
													}
											}
											
										?>
										<!-- Form starts.  -->
											<form class="form-horizontal" role="form" action="menu_item_master.php" method="POST">
												<input type="hidden" name="category_id" value="<?php echo $get_category_id ?>">
												<input type="hidden" name="item_id" value="<?php echo $get_item_id ?>">
												
												<div class="form-group">
												  <label class="col-md-2 control-label">Select Category</label>
												  <div class="col-md-3">
														<select name="category" class="form-control">
															<option value="" selected>Select Category</option>
															<?php
																$where="";
																$results=$connection->get_data("menu_category_master","category_id,category_name",$where,' category_id');
																foreach($results as $usrinfo)
																{
																	$selected="";
																	if($usrinfo['category_id'] == $get_category_id)
																		$selected = 'selected';
																	echo '<option value="'.$usrinfo['category_id'].'" '.$selected.'>'.$usrinfo['category_name'].'</option>';
																}
															?>
														</select>
												  </div>

												  <label class="col-md-2 control-label">Sub Headings</label>
												  <div class="col-md-3">
													<input type="text" class="form-control" placeholder="Sub Headings ex: Veg, Nonveg, Rice" name="sub_category" value="<?php echo $sub_category_name; ?>">
												  </div>

												</div>

												

												<div class="form-group">
												  <label class="col-md-2 control-label">Item Name</label>
												  <div class="col-md-3">
													<input type="text" class="form-control" placeholder="Item Name" name="item_name" value="<?php echo htmlentities($item_name); ?>">
												  </div>
													 <label class="col-md-2 control-label">Status</label>
													<div class="col-md-3">
													<div class="radio">
														<label>
															<input type="radio" name="status" id="optionsRadios1" value="y" <?php if (@$status=='y') echo 'checked';?>>
															Active
														</label>
													  <label>
														<input type="radio" name="status" id="optionsRadios2" value="n"  <?php if (@$status=='n') echo 'checked';?>>
														Inactive
													  </label>
													</div>
												  </div>

												 

												  

												</div>

												
												
											<div class="form-group">
												 
												  
													<label class="col-md-2 control-label">Item Description</label>
												  <div class="col-md-4"><textarea style="resize:none" rows="3" cols="23" name="item_description"><?php echo $item_description; ?></textarea></div>
												
												 <div class="col-md-3">
														<input type="submit" class="btn btn-success" value="<?php echo $btnVal; ?>" name="items">
												   </div>

													
												</div>
												
												  
												<div class="form-group">
												  
												</div>
											</form>
									  </div>
									</div>
									<?php
									   $order = " c.category_id, i.item_id, i.sub_category_code ";
										$where=" c.category_id=i.category_id ";
										$results=$connection->get_data("menu_category_master c, menu_items_master i","c.category_id,c.category_name,i.item_id,i.sub_category_code,i.item_name,i.status",$where,$order);
									?>
									<div class="widget-content">
										<div class="table-responsive"  id="myrecords">
											<table class="table table-bordered " id="myTable">
												<thead>
													<tr>
													  <th class="decending ascending">Item Id</th>
													  <th>Category</th>
													  <th>Sub Heading</th>
													  <th>Item Name</th>
													  <th>Status</th>
													  <th>View Details</th>
													</tr>
												</thead>
		
												<tbody>
											<?php
												if(count($results) >0)
												{
													
													foreach($results as $usrinfo)
													{
														echo '<tr><td>'.$usrinfo['item_id'].'</td><td>'.$usrinfo['category_name'].'</td><td>'.$usrinfo['sub_category_code'].'</td><td>'.$usrinfo['item_name'].'</td><td>'.$usrinfo['status'].'</td><td><a href="menu_item_master.php?item_id='.$usrinfo['item_id'].'&category_id='.$usrinfo['category_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></td></tr>';
														
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