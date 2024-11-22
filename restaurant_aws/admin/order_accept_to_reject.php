<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	
	if($_SESSION['user_type'] == 'admin')
	{
		include ('../db_connect.php');
		$connection			= new createConnection(); //i created a new object
		$order_id				=$_POST['order_id'];
		$order_time		=$_POST['order_time'];
		$email_id				=$_POST['email_id'];
		$delivery_day		=$_POST['delivery_day'];
		$delivery_time	=$_POST['delivery_time'];

		if(trim(strlen($order_id) > 0))
		{
			$get_date = $connection->get_date();

			$get_date_val = explode(" ",$get_date);
			$order_accept_date_time = $get_date_val[0]." ".$order_time;

			$rows = array('reject_to_accept'=>'y', 'reject_to_accept_date' =>$get_date, 'order_status' => 'ORPSA','order_delivery_date'=>$order_accept_date_time);
			$where = " orderid = '$order_id' and order_status = 'ORPSR'";
			$connection->update_data('order_master',$rows,$where);
			if($connection)
			{
				echo 'Order reaccepted~success';
			}	
			else
				echo 'Order can not reaccepted~error';
		}
		else
			echo 'Order can not reaccepted~error';
	}
	else
		header("Location:logout.php");
?>