<?php

require_once ('db_connect.php');
$connection = new createConnection();
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

if(isset($_GET['delivery_address']) && $_GET['delivery_address'] !="")
{
	$_SESSION['delivery_location'] = $_GET['delivery_address'];
}

	date_default_timezone_set('Asia/Kolkata');
	
	function get_date()
	{
     date_default_timezone_set('Asia/Kolkata');
	 $date=date('Y-m-d H:i:s');
    return $date;
    }

	$sid = session_id();
	if (isset($_GET['add_more_items']) && $_GET['add_more_items'] !="") 
		$add_more_items = $_GET['add_more_items'];
		
	if (isset($_GET['later_order']) && $_GET['later_order'] !="") 
		$_SESSION['later_order'] = $_GET['later_order'];

	if (isset($_GET['day']) && $_GET['day'] !="") 
		$_SESSION['day'] = $_GET['day'];

	if (isset($_GET['time']) && $_GET['time'] !="") 
		$_SESSION['time'] = $_GET['time'];

	

	$log_page_name = basename($_SERVER['PHP_SELF']);
	
	

	



	function addToCart($connection)
	{
		//global $connection;

		

		if (isset($_GET['pdid']) && (int)$_GET['pdid'] > 0) 
			$productId = (int)$_GET['pdid'];
		else
			header('Location: index.php');

		if (isset($_GET['pdid']) && (int)$_GET['pdid'] > 0 && !isset($_SESSION['later_order']) )
		{
			$time_slots=$connection->get_time_slots();
			for($i=0;$i<count($time_slots);$i++)
			{
				if($i>=(count($time_slots)-1))
					continue;

				$timeslots_val = explode('~',$time_slots[$i]);
				$from = $timeslots_val[0];
				$to = $timeslots_val[1];
				$timeslots_val = explode('~',$time_slots[$i+1]);
				$from2 = $timeslots_val[0];
				$to2 = $timeslots_val[1];
				$from_time= strtotime(date("h:i a", strtotime($to) - 1800));
				$to_time = strtotime(date("h:i a", strtotime($from2) - 1));
				if((strtotime(date("h.i a")) >= $from_time && strtotime(date("h.i a")) <= $to_time))
				{
					echo 'error';
					exit;
				}
			}

			


		}


		

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
					//echo 'Cart Updated';
				}
			}
		}
		else
		{
			$values=array($productId,'1',$sid,$connection->get_date());
			$OrdertMast=$connection->insert_data("cart",$values,"pd_id, ct_qty, ct_session_id, ct_date");
			//echo 'Cart Updated';
		}



	}


	
	function DeletCart($connection)
	{
			if (isset($_GET['pdid']) && (int)$_GET['pdid'] > 0) 
				$productId = (int)$_GET['pdid'];
			else
				header('Location: index.php');
			$sid = session_id();
			$where = "  ct_session_id='$sid' and pd_id = $productId";
			$sql_exe=$connection->get_data("cart","pd_id,ct_qty",$where,null);
			foreach($sql_exe as $usrinfo)
			{
				if($usrinfo['ct_qty'] =="1")
					$delete_data=$connection->delete_data('cart',$where);
				else
					{
						$rows = array('ct_qty'=>($usrinfo['ct_qty'] - 1));
						$where = " ct_session_id = '$sid' AND pd_id = $productId ";
						$connection->update_data('cart',$rows,$where);
					}
			}


			
			/*$sql = "select * from cart where ct_session_id='$sid' and pd_id = $productId";
			$sql_exe = mysql_query($sql);
			$row = mysql_fetch_array($sql_exe);
			$qty = $row['ct_qty'];
			if($qty == "1")
			{
				$sql ="delete from cart where ct_session_id='$sid' and  pd_id = $productId";
				$sql_exe = mysql_query($sql);
			}
			else
			{
				$sql = "UPDATE cart  SET ct_qty = ct_qty - 1 WHERE ct_session_id = '$sid' AND pd_id = $productId";		
				$result = mysql_query($sql);		
			}*/


	}


	$action = (isset($_GET['action']) && $_GET['action'] != '') ? $_GET['action'] : 'view';
	switch ($action) 
	{
		case 'add' :
			addToCart($connection);
			break;
		case 'update' :
			DeletCart($connection);
			
			break;
		case 'view' :
	}
	$address=$_SESSION['delivery_location'] ;
	$connection->get_cart($add_more_items,$address,$extra_charge);
?>

	