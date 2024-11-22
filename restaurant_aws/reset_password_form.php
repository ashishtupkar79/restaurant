<?php
 session_start();
 include ('db_connect.php');
 $connection = new createConnection(); //i created a new object
 $email = $_POST['reg_email_id_reset'];
 $ses_id = $_POST['ses_id'];
 $password = $_POST['reg_password1a'];

if($email =="" ||  $password =="" || $ses_id =="" || trim($_POST['reg_password2a']) =="")
{
	echo 'Error~error';
	exit;
}

$type="success";
if(trim($password) !=trim($_POST['reg_password2a']))
{
	$msg='Passwords for '.$email.' do not match';
	$type="error";
}

if($type=="success" && isset($_POST['reg_email_id_reset']) && $_POST['reg_email_id_reset'] != '' && isset($_POST['ses_id']) && $_POST['ses_id'] != '' )
	{
		$where = " session_id = '$ses_id' and email_id='$email' and active ='y' ";
	    $results=$connection->get_data("customer_master","email_id,session_id,active",$where,null);
		$bool = false;
	   	foreach($results as $usrinfo)
		{
			if($usrinfo['session_id'] ==$ses_id)
				$bool= true;
		}
		
		if($type=="success" && $bool && $usrinfo['active'] =='y')
		{
			$password_enc = $connection->enc_data($password);
			$rows = array('password' => $password_enc);
			$where = " session_id = '$ses_id' and email_id='$email' and active='y' ";
			if( $connection->update_data('customer_master',$rows,$where))
			{
				$msg="New Password Changed Successfully.";
			}
			else
			{
				$msg= $email.' Password Changing not Possible.';
			}
		}
		else
		{
			$msg= $email.' Password Changing not Possible.';
		}
	}

	echo $msg;
?>
	