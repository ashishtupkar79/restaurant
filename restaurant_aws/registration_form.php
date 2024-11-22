<?php
 session_start();
  include ('smtp.php');
 include ('db_connect.php');
 $connection = new createConnection(); //i created a new object
 $fname = $_POST['fname'];
 $lname = $_POST['lname'];
 $email = $_POST['email'];
 $mobile_number = $_POST['mobile_number'];
 $address1 = $_POST['address1'];
 $address2 = $_POST['address2'];
 $address3 = $_POST['address3'];

$password = $_POST['reg_password1'];

//print_r($_POST);
if($fname =="" || $lname =="" || $mobile_number ==""  ||  $email =="" ||  $password ==""  || $_POST['reg_password2'] ==""  || $_POST['address1'] =="" || $_POST['address2'] =="" || $_POST['address3'] =="")
	{
		echo 'Error~error';
		exit;
	}


$type="success";
if(trim($password) !=trim($_POST['reg_password2']))
{
	//$msg='Passwords must match';
	$msg='Passwords for  do not match';
	$type="error";
}

	$where="";
	if($type=="success")
	{
		$where = " email_id = '$email' or mobile_number = '$mobile_number' ";
		$results=$connection->get_data("customer_master","email_id,mobile_number",$where,null);
		foreach($results as $usrinfo)
		{
			if(strlen($usrinfo['email_id'])>0)
			{
				$type="error";
				$username=$usrinfo['email_id'];
			}
			else if(strlen($usrinfo['mobile_number'])>0)
			{
				$type="error";
				$username=$usrinfo['mobile_number'];
			}
		}
	}
	if($type=="error")
	{
		$msg= $username.' already exists as a zaikart user';
		$type="error";
	}



	if($type=="success")
	{
		$password_enc = $connection->enc_data($password);
		$ses_id= $connection->createRandomVal(30);
		$values=array($fname,$lname,$email,$mobile_number, $address1, $address2, $address3,$password_enc,$ses_id);
		if($connection->insert_data("customer_master",$values,"fname,lname,email_id,mobile_number,address1,address2,address3,password,session_id"))
		{
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
				$protocol = 'https://';
			else
				$protocol = 'http://';

			$site_link=$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
			$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/useractivate.php?mobile_number=" . urlencode($mobile_number) . "&ses_id=" . urlencode($ses_id) ;

			$active_link ='<a href="'.$active_link.'">'.$active_link.'</a>';

			$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/images/logo.jpg";
			$date = new DateTime("now", new DateTimeZone('Asia/Kolkata') );
			//$body='<img src="'.$img_src.'" alt="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.date("F j, Y").'<br><br><br>';
			$body='<img src="'.$img_src.'" alt="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$date->format("F j, Y").'<br><br><br>';
			$body .= "Hi " . ucfirst($name) . ",<br><br>Welcome to Zaikart!<br><br>Please click on the below link to confirm your email address and to activate your ZAikart user account.<br><br>";
			$body .= $active_link."<br><br>Once you have clicked on the above link, you will be able to login to Zaikart site and can start writing your reviews.<br><br>We look forward to your school reviews.<br><br>";
			//$body .='<a href="http://zaikart.com.au">http://schooliz.com.au</a><br><br><br>';
			$body .="Warmest Regards,<br>The Team at Zaikartz<br><br>";
			$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
			$body .='<a href="'.$site_link.'contactus.php">About Us</a> | ';
			$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
			//$body .="Terms of Use / Contact Us / Privacy policy ";
			$body .="<br> &#169; Zaikart 2016. All rights reserved";
			//echo $body;
			

		if (strpos($_SERVER['HTTP_HOST'], 'localhost') !== false || strpos($_SERVER['HTTP_HOST'], '192.9.4.') !== false || strpos($_SERVER['HTTP_HOST'], '103.19.89') !== false || strpos($_SERVER['HTTP_HOST'], 'emdoar.com') !== false) 
		{
					$smtpClient = new SMTPClient();
					$smtpClient->setServer("smtp.emergedata.in", "587", false);
					$smtpClient->setSender("naresh@emergedata.in", "naresh@emergedata.in","Naresh230777");
					$smtpClient->setMail($email,"Your Zaikart account activation link",$body);
					$smtpClient->sendMail();
		}
		else
		{
			//$from="noreply@zaikart.com.au";
			//$mail_password="ScHOol@159nOrePlY";
			$to= $email;
			$subject = "Your Zaikart account activation link";
			$headers = "MIME-Version: 1.0\r\n";
			$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
			$headers  .= "From: $from\r\n"; 
			mail($to,$subject,$body,$headers);
		}

			//$msg='Your Schooliz Account Activation link has been emailed to you';
			$msg='Zaikart user activation email has been sent to '.$email;
			$type="success";
		}
	
	}
echo $msg.'~'.$type;
?>
	