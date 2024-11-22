<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	 include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$order_id			=$_POST['order_id'];
	$reason	=$_POST['reason'];
	if(trim(strlen($order_id) > 0) && trim(strlen($reason) > 0))
	{
		$get_date = $connection->get_date();
		$rows = array('order_accept_reject_date'=>$get_date, 'order_status' => 'ORPSR','operator_id'=>$_SESSION['user_id'],'order_cancel_reason'=>$reason);
		$where = " orderid = '$order_id' ";
		$connection->update_data('order_master',$rows,$where);
		if($connection)
			echo 'Order Rejected~success';
		else
			echo 'Order can not be processed~error';
	}
	else
		echo 'Order can not be processed~error';

?>