<?php
   session_start();
   include ('db_connect.php');
	$connection = new createConnection(); //i created a new object

	

	$sid = session_id();
	$where = " ct_session_id = '$sid' ";
	$results=$connection->get_data("cart","count(*) as total_items",$where,null);
	foreach($results as $usrinfo)
	{
		echo $total_items ='<img src="img/food_24.png" style="margin-left:-85px;"><b style="font-size: 13px;color:#000"> ('.$usrinfo['total_items'] .')</b>';
	}
?>