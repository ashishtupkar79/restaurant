<?php
	session_start();
	if((!isset($_SESSION['email_id']) && !isset($_SESSION['mobile_number'])) || (!isset($_SESSION['email_id']) && !isset($_SESSION['login_tag'])))
		header("Location:logout.php");
	

	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	$sid = session_id();

	

	
	if (isset($_GET['orderid']) && $_GET['orderid'] !="") 
		 $orderid = $_GET['orderid'];
	else
		header('Location: index.php');
	
	
	$ReOrder=$connection->ReOrder($orderid);
	$numItem = count($ReOrder);

	$sid = session_id();
	

	$where = " ct_session_id = '$sid' ";
	$results=$connection->delete_data("cart",$where);
	

	if($numItem > 0)
	{
		for ($i = 0; $i < $numItem; $i++) 
		{
			$ct_qty			= $ReOrder[$i]['qty'];
			$productId		= $ReOrder[$i]['productid'];
			$status			= $ReOrder[$i]['status'];
			if($status == 'y')
			{
				$values=array($productId,$ct_qty,$sid,$connection->get_date());
				$connection->insert_data("cart",$values,"pd_id, ct_qty, ct_session_id, ct_date");
			}
		}
		header("Location:detail_page.php");
	}
	else
		header("Location:index.php");
?>