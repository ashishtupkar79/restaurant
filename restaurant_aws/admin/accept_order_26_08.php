<?php
	session_start();
	if(!isset($_SESSION['user_id']))
		header("Location:logout.php");

	include ('../db_connect.php');
	$connection = new createConnection(); //i created a new object
	$order_id				=trim($_POST['order_id']);

	$order_time		=trim($_POST['order_time']);
	/*$order_time		= date("H:i", strtotime($order_time));*/

	$email_id				=$_POST['email_id'];
	$delivery_day		=$_POST['delivery_day'];
	$delivery_time	=$_POST['delivery_time'];
	

	/*$order_date_val	=explode("~",$_POST['order_date']);
	$order_date = $order_date_val[1];*/
	//$order_date		= date("Y-m-d", strtotime($order_date));

	$mobile_code			=$_POST['mobile_no'];

	//$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($_POST['delivery_time'])));
	//$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($order_date." ".$_POST['delivery_time'])));

	$order_accept_date_time  = date('Y-m-d H:i',strtotime('+ '.$order_time.' minutes',strtotime($delivery_day." ".$_POST['delivery_time'])));

	if(strlen($order_id) > 0  && strlen($order_time) > 0)
	{
		$get_date = $connection->get_date();
		//$order_accept_date_time = $order_date." ".$order_time;
		
		$rows = array('order_accept_reject_date'=>$get_date, 'order_status' => 'ORPSA','operator_id'=>$_SESSION['user_id'],'order_delivery_date'=>$order_accept_date_time);
		$where = " orderid = '$order_id' ";
		$connection->update_data('order_master',$rows,$where);
		if($connection)
		{
			$exp_date = date('d-m-Y',strtotime($order_accept_date_time));
			$exp_time = date('g:i a',strtotime($order_accept_date_time));
			/* confirmation mail */
			$image = "http://zaikart.com/img/zaikart_logo.png";
			$body="";
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
					$protocol = 'https://';
				else
					$protocol = 'http://';

			$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
			$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
			$body.='<div  style="background: #fff none repeat scroll 0 0;border: 5px solid #ededed;border-radius: 3px;margin-bottom: 10px;padding: 2px;text-align:center"><h2 style="background-color: #78cfcf;border-top-left-radius: 3px;border-top-right-radius: 3px;color: #fff;font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;font-size: 22pxpx;font-weight: 600;margin: -25px -25px 25px;padding: 12px 15px;">Thank you! Your order was placed at</h2><div id="confirm"><h3></h3><p><img src="'.$img_src.'" width="252" height="218"/></p><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Number: <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$order_id.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Time requested for : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$delivery_day.' - '.$delivery_time.'</b></h3><h3 style="color: #5d5d5d;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">Order Scheduled Time : <b style="color: #78CFCF;font-size: 24px;margin-bottom: 10px;margin-top: 20px;font-family: inherit;font-weight: 500;line-height: 1.1;">'.$exp_date.' - '.$exp_time.'</b></h3><hr style=" -moz-border-bottom-colors: none;-moz-border-left-colors: none;-moz-border-right-colors: none;-moz-border-top-colors: none;border-color: #eee moz-use-text-color -moz-use-text-color;border-image: none;border-style: solid none none;border-width: 1px 0 0;margin-bottom: 10px;margin-top: 10px;"><h4 align="center">This order will be delivered directly by</h4>	<h4 align="center"><b>Zaikart</b></h4><h4 align="center"><b>to Plot no 30 , Bajaj Nagar 440013</b></h4><h3 style="color: #78CFCF;font-size: 24px;font-family: inherit;font-weight: 500;line-height: 1.1;"><b>For any changes, please contact the restaurant directly on:</b></h3>	<h3><b>+91 7378845457, 7378845458</b></h3><h4 align="center"><i>Please note: if you are paying by credit card, the description on your statement will appear as Zaikart PVT LTD Nagpur.</i></h4></div></div>';
					
			$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
			$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
			$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
			$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
			$body .="<br> &#169; Zaikart 2016. All rights reserved";
					
			$from="noreply@zaikart.com";
			$to= $email_id;
			$subject = "Zaikart Order Confirmation";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers  .= "From: $from\r\n"; 
			mail($to,$subject,$body,$headers);
			/* confirmation mail script ends here*/


			/* send sms*/

			$exp_date = date('d-m-Y',strtotime($order_accept_date_time));
			$exp_time = date('g:i a',strtotime($order_accept_date_time));
			$msg="Your order is confirmed. Expected delivery time is $exp_time. If any issues call 7387423888. Thank you for ordering with Zaikart :)";
			$connection->send_sms($mobile_code,$msg);

			/* send sms*/


			echo 'Order accept~success';
		}	
		else
			echo 'Database Connection droped. Please refresh the page~error';
	}
	else
			echo 'Database Connection droped2. Please refresh the page~error';

?>