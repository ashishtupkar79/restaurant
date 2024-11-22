<?php
 session_start();
 include ('../db_connect.php');
 $connection = new createConnection(); //i created a new object


 if($_POST['submit_users'])
 {
	$username = $_POST['username'];
	$user_pwd = $_POST['user_pwd'];
	$fname = $_POST['name'];
	$status = $_POST['status'];

	if($_POST['submit_users'] == 'Add User')
	 {
		$type="success";
		$where="";
		if($type=="success")
		{
			$where = " user_id = '$username' and user_type='operator' ";
			$results=$connection->get_data("admin_users","user_id",$where,null);
			foreach($results as $usrinfo)
			{
				if(strlen($usrinfo['user_id'])>0)
				{
					$type="error";
					$username=$usrinfo['user_id'];
				}
			}
		}
		if($type=="error")
		{
			$msg= $username.' already exists as a user';
			$type="error";
		}
		if($type=="success")
		{
			$password_enc = $connection->enc_data($user_pwd);
			$ses_id= $connection->createRandomVal(30);
			$user_rights="Orders!orders.php@Process Today''s  Orders~order_history.php@Order History^";
			$operator = 'operator';
			$values=array($username,$password_enc,$fname,$user_rights,$operator,$status);
			if($connection->insert_data("admin_users",$values,"user_id,user_password,name,user_rights,user_type,status"))
			{
				$msg='Admin user  has been added ';
				$type="success";
			}
		}
		echo $msg.'~'.$type;
		exit;
	 }


	 if($_POST['submit_users'] == 'Modify User')
	 {
		$where="";
		$where = " user_id = '$username' and user_type='operator' ";
		$results=$connection->get_data("admin_users","user_id",$where,null);
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['user_id'])>0)
			{
				$rows = array('name'=>$fname,'status'=>$status);
				
				$where = " user_id = '$username' and user_type='operator' ";
				if($connection->update_data('admin_users',$rows,$where))
				{
					$type="success";
					$msg='Modify User Record';
					$type="success";
					echo $msg.'~'.$type;
					exit;
				}
				else
				{
					$type=="error";
				}
			}
			else
			{
				$type="error";
			}
		}
		
		if($type=="error")
		{
			$msg= ' Something goes wrong';
			$type="error";
			echo $msg.'~'.$type;
			exit;
		}
		
		
	 }
 }
?>
	