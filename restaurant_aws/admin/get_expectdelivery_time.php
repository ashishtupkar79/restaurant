<?php
	 $delivery_day		=$_GET['delivery_day'];
	 $delivery_time	=$_GET['delivery_time'];
	 $order_time	=$_GET['order_time'];
	 echo $order_accept_date_time  = date('d-m-Y h:i a',strtotime('+ '.$order_time.' minutes',strtotime($delivery_day." ".$_GET['delivery_time'])));
?>