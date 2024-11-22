<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	 include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$order_date_from		 =$_GET['order_date'];
	$order_date_to		 =$_GET['order_date_to'];
	$flag = false;
	if(strtotime($order_date_from)<=strtotime($order_date_to))
	{
		$flag = true;
	}
	else
	{
		$flag = false;
	}
	
	
	
	
	
		$order_date_val = explode("-",$order_date_from);
		$day			= $order_date_val[0];
		$month		= $order_date_val[1];
		$year			= $order_date_val[2];
		$order_date_from = $year.'-'.$month.'-'.$day;


		$order_date_to_val	= explode("-",$order_date_to);
		$day							= $order_date_to_val[0];
		$month						= $order_date_to_val[1];
		$year							= $order_date_to_val[2];
		$order_date_to			= $year.'-'.$month.'-'.$day;


?>

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
			if(strlen(trim($order_date_from)) > 0 &&strlen(trim($order_date_to)) )
			{
				if($flag == true)
				{
					$AllOrders=$connection->getAll_history_Orders($order_date_from,$order_date_to);
					$numItem     = count($AllOrders);
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
							$payment_type=ucwords($AllOrders[$i]['payment_type']);

						echo '<td>'.$payment_type.'</td>';



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
			}
			else
				{
					echo '<tr><td colspan="9" align="center"><b style="color:red">To Date should be Equal or Greater than From Date</b></td></tr>';

				}
		}
		else
		{
			echo '<tr><td colspan="9" align="center"><b style="color:red">No orders found</b></td></tr>';
		}
?>

	</tbody>
</table>