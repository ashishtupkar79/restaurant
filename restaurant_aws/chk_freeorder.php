<?php
session_start();
 include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	$current_order_number=0;
if(isset($_SESSION['email_id']) && isset($_SESSION['mobile_number']))
{
	$Order_Number=$connection->getTenthOrderNumber($_SESSION['mobile_number']);
	$current_order_number= $Order_Number[0]['orderid'];
	if(($current_order_number % ($connection->get_order_settings('offer_free_meal_order')) ==0)
	{
		echo 'success';
	}
}

?>