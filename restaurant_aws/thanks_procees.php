<?php
	session_start();
	$sid = session_id();
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	

	$mobile_no = $_POST['mobile_no'];
	$email_id = $_POST['email_id'];
	$password = $_POST['password'];
	
	
	if($mobile_no !="" && $email_id !="" && $password !="")
	{
		$password_enc = $connection->enc_data($password);
		$rows = array('email_id'=>$email_id,'active'=>'y', 'active_date' => $connection->get_date() , 'password' => $password_enc);
		$where = " mobile_number ='".trim($mobile_no). "' and email_id is null  and password is null ";
		$update_password = $connection->update_data('customer_master',$rows,$where);
		if($update_password)
			echo 'success';
	}

?>