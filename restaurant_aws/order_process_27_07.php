<?php
	session_start();
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object
   $otp_entered = $_GET['mobile_code'];
   $amount= $_GET['amount'];
   $order_id = $_GET['order_id'];
   $mobile_no= $_GET['mobile_no'];
   $email_id = $_GET['email_id'];

	$getMyOrder_exist=$connection->getMyOrder_exist( $order_id);
	if(count($getMyOrder_exist) <= 0)
	{
		echo 'success2~detail_page.php';
		exit;
	}

	$where = " orderid ='".trim($order_id)."'";
	$results=$connection->get_data("order_master","otp",$where,null);
	foreach($results as $usrinfo)
	{
		 $otp_selected = $usrinfo['otp'];
	}
	if($otp_entered == $otp_selected)
	{
		$where = " orderid ='".trim($order_id). "' and '".$connection->get_date()."' <=OTP_EXPIRE_TIME and otp ='".$otp_entered."' and otp_verified = 'n' ";
		$results=$connection->get_data("order_master","orderid",$where,null);
		$exist = false;
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['orderid'])>0)
				$exist= true;
		}

		if($exist == true)
			{
				$rows = array('order_status'=>'ORPOTV', 'otp_verified' => 'y');
				$where = " orderid = '$order_id'  and otp_verified ='n' and otp ='$otp_entered' ";
				$connection->update_data('order_master',$rows,$where);
				$link="thanks_cod.php?order_id=".urlencode($order_id).'&amount='.urlencode($amount).'&mobile_no='.urlencode($mobile_no).'&email_id='.urlencode($email_id);
				echo 'success~'.$link;
				exit;
			}
		else
			{
				echo 'error~OTP Expired';
				exit;
			}
	}
	else
	{
		echo 'error~invalid OTP Entered';
		exit;
	}
?>