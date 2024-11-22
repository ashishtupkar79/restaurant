<?php 
	session_start();
	
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	
	if(isset($_GET['category']) &&  trim($_GET['category']) !="")
	{
		$category = trim($_GET['category']);
		if(isset($_GET['item_id']) &&  trim($_GET['item_id']) !="")
			$item_id = $_GET['item_id'];

		echo '<select name="items" id="items" class="form-control" onChange="GetItemName_Details()"><option value="" selected>Select Item</option>';
		$where=" category_id = $category";
		$results=$connection->get_data("menu_items_master","item_id,item_name",$where,' item_id');
		foreach($results as $usrinfo)
			{
				$selected="";
				if($item_id == $usrinfo['item_id'])
					$selected = 'selected';
				echo '<option value="'.$usrinfo['item_id'].'" '.$selected.'>'.$usrinfo['item_name'].'</option>';
			}
		echo '</select>';
		
		$results="";
		$where="";
		$where=" c.category_id = i.category_id and i.item_id = id.item_id and i.category_id = $category";
		$results=$connection->get_data("menu_items_master i,menu_items_master_details id,menu_category_master c","i.item_id,i.item_name,id.detail_id,id.detail_description,id.item_price,id.status",$where,' item_id, detail_id');
		echo '~<div class="widget-content"><div class="table-responsive"  id="myrecords"><table class="table table-bordered " id="myTable">';
		echo '<thead><tr><th class="decending ascending">Item Id</th><th class="decending ascending">Detail Id</th><th>Item Name</th>
			<th>Item Description</th><th>Item Price</th><th>Status</th></tr></thead>';
				foreach($results as $usrinfo)
				{
					echo '<tr><td>'.$usrinfo['item_id'].'</td><td>'.$usrinfo['detail_id'].'</td><td>'.$usrinfo['item_name'].'</td><td>'.$usrinfo['detail_description'].'</td><td>'.number_format(($usrinfo['item_price']), 2, '.', '').'</td><td>'.$usrinfo['status'].'</td></tr>';
				}
		echo '</div></div></table>';
		exit;
	}

	
	if(isset($_GET['tbl_item_id']) &&  trim($_GET['tbl_item_id']) !="" && isset($_GET['tbl_category_id']) &&  trim($_GET['tbl_category_id']) !="")
	{
		$results="";
		$where="";
		$category_id = trim($_GET['tbl_category_id']);
		$item_id = trim($_GET['tbl_item_id']);
		$where=" c.category_id = i.category_id and i.item_id = id.item_id and id.item_id=$item_id and i.category_id =$category_id ";
		$results=$connection->get_data("menu_items_master i,menu_items_master_details id,menu_category_master c","i.item_id,i.item_name,id.detail_id,id.detail_description,id.item_price,id.status",$where,' item_id, detail_id');

		echo '<div class="widget-content"><div class="table-responsive"  id="myrecords"><table class="table table-bordered " id="myTable">';
		echo '<thead><tr><th class="decending ascending">Item Id</th><th class="decending ascending">Detail Id</th><th>Item Name</th>
			<th>Item Description</th><th>Item Price</th><th>Status</th><th>Update</th></tr></thead>';
			foreach($results as $usrinfo)
				{
					$status=$usrinfo['status'];
					$status_y="";
					$status_n="";

					 if($status=='y')
						$status_y='checked';

					  if($status=='n')
						$status_n='checked';

					echo '<tr><td>'.$usrinfo['item_id'].'</td><td>'.$usrinfo['detail_id'].'</td><td>'.$usrinfo['item_name'].'</td><td><input type="text" class="form-control" name="detail_description_'.$usrinfo['detail_id'].'" id="detail_description_'.$usrinfo['detail_id'].'" value="'.stripslashes($usrinfo['detail_description']).'"></td><td><input type="text" name="item_price_'.$usrinfo['detail_id'].'" id="item_price_'.$usrinfo['detail_id'].'" class="form-control" value="'.number_format(($usrinfo['item_price']), 2, '.', '').'"></td><td><input type="radio" name="status_'.$usrinfo['detail_id'].'" id="status_'.$usrinfo['detail_id'].'_y" value="y" '.$status_y.'>&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status_'.$usrinfo['detail_id'].'" id="status_'.$usrinfo['detail_id'].'_n" value="n" '.$status_n.'> Inactive</td><td><input type="submit" name="item_detail" value="Update" class="btn btn-success" onClick="update('."'".$usrinfo['item_id']."',"."'".$usrinfo['detail_id']."','Update'".')"></td></tr>';
				}



				echo '<tr><td colspan="06" align="center"><h3>Add Record</h3></td></tr>';
				$where="";
				$where="c.category_id = i.category_id and i.item_id=$item_id and i.category_id =$category_id ";
				$results=$connection->get_data("menu_items_master i,menu_category_master c","i.item_id,i.item_name",$where,' item_id');
				foreach($results as $usrinfo)
				{
				echo '<tr><td>'.$usrinfo['item_id'].'</td><td>&nbsp;</td><td>'.$usrinfo['item_name'].'</td><td><input type="text" class="form-control" name="detail_description" id="detail_description" value="" placeholder="Item description"></td><td><input type="text" name="item_price" id="item_price" class="form-control" value="" placeholder="Item Price"></td><td><input type="radio" name="status" id="status_y" value="y">&nbsp;&nbsp;Active&nbsp;&nbsp;<input type="radio" name="status" id="status_n" value="n"> Inactive</td><td><input type="submit" name="item_detail" value="Insert" class="btn btn-success" onClick="update('."'".$usrinfo['item_id']."',"."'dummy_item_id','Insert'".')"></td></tr>';
				}
			echo '</div></div></table>';
		exit;
	}


	if(isset($_GET['item_detail']) )
	{
		$detail_id= trim($_GET['detail_id']);
		$item_id= trim($_GET['item_id']);
		$detail_description	= trim($_GET['detail_description']);
		$item_price= trim($_GET['item_price']);
		$status= trim($_GET['status']);
		

		if( $_GET['item_detail'] =='Insert')
		{
			if(strlen($item_id) > 0 && strlen($status) > 0  && strlen($item_price) >0)
			{
				$where="";
				$max_item_id="";
				$results=$connection->get_data("menu_items_master_details","max(detail_id)+1 as max_detail_id",$where,null);
				foreach($results as $usrinfo)
				{
					$max_detail_id = $usrinfo['max_detail_id'];
				}
				if(strlen($max_detail_id) > 0)
				{
					$values=array($max_detail_id,$item_id,addslashes($detail_description),$item_price,$status);
					$OrdertMast=$connection->insert_data("menu_items_master_details",$values,"detail_id,item_id,detail_description,item_price,status");
					if($OrdertMast)
						echo 'Record Saved';
					else
						echo 'Record cannot Saved';
					exit;
				}
			}
		}
	
		
		if( $_GET['item_detail'] =='Update')
		{
			if(strlen($item_id) > 0 && strlen($status) > 0 && strlen($detail_id) > 0 && strlen($item_price) >0)
			{
				$rows = array('detail_description'=>addslashes($detail_description),'item_price'=>$item_price,'status'=>$status);
				$where = " item_id = '$item_id' and detail_id='$detail_id' ";
				$connection->update_data('menu_items_master_details',$rows,$where);
				if($connection)
					echo 'Record Update';
				else
					echo 'Record Not Update';
				exit;
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

										
										<!-- Form starts.  -->
											<form class="form-horizontal" role="form" action="menu_item_master.php" method="POST">
												<input type="hidden" name="category_id" value="<?php echo $get_category_id ?>">
												<input type="hidden" name="item_id" value="<?php echo $get_item_id ?>">
												
												<div class="form-group">
												  <label class="col-md-2 control-label">Select Category</label>
												  <div class="col-md-3">
														<select name="category" id="category" class="form-control" onChange="GetItemName()">
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

												  <label class="col-md-2 control-label">Select Items</label>
												  <div class="col-md-3">
													<div id="select_items">
														<select name="items" class="form-control" id="items"><option value="" selected>Select Items</option></select>
													</div>
												  </div>

												</div>
			
									  </div>
									</div>
									<?php
									   $order = " c.category_id, i.item_id, i.sub_category_code ";
										$where=" c.category_id=i.category_id ";
										$results=$connection->get_data("menu_category_master c, menu_items_master i","c.category_id,c.category_name,i.item_id,i.sub_category_code,i.item_name,i.status",$where,$order);
									?>
										<div id="myrecords"></div>

									
									<div class="widget-foot">
									
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
function GetItemName()
	{
		try
		{
			var category = document.getElementById("category").value;
			
			if(category=="")
			{
				alert("Please select category");
				document.getElementById("myrecords").innerHTML = "";
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
					var response_val = response.split("~");
					document.getElementById("select_items").innerHTML = response_val[0];
					document.getElementById("myrecords").innerHTML = response_val[1];
				}
			}
			xmlhttp.open("GET", "menu_item_detail.php?category="+category,true);
			xmlhttp.send();
	}
	catch (ex)
	{
		alert(ex);
	}
}
</script>

<script type="text/javascript">
function GetItemName_Details()
	{
		try
		{
			var category = document.getElementById("category").value;
			var items = document.getElementById("items").value;
			
			if(category!="" &&  items=="" )
			{
				GetItemName();
				return false;
			}

			if( items=="" )
			{
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
					document.getElementById("myrecords").innerHTML = response;
				}
			}
			xmlhttp.open("GET", "menu_item_detail.php?tbl_item_id="+items+"&tbl_category_id="+category,true);
			xmlhttp.send();
	}
	catch (ex)
	{
		alert(ex);
	}
}
</script>
<script type="text/javascript">
function update(item_id,detail_id,op)
	{
		
		/*if(op == 'Update')
		{
			var item_description = document.getElementById("detail_description_"+detail_id).value;
			var item_price = document.getElementById("item_price_"+detail_id).value;
			if(document.getElementById("status_"+detail_id+"_y").checked==true)
				var status = 'y';
			if(document.getElementById("status_"+detail_id+"_n").checked==true)
				var status = 'n';
		}*/
		
		
		if(op == 'Update')
		{
			var item_description = document.getElementById("detail_description_"+detail_id).value;
			var item_price = document.getElementById("item_price_"+detail_id).value;
			if(document.getElementById("status_"+detail_id+"_y").checked==true)
				var status = 'y';
			if(document.getElementById("status_"+detail_id+"_n").checked==true)
				var status = 'n';
		}
		if(op == 'Insert')
		{
			var item_description = document.getElementById("detail_description").value;
			var item_price = document.getElementById("item_price").value;
			if(document.getElementById("status_y").checked==true)
				var status = 'y';
			if(document.getElementById("status_n").checked==true)
				var status = 'n';
		}
		
		if(item_id !="" &&  detail_id !="" && status !="" && op !="" && item_price !="")
		{
			
		}
		else
		{
			alert("Please enter Item price and Status");
			return false;
		}
		//alert(detail_id+" "+item_id+" "+item_description+" "+item_price+" "+status);

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
					alert(response);
					GetItemName_Details();

				}
			}
		
		xmlhttp.open("GET", "menu_item_detail.php?item_id="+item_id+"&detail_id="+detail_id+"&detail_description="+item_description+"&item_price="+item_price+"&item_detail="+op+"&status="+status,true);
		xmlhttp.send();


		
}
</script>