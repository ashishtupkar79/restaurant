<?php 
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$from_date="";
	$AllOrders=$connection->getAllOrders($from_date);
	$numItem     = count($AllOrders);
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
		
		<!-- Date picker -->
		<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
		
		<!-- Favicon -->
		<link rel="shortcut icon" href="#">

		<style type="text/css">
			.results tr[visible='false'],
			.no-result
			{
				display:none;
			}
			.results tr[visible='true']{
				display:table-row;
			}

			.counter
			{
				padding:8px; 
				color:#ccc;
			}
</style>

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
				<!-- <div class="page-head">
					 
					  <h2 class="pull-left"><input type="text" class="search form-control" placeholder="What you looking for?"></h2> 
					   <div class="clearfix"></div>
				</div> -->

				
				<!-- Page heading ends -->



				<!-- Matter -->



						

						

			<div class="matter">
					<div class="container">
								
						<div class="row">

						



							<div class="col-md-3">
								<!-- <h5>From Date</h5> -->
								  
										
										<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="Select order date from" id="picker">&nbsp;
										<!-- <span class="add-on">&nbsp;<i data-date-icon="fa fa-calendar"></i></span> -->

									
								  
							</div>
										

						<div class="col-md-3">
							<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="Select order date to" id="picker2" required="">

							<!-- <span class="glyphicon glyphicon-calendar"></span> -->
							&nbsp;
							
						</div>

									<div class="col-md-2">
											<a class="btn btn-info"  onClick="history_records()">Search</a>
									</div>

									<div class="col-md-3">
											<input type="text" class="search form-control" placeholder="Filter Records" id="filter">
									</div>
						</div>


						<div class="row">
							<div class="col-md-12">
								
								<!-- <div id="datetimepicker1" class="input-append">
									<input data-format="dd-MM-yyyy" class="picker" type="text" placeholder="Select order date from" id="picker" required="">
									<span class="add-on">&nbsp;<i data-date-icon="fa fa-calendar"></i></span>&nbsp;&nbsp;<a class="btn btn-info"  onClick="history_records()">Display Records</a>
								</div> -->
								
								

								<div class="widget wviolet">
									<div class="widget-head">


										<div class="pull-left" id="pull-left">Order Status  </div>
										
										<div class="widget-icons pull-right">
											<a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> 
											<a href="#" class="wclose"><i class="fa fa-times"></i></a>
										</div>
										<div class="clearfix"></div>
									</div>

									
									<div class="widget-content">
										<div class="table-responsive" id="myrecords">
											<table class="table table-bordered results tablesorter" id="myTable">
												<thead>
													<tr>
													  <th>#</th>
													  <th class="decending ascending">Order Id</th>
													  <th class="decending ascending">Mobile No.</th>
													  <th class="decending ascending">Email</th>
													  <th class="decending ascending">Name</th>
													  <th class="decending ascending">Payment Type</th>
													  <th class="decending ascending">Amount</th>
													  <th class="decending ascending">Order Date</th>
													  <th class="decending ascending">Order Status</th>
													  <th>Order Details</th>
													</tr>
												</thead>
		
												<tbody>
												<?php
													$count_pending_orders=0;
													$count_rejected_orders=0;
													$count_accepted_orders=0;
													for ($i = 0; $i < $numItem; $i++) 
													{

														$free_meal = $AllOrders[$i]['free_meal'];
														if($free_meal == 'y')
															$free_meal='&nbsp;<b style="color:red">Free Meal</b>';
														else
															$free_meal="";

														echo '<tr>';
															echo '<td>'.($i+1).'</td>';
															echo '<td>'.$AllOrders[$i]['orderid'].'<br>'.$free_meal.'</td>';
															echo '<td>'.$AllOrders[$i]['mobileno'].'</td>';
															echo '<td>'.$AllOrders[$i]['email_id'].'</td>';
															echo '<td>'.$AllOrders[$i]['name'].'</td>';

															$payment_type="";
															if($AllOrders[$i]['payment_type'] == 'cod')
																$payment_type ='Cash on Delivery';
															else if($AllOrders[$i]['payment_type'] == 'online')
																$payment_type ='Online';
															else
																$payment_type =$AllOrders[$i]['payment_type'];		
															echo '<td>'.ucwords($payment_type).'</td>';



															echo '<td>'.$AllOrders[$i]['order_amt_payable'].'</td>';
															//echo '<td>'.$AllOrders[$i]['order_verify_date'].'</td>';

															$order_entry_date = $AllOrders[$i]['order_entry_date'];
															$order_verify_date=$AllOrders[$i]['order_verify_date'];
															if(strlen($order_verify_date) <=0 || $order_verify_date  == null)
																$order_verify_date=$order_entry_date;

															echo '<td>'.date('d-m-Y h:i A',strtotime($order_verify_date)).'</td>';

															if($AllOrders[$i]['order_status'] == 'ORP')
															{
																$order_status='Payment type not Selected';
																$class='class="btn btn-warning"';
																$count_pending_orders = $count_pending_orders +1;
															}

															if($AllOrders[$i]['order_status'] == 'ORPOPG')
															{
																$order_status='Online Payment Pending / Cancel';
																$class='class="btn btn-warning"';
																$count_pending_orders = $count_pending_orders +1;
															}

															if($AllOrders[$i]['order_status'] == 'ORPF')
															{
																$order_status='Online Transaction Failed';
																$class='class="btn btn-warning"';
																$count_pending_orders = $count_pending_orders +1;
															}

															if($AllOrders[$i]['order_status'] == 'ORPOTP')
															{
																$order_status='OTP Verification Pending';
																$class='class="btn btn-warning"';
																$count_pending_orders = $count_pending_orders +1;
															}

															else if($AllOrders[$i]['order_status'] == 'ORPS')
															{
																$order_status='Pending';
																$class='class="btn btn-primary"';
																$count_pending_orders = $count_pending_orders +1;
															}
															else if($AllOrders[$i]['order_status'] == 'ORPSA')
															{
																$order_status='Accepted';
																$class='class="btn btn-info"';
																$count_accepted_orders = $count_accepted_orders +1;
															}
															else if($AllOrders[$i]['order_status'] == 'ORPSR')
															{
																$order_status='Rejected';
																$class='class="btn btn-danger"';
																$count_rejected_orders = $count_rejected_orders +1;
															}
															else if($AllOrders[$i]['order_status'] == 'ORPSC')
															{
																$order_status='Completed';
																$class='class="btn btn-success"';
																$count_rejected_orders = $count_rejected_orders +1;
															}
															echo '<td><span '.$class.'>'.$order_status.'</span></td>';
															echo '<td><a href="history_detail.php?order_id='.$AllOrders[$i]['orderid'].'&name='.urlencode($AllOrders[$i]['name']).' " class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a></td>';
															

															//echo '<td><a href="#" class="btn btn-sm btn-warning"><i class="fa fa-pencil"></i> </a></td>';
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

		<!-- <script type="text/javascript">
			var auto_refresh = setInterval(
			function ()
			{
					$('#slide-box1').load('notifications.php').fadeIn("slow");
			}, 10000); // refresh every 10000 milliseconds
			</script> -->

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

		<!-- Date picker -->
		<script src="js/bootstrap-datetimepicker.min.js"></script> 
		<!-- Bootstrap Toggle -->
		<script src="js/bootstrap-switch.min.js"></script> 

		<!-- Respond JS for IE8 -->
		<script src="js/respond.min.js"></script>
		<!-- HTML5 Support for IE -->
		<script src="js/html5shiv.js"></script>
		<!-- Custom JS -->
		<script src="js/custom.js"></script>
	</body>	
</html>

	<script src="js/jquery.tablesorter.js"></script>

		<script type="text/javascript">
		
		$(document).ready(function()
		{
			$("#myTable").tablesorter();
		}
		);
		
		</script>

<script type="text/javascript">
$(document).ready(function() {
  $(".search").keyup(function () {
    var searchTerm = $(".search").val();
    var listItem = $('.results tbody').children('tr');
    var searchSplit = searchTerm.replace(/ /g, "'):containsi('")
    
  $.extend($.expr[':'], {'containsi': function(elem, i, match, array){
        return (elem.textContent || elem.innerText || '').toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
  });
    
  $(".results tbody tr").not(":containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','false');
  });

  $(".results tbody tr:containsi('" + searchSplit + "')").each(function(e){
    $(this).attr('visible','true');
  });

 // var jobCount = $('.results tbody tr[visible="true"]').length;
    //$('.counter').text(jobCount + ' item');

  if(jobCount == '0') {$('.no-result').show();}
    else {$('.no-result').hide();}
		  });
});
</script>


<script>
			/* Bootstrap Switch */
			//$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
			/* Date picker */

			
		
			$(document).ready(function(){ 

				var today = new Date(); 
				$('#picker').datepicker({ 
					dateFormat: 'dd-mm-yy', 
					autoclose: true, 
						startDate: today 
						}); 

				$('#picker2').datepicker({ 
					dateFormat: 'dd-mm-yy', 
					autoclose: true, 
						startDate: today 
						}); 


					});
			
			/* *************************************** */
</script>

<script>
			/* Bootstrap Switch */
			$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
			/* Date picker */
			$(function() {
				$('#datetimepicker1').datetimepicker({
				  pickTime: false
				});
			});
			$(function() {
				$('#datetimepicker2').datetimepicker({
				  pickDate: false
				});
			});
</script>

<script>
			/* Bootstrap Switch */
			//$(".make-switch input").bootstrapSwitch();
			
			/* *************************************** */
			
		
			
			
			/* *************************************** */
</script>

<script type="text/javascript">
function history_records()
	{
		try
		{
			//alert(document.getElementById("picker").value);
			var order_date_from = document.getElementById("picker").value;
			var order_date_to = document.getElementById("picker2").value;


			if(order_date_from=="" || order_date_to=="")
			{
				alert("Please select both date");
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
					document.getElementById("pull-left").innerHTML = " Oder Status From " + order_date_from + " To " + order_date_to;
					document.getElementById("filter").value = "";
					document.getElementById("myrecords").innerHTML = response;
				}
			}
			xmlhttp.open("GET", "order_history_datewise.php?order_date="+order_date_from+"&order_date_to="+order_date_to,true);
			xmlhttp.send();
	}
	catch (ex)
	{
		alert(ex);
	}
}
</script>



   
    