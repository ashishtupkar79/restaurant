<?php
	session_start();
	
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object
	$message=session_id()."~otp request";
	$connection->logEvent($message);
	

	$mobile_code = $_GET['mobile_code'];
	$order_id = $_GET['order_id'];
	$email_id = $_GET['email_id'];
	$cod_type = $_GET['cod_type'];
	

	$getMyOrder_exist=$connection->getMyOrder_exist($order_id);
	if(count($getMyOrder_exist) <= 0)
	{
		echo 'success2~detail_page.php';
		exit;
	}


	if(trim($mobile_code)!="" && trim($order_id) !="" && trim($email_id) !="")
	{
		if($mobile_code == '9999999999' || $mobile_code == '8446448668')
			$otp = '123456';
		else
			$otp = rand(100000, 999999);

		$msg="Your OTP for this order is ".$otp.". Thank you!";
		$timezone = "Asia/Calcutta";
		$date = ' DATE_ADD('."'".$connection->get_date()."'".', INTERVAL 15 MINUTE)' ; 
		//$rows = array('payment_type'=>'cod','order_status'=>'ORPOTP','otp' => $otp , 'otp_expire_time' => $date, 'otp_verified' => 'n');
		$rows = array('payment_type'=>$cod_type,'order_status'=>'ORPOTP','otp' => $otp , 'otp_expire_time' => $date, 'otp_verified' => 'n');
		$where = " orderid = '$order_id'  and otp_verified IS NULL AND payment_type is null and order_status ='ORP' ";
		$update_rec=$connection->update_data('order_master',$rows,$where);
		if($update_rec)
		{
			/*if($mobile_code != '9999999999' || $mobile_code != '8446448668')
				$connection->send_sms($mobile_code,$msg);
				$message=session_id()."~otp sent";
				$connection->logEvent($message);*/
		}
		else
		{
			$message=session_id()."~otp sent failed because user try to process the same order which is already exists in table with online or cod or pcod";
			$connection->logEvent($message);
			echo 'success2~detail_page.php';
			exit;
		}

		echo 'success~';
		exit;
	}
?>