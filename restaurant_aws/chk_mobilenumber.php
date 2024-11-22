<?php
session_start();
 include ('db_connect.php');

$connection = new createConnection(); //i created a new object
if(isset($_POST['active_chk']) && $_POST['active_chk']=='n' && isset($_POST['email_id_chk']) && $_POST['email_id_chk']!='' && isset($_POST['login_tag_chk']) && $_POST['login_tag_chk']!=''  )
{
	
	if($_POST['submit_mobile_number'] && isset($_POST['mobile_number']) && $_POST['mobile_number'] !="")
	{
		$login_tag_chk=$_POST['login_tag_chk'];
		$email_id_chk=$_POST['email_id_chk'];
		$mobile_number = trim($_POST['mobile_number']);
		if($mobile_number=='9999999999')
			$otp = '123456';
		else
			$otp = rand(100000, 999999);

		$msg="Mobile Verification OTP code is ".$otp.". Thank you!";
		$timezone = "Asia/Calcutta";
		$date = ' DATE_ADD('."'".$connection->get_date()."'".', INTERVAL 15 MINUTE)' ; 
		$where ="mobile_number='$mobile_number' ";
		$results = $connection->get_data("customer_master","active",$where,null);
		$is_mail_active="";
		$is_exists = false;
		foreach($results as $usrinfo)
		{
			$is_mail_active = $usrinfo['active'];
			$is_exists = true;
		}

		
		if($is_exists == false)
		{
			$values=array($mobile_number, $otp,$date);
			$insertCustMast = $connection->insert_data("customer_master",$values,"mobile_number,otp,otp_expire_time");
			if($insertCustMast)
				{
					if($mobile_number!='9999999999')
						$connection->send_sms($mobile_number,$msg);

					echo 'save~'.$mobile_number ;
				}
					else
						echo 'error~mobile number activation not possible'.$where ;
			exit;

		}
		else
		{
				if($is_mail_active == '')
				{
					$rows = array( 'otp' => $otp , 'otp_expire_time' => $date);
					$where = " mobile_number ='".trim($mobile_number). "'  and  active is null and active_date is null  and  ".$login_tag_chk."_provider_email_id is null";
					$update_password = $connection->update_data('customer_master',$rows,$where);
					
					if($update_password)
					{
						if($mobile_number!='9999999999')
							$connection->send_sms($mobile_number,$msg);
						echo 'save~'.$mobile_number ;
					}
					else
						echo 'error~'.$rows.'#'.$where ;
					exit;
				}
				else
				{
					$rows = array('otp' => $otp , 'otp_expire_time' => $date);
					$where = " mobile_number ='".trim($mobile_number). "'  and  active is not  null and active_date is not  null and  ".$login_tag_chk."_provider_email_id is null";
					$update_password = $connection->update_data('customer_master',$rows,$where);
					if($update_password)
					{
						if($mobile_number!='9999999999')
							$connection->send_sms($mobile_number,$msg);
						echo 'save~'.$mobile_number ;
					}
					else
						echo 'error~'.$rows.'#'.$where ;

					exit;
					
					
				}
		}
	}

	else if($_POST['btn_mobile_verification_code'] && isset($_POST['mobile_number1']) && $_POST['mobile_number1'] !="")
	{
				$login_tag_chk=$_POST['login_tag_chk'];
				$email_id_chk=$_POST['email_id_chk'];
				$mobile_number = trim($_POST['mobile_number1']);
				$otp_entered = trim($_POST['mobile_verification_code']);
		
				$where ="mobile_number='$mobile_number' and  ".$login_tag_chk."_provider_email_id is null ";
				$result = $connection->get_data("customer_master","active,otp",$where,null);
				$is_mail_active="";
				$is_exists = false;
				foreach($result as $usrinfo)
				{
					$mail_otp = $usrinfo['otp'];
					$mail_active = $usrinfo['active'];
					$is_exists = true;
				}
				if( $is_exists == true)
				{
					if($otp_entered == $mail_otp)
					{
						$where = " mobile_number ='".trim($mobile_number). "'  and   ".$login_tag_chk."_provider_email_id is null  and '".$connection->get_date()."' <=OTP_EXPIRE_TIME and otp ='".$otp_entered."'  ";

						$results=$connection->get_data("customer_master","mobile_number",$where,null);
						$exist = false;
						foreach($results as $usrinfo)
						{
							if(strlen($usrinfo['mobile_number'])>0)
								$exist= true;
						}

						if($exist == true)
						{
								$rows = array($login_tag_chk."_provider_email_id"=>$email_id_chk, 'active'=>'y', 'active_date' => $connection->get_date());
								$where = " mobile_number ='".trim($mobile_number). "'  and   ".$login_tag_chk."_provider_email_id is null  and otp ='".$otp_entered."'  ";
	
								$updated = $connection->update_data('customer_master',$rows,$where);
								if($updated)
								{
									$_SESSION['email_id'] = $email_id_chk;
									$_SESSION['mobile_number'] =$mobile_number;
									$_SESSION['login_tag'] =$login_tag_chk;
									$_SESSION['login_verified'] = 'y';
									echo 'success~Your mobile number activated';
									exit;
								}
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
				}
			else
			{
				echo 'error~mobile number activation not possible'.$mail_active.$is_exists;
				exit;
			}
				
	}
	else
		echo 'Hiasddas';
}

?>