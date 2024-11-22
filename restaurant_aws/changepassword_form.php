<?php
 
 session_start();
  
 include ('db_connect.php');
 $connection = new createConnection(); //i created a new object

$old_password = $_POST['old_password'];
$password = $_POST['new_password'];

if($old_password =="" ||  $password ==""  || trim($_POST['new_password2']) =="")
{
	echo 'Error~error';
	exit;
}
$email = $_SESSION['email_id'];
if(trim($password) !=trim($_POST['new_password2']))
{
	$msg='New passwords not match with re entered new password';
}
else
{
	if(isset($_SESSION['email_id']) && $_SESSION['email_id'] != '' )
	{
		$where = "  email_id='$email' and active='y' ";
		$results=$connection->get_data("customer_master","concat(fname, ' ', lname) AS name,email_id,password,active",$where,null);
		foreach($results as $usrinfo)
		{
			$password_dec = $connection->dec_data($password);
		}
		
		if($usrinfo['active'] =='y')
		{
			$table_old_password = $connection->dec_data($usrinfo['password']);
			if($table_old_password == $old_password)
			{
				$new_password = $connection->enc_data($password);
				$rows = array('password' => $new_password);
				$where = "email_id='$email' and password='".$usrinfo['password']."' and active='y'  ";
				$update =$connection->update_data('customer_master',$rows,$where);
				if($update)
				{
					$msg="Password Changed Successfully.";
				}
			}
			else
			{
				$msg= ' The current password entered is not valid.';
			}
		}
		else
		{
			$msg= $email.' Password Changing not Possible.';
		}
	}
}
echo $msg;
?>
	