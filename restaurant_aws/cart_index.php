<?php
	session_start();
	date_default_timezone_set('Asia/Kolkata');
	function get_date()
	{
     date_default_timezone_set('Asia/Kolkata');
	 $date=date('Y-m-d H:i:s');
    return $date;
    }
	$sid = session_id();
	function addToCart()
	{
		if (isset($_GET['pdid']) && (int)$_GET['pdid'] > 0) 
			$productId = (int)$_GET['pdid'];
		else
			header('Location: index.php');
		include ('db_connect.php');
		$connection = new createConnection(); //i created a new object		
		$where = " m.item_id =d.item_id and m.status = 'y'  and d.status = 'Y' and d.qty_in_hand > 0  and d.detail_id=$productId ";
		$results=$connection->get_data("menu_items_master m , menu_items_master_details d","d.detail_id,  d.status, m.status , d.qty_in_hand, d.max_order_qty",$where,null);
		if(count($results) >0)
		{
			foreach($results as $usrinfo)
			{
				$max_order_qty = $usrinfo['max_order_qty'];
				if($usrinfo['qty_in_hand']<=0)
				{
					echo 'Out of Stock';
					exit;
				}
			}
		}
		// current session id
		$sid = session_id();
		$where = "  pd_id = $productId AND ct_session_id = '$sid' ";
		$sql_exe=$connection->get_data("cart","pd_id,ct_qty",$where,null);
		if(count($sql_exe) > 0)
		{
			foreach($sql_exe as $usrinfo)
			{
				if($usrinfo['ct_qty'] == $max_order_qty)
				{
					echo '<b style="color:red">Maximum Order Quantity Exceded</b>';
					exit;
				}
				else
				{
					$rows = array('ct_qty'=>($usrinfo['ct_qty'] + 1));
					$where = " ct_session_id = '$sid' AND pd_id = $productId ";
					$connection->update_data('cart',$rows,$where);
					echo 'Cart Updated';
				}
			}
		}
		else
		{
			$values=array($productId,'1',$sid,$connection->get_date());
			$OrdertMast=$connection->insert_data("cart",$values,"pd_id, ct_qty, ct_session_id, ct_date");
			echo 'Cart Updated';
		}
	}
	$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';
	switch ($action) 
	{
		case 'add' :
			addToCart();
			break;
		case 'view' :
	}
?>

		
			
				
	

	

		


	
	