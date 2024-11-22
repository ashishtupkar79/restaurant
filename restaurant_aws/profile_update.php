<?php
	session_start();
	include ('db_connect.php');
    $connection = new createConnection(); //i created a new object

	

	$firstname					= $_POST['firstname_order'];
	$lastname					= $_POST['lastname_order'];
	$mobile						= $_POST['mob_order'];
	$email							= $_POST['email_order'];
	$delivery_address1	= $_POST['delivery_address1'];
	$delivery_address2	= $_POST['delivery_address2'];
	$delivery_address3	= $_POST['delivery_address3'];
	
	
		$rows = array('fname' => $firstname,'lname' => $lastname,'email_id' => $email,'address1' => $delivery_address1,'address2' => $delivery_address2,'address3' => $delivery_address3);
		$where = " mobile_number ='".trim($mobile)."' and active='y' ";
		$update_profile = $connection->update_data('customer_master',$rows,$where);
		if($update_profile)
			echo 'Update Profile Successfully';
		else
			echo 'Error for updating the profile';

?>