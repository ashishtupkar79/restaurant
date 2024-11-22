<?php
	session_start();
	include ('db_connect.php');
	$connection = new createConnection(); //i created a new object
	
	
	$connection = new createConnection(); //i created a new object
	$cust_login = $_POST['cust_login'];
	$password = $_POST['password'];
	if($cust_login =="" ||  $password =="" )
	{
		echo 'Error~error';
		exit;
	}
	if($cust_login !="" && $password !="")
	{
			$where = " (email_id = '$cust_login' or mobile_number = '$cust_login') and active ='y' ";
			$results=$connection->get_data("customer_master","fname,lname,email_id,address1,address2,address3,mobile_number,active,password",$where,null);
			foreach($results as $usrinfo)
			{
				$exists = false;
				if(strlen($usrinfo['active'])>0)
				{
					$password_dec = $connection->dec_data($usrinfo['password']);
					$exists = true;
				}
			}

			
			if($exists)
			{
				if($password_dec==$password)
				{
					$_SESSION['email_id'] = $usrinfo['email_id'];
					$_SESSION['mobile_number'] = $usrinfo['mobile_number'];
					$_SESSION['login_tag'] = 'registered';
					$_SESSION['login_verified'] = 'y';
					echo  'success';
				}
				else
					echo 'error';
			}
			else
				echo 'error';
	}
?>