<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	
	
	
	if(isset($_POST['time_slots']) )
	{
		$start_time= trim($_POST['start_time']);
		$end_time= trim($_POST['end_time']);
		$is_curday= trim($_POST['is_curday']);
		$status= trim($_POST['status']);
		$slot_id = $_POST['slot_id'];
		


		if($_POST['time_slots'] =='Add Time Slots')
		{
			
			if(strlen($start_time) > 0 && strlen($end_time) > 0 && strlen($status) >0 && strlen($is_curday) >0)
			{
				$where="";
				$max_slot_id="";
				$results=$connection->get_data("delivery_timings","IFNULL(max(slot_id),0)+1 as max_slot_id",$where,null);
				foreach($results as $usrinfo)
				{
					$max_slot_id = $usrinfo['max_slot_id'];
				}
				
				if(strlen($max_slot_id) > 0)
				{
					$values=array($max_slot_id,$start_time,$end_time,$is_curday,$status);
					$time_Slots=$connection->insert_data("delivery_timings",$values,"slot_id,start_time,end_time,is_curday,status");
					$_POST['time_slots']="";
				}
			}
		}
		
		if($_POST['time_slots'] =='Modify Time Slots')
		{
			
			if(strlen(trim($slot_id)) > 0 &&  strlen($start_time) > 0 && strlen($end_time) > 0 && strlen($status) >0 && strlen($is_curday) >0)
			{
				$rows = array('start_time'=>$start_time,'end_time'=>$end_time,'is_curday'=>$is_curday,'status'=>$status);
				$where = " slot_id = '$slot_id' ";
				$connection->update_data('delivery_timings',$rows,$where);
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
										<div class="pull-left">Delivery Timings From </div>
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>
									<div class="widget-content">
									  <div class="padd">

										<?php
											$default_start_time = '12.00 am';
											$interval = '+15 minutes';
											$default_end_time = '12.00 am';
											$start_time ="";
											$end_time ='';
											$is_curday='';
											$status="y";
											$slot_id="";
											$btnVal = 'Add Time Slots';
											if(isset($_GET['slot_id']) && $_GET['slot_id'] !='')
											{
												$slot_id = $_GET['slot_id'];
												$where=" slot_id = $slot_id  ";
												$results=$connection->get_data("delivery_timings","start_time,end_time,is_curday,status",$where,null);
												foreach($results as $usrinfo)
												{
													$start_time = $usrinfo['start_time'];
													$default_start_time =$start_time;

													$end_time =$usrinfo['end_time'];
													$default_end_time = $end_time;
													$is_curday = $usrinfo['is_curday'];
													$status = $usrinfo['status'];
													$btnVal='Modify Time Slots';
												}
											}
											function get_times($default, $interval ) 
											{
												$output = '';
												$current = strtotime( '00:00' );
												$end = strtotime( '23:59' );
												while( $current <= $end ) 
												{
													//$time = date( 'H:i', $current );
													$sel="";
													$new_time = date('h.i a',$current);
													if ($new_time == $default)
														 $sel='selected';
													$output .= "<option value='".date( 'h.i a', $current ). "' ".$sel.">". date( 'h.i a', $current ).'</option>';
													$current = strtotime( $interval, $current );
												}
												return $output;
											}
										
											
										?>
										<!-- Form starts.  -->
											<form class="form-horizontal" role="form" action="delivery_timings.php" method="POST">
												
												<input type="hidden" name="slot_id" value="<?php echo $slot_id; ?>">
												<div class="form-group">
												  <label class="col-md-2 control-label">Select Start Time</label>
												  <div class="col-md-3">
														<select name="start_time" class="form-control">
														<?php echo get_times($default_start_time,$interval); ?>
														
																

															
														</select>
												  </div>

												  <label class="col-md-2 control-label">Select End Time</label>
												  <div class="col-md-3">
													<select name="end_time" class="form-control">
															<?php echo get_times($default_end_time,$interval); ?>
													</select>
												  </div>

												</div>

												

												<div class="form-group">
												  <label class="col-md-2 control-label">Is Cur Day</label>
												  <div class="col-md-3">
													<div class="radio">
														<label>
															<input type="radio" name="is_curday" id="is_curday1" value="y" <?php if (@$is_curday=='y') echo 'checked';?>>
															Yes
														</label>
													  <label>
														<input type="radio" name="is_curday" id="is_curday2" value="n"  <?php if (@$is_curday=='n') echo 'checked';?>>
														No
													  </label>
													</div>
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
												 
												  
													
												  <div class="col-md-1"></div>
												
												 <div class="col-md-3">
														<input type="submit" class="btn btn-success" value="<?php echo $btnVal; ?>" name="time_slots">
												   </div>

													
												</div>
												
												  
												<div class="form-group">
												  
												</div>
											</form>
									  </div>
									</div>
									<?php
									   $order = " slot_id ";
										$where="";
										$results=$connection->get_data("delivery_timings","slot_id,start_time,end_time,is_curday,status",$where,$order);
									?>
									<div class="widget-content">
										<div class="table-responsive"  id="myrecords">
											<table class="table table-bordered " id="myTable">
												<thead>
													<tr>
													 <th class="decending ascending">Slot Id</th>
													  <th class="decending ascending">Start Time</th>
													  <th>End Time</th>
													  <th>Current Day</th>
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
														echo '<tr><td>'.$usrinfo['slot_id'].'</td><td>'.$usrinfo['start_time'].'</td><td>'.$usrinfo['end_time'].'</td><td>'.$usrinfo['is_curday'].'</td><td>'.$usrinfo['status'].'</td><td><a href="delivery_timings.php?slot_id='.$usrinfo['slot_id'].'" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i></a></td></tr>';
														
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