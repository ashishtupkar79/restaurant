<?php
    session_start();
	require_once ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$OpOrders=$connection->getOpOrders();
	$numItem     = count($OpOrders);

	$count_pending_orders=0;
	$count_rejected_orders=0;
	$count_accepted_orders=0;
	$count_completed_orders=0;

	//if(!isset($_SESSION['count_pending_orders']) || $_SESSION['count_pending_orders']=='')
		//$_SESSION['count_pending_orders']=0;

	for ($i = 0; $i < $numItem; $i++) 
	{
		if($OpOrders[$i]['order_status'] == 'ORPS')
		{
			$count_pending_orders = $count_pending_orders +1;
		}
		else if($OpOrders[$i]['order_status'] == 'ORPSA')
		{
			$count_accepted_orders = $count_accepted_orders +1;
		}
		else if($OpOrders[$i]['order_status'] == 'ORPSR')
		{
			$count_rejected_orders = $count_rejected_orders +1;
		}

		else if($OpOrders[$i]['order_status'] == 'ORPSC')
		{
			$count_completed_orders = $count_completed_orders +1;
		}
	}
	$beep =false;
	/*if($_SESSION['count_pending_orders'] != $count_pending_orders)
	{
		$_SESSION['count_pending_orders'] = $count_pending_orders;
		$beep =true;
	}*/
	if($count_pending_orders > 0)
		$beep =true;

?>
<div class="slide-box" id="slide-box" style="min-height:100px;">
	<div class="slide-box-head bred">
		<div class="pull-left">Order Status</div>          
		  <div class="slide-icons pull-right">
				<a href="#" class="sminimize"><i class="fa fa-chevron-down"></i></a> 
				<!-- <a href="#" class="sclose"><i class="fa fa-times"></i></a> -->
		  </div>
		  <div class="clearfix"></div>
      </div>

  	 <div class="slide-content" style="min-height:100px;">
		<div class="tab-content">
			  <div class="tab-pane active" id="tab1">
					<!-- Earning item -->
						<div class="slide-data">
							<div class="slide-data-text"><a href="orders.php" style="color: #fff;float: left;font-size: 13px;font-weight: 600;">Pending </a></div>
							<div class="slide-data-result"><?php echo $count_pending_orders; ?> <!-- <i class="fa fa-arrow-up red"></i> --> </div>
							<div class="clearfix"></div>
						</div>

						<!-- Earning item -->
						<div class="slide-data">
						  <div class="slide-data-text">Accepted </div>
						  <div class="slide-data-result"><?php echo $count_accepted_orders; ?> <!-- <i class="fa fa-arrow-down green"></i>  --></div>
						  <div class="clearfix"></div>
						</div>     

						<!-- Earning item -->
						<div class="slide-data">
						  <div class="slide-data-text">Rejected </div>
						  <div class="slide-data-result"><?php echo $count_rejected_orders; ?> <!-- <i class="fa fa-arrow-up red"></i> --> </div>
						  <div class="clearfix"></div>
						</div> 

						<div class="slide-data">
						  <div class="slide-data-text">Completed </div>
						  <div class="slide-data-result"><?php echo $count_completed_orders ; ?> <!-- <i class="fa fa-arrow-up red"></i> --> </div>
						  <div class="clearfix"></div>
						</div> 

				</div>
			</div>
		</div>
	</div>

	<?php
		if($beep)
		{
		?>
		<script type="text/javascript">
			if(/iPhone|iPad/i.test(navigator.userAgent)) 
				var snd = new Audio("batman_theme_x.ogg"); // buffers automatically when created
			else
				var snd = new Audio("batman_theme_x.wav"); // buffers automatically when created
			snd.play();
		</script>
	<?php
		}
	?>

	