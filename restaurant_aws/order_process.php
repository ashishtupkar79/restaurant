<?php
	session_start();
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object
	$cod_type = $_GET['cod_type'];
	$message=session_id()."~$cod_type order process started";
	$connection->logEvent($message);

	$otp_entered = $_GET['mobile_code'];
   $amount= $_GET['amount'];
   $order_id = $_GET['order_id'];
   $mobile_no= $_GET['mobile_no'];
   $email_id = $_GET['email_id'];
   $otp_required = $_GET['otp_required'];
   $bring_change = $_GET['bring_change_for'];
 

	$getMyOrder_exist=$connection->getMyOrder_exist($order_id);
	if(count($getMyOrder_exist) <= 0)
	{
		echo 'success2~detail_page.php';
		exit;
	}
	if($otp_required == 'y')
	{
			$where = " order_status = 'ORPOTP' and orderid ='".trim($order_id)."'";
			$results=$connection->get_data("order_master","otp",$where,null);
			foreach($results as $usrinfo)
			{
				 $otp_selected = $usrinfo['otp'];
			}
			if($otp_entered == $otp_selected)
			{
				$where = " orderid ='".trim($order_id). "' and '".$connection->get_date()."' <=OTP_EXPIRE_TIME and otp ='".$otp_entered."' and otp_verified = 'n' and  order_status = 'ORPOTP' ";
				$results=$connection->get_data("order_master","orderid",$where,null);
				$exist = false;
				foreach($results as $usrinfo)
				{
					if(strlen($usrinfo['orderid'])>0)
						$exist= true;
				}

				if($exist == true)
					{
						$rows = array('order_status'=>'ORPOTV', 'otp_verified' => 'y','bring_change_for'=>$bring_change);
						$where = " orderid = '$order_id'  and otp_verified ='n' and otp ='$otp_entered' and order_status = 'ORPOTP' ";
						$otp_verify =$connection->update_data('order_master',$rows,$where);
						$link="thanks_cod.php?order_id=".urlencode($order_id).'&amount='.urlencode($amount).'&mobile_no='.urlencode($mobile_no).'&email_id='.urlencode($email_id).'&cod='.urlencode($cod_type);
						$message=session_id()."~otp verified";
						$connection->logEvent($message);
						echo 'success~'.$link;
						exit;
						
					}
				else
					{
						echo 'error~OTP Expired';
						$message=session_id()."~otp expired";
						$connection->logEvent($message);

						exit;
					}
			}
			else
			{
				echo 'error~invalid OTP Entered';
				$message=session_id()."~invalid otp entered - ".$otp_entered;
				$connection->logEvent($message);
				exit;
			}
	}
	else
	{

		$rows = array('payment_type'=>$cod_type,'order_status'=>'ORPOTV', 'otp_verified' => 'y','otp'=>$_SESSION['login_tag'],'bring_change_for'=>$bring_change);
		$where = " orderid = '$order_id'  and otp_verified IS NULL AND payment_type is null and order_status ='ORP' ";
		$connection->update_data('order_master',$rows,$where);
		$link="thanks_cod.php?order_id=".urlencode($order_id).'&amount='.urlencode($amount).'&mobile_no='.urlencode($mobile_no).'&email_id='.urlencode($email_id).'&cod='.urlencode($cod_type);
		$message=session_id()."~registered user";
		$connection->logEvent($message);
		echo 'success~'.$link;
		exit;
	}
?>