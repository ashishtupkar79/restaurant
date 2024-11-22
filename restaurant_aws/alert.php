<?php
session_start();
$where ="status='y'";
$results=$connection->get_data("orders_stop_log","message",$where,null);
foreach($results as $usrinfo)
{
	$message = $usrinfo['message'];
}
?>
<h3 id="pop_msg" style="font-family: Helvetica,Arial,sans-serif;text-align: center;pointer-events: auto;font-size: 20px;padding: 20px 20px;border-bottom: 1px solid #7BD3D5;border-top: 1px solid #7BD3D5;color:#ec008c"><img src="img/zaikart_logo.png" alt="" class="pop_img" height="100px;"><?php echo $message; ?></h3>