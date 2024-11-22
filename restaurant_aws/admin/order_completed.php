<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	 include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$order_id		 =$_GET['order_id'];

	if(trim(strlen($order_id) > 0))
	{
		$get_date = $connection->get_date();
		$rows = array('order_complete_date'=>$get_date, 'order_status' => 'ORPSC');
		$where = " orderid = '$order_id' and order_status = 'ORPSA'";
		$connection->update_data('order_master',$rows,$where);
		if($connection)
		{
			echo 'Order complete~success';
		}	
		else
			echo 'Order can not completed~error';
	}
	else
		echo 'Order can not completed~error';

?>