<?php
mysql_connect("192.9.5.34", "root", "root") or
    die("Could not connect: " . mysql_error());
	mysql_select_db("restaurant");
	//require 'cart_functions.php';
function addToCart()
{
	

	if (isset($_GET['pdid']) && (int)$_GET['pdid'] > 0) 
		$productId = (int)$_GET['pdid'];
	 else
		header('Location: index.php');
	
	 $sql = "select d.detail_id,  d.status, m.status , d.qty_in_hand, d.max_order_qty   from menu_items_master m , menu_items_master_details d
				where m.item_id =d.item_id and m.status = 'y'  and d.status = 'Y' and d.qty_in_hand > 0  and d.detail_id=$productId";
	$sql_exe = mysql_query($sql);
	
	echo 'Rows123 = '.$count_rows = mysql_num_rows($sql_exe);
	if($count_rows > 0)
	{
		$ow = mysql_fetch_row($sql_exe);
		$max_order_qty = $row['max_order_qty'];
		$qty_in_hand		= $row['qty_in_hand'];
		if($qty_in_hand <=0)
		{
			header('Location: index.php');
			exit;
		}
	}
	else
	{
		header('Location: index.php');
		exit;
	}


	// current session id
	$sid = session_id();
	$sql = "SELECT pd_id,ct_qty  FROM cart WHERE pd_id = $productId AND ct_session_id = '$sid'";
	$sql_exe = mysql_query($sql);
	$count_rows = mysql_num_rows($result);
	if($count_rows > 0)
	{
		$row = mysql_fetch_row($sql_exe);
		$ct_qty = $row['ct_qty'];
		if($ct_qty == $max_order_qty)
		{
			echo ' Maximum Order Quantity Exceded';
			exit;
		}
		else
		{
			$sql = "UPDATE cart  SET ct_qty = ct_qty + 1 WHERE ct_session_id = '$sid' AND pd_id = $productId";		
			$result = mysql_query($sql);		
		}
	}
}
?>