<?php
 session_start();
 include ('db_connect.php');
 $connection = new createConnection(); //i created a new object
 $email = $_POST['reset_email_id'];
function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[rand(0, $max)];
    }
    return $str;
}

if($email =="" )
{
	echo 'Error~error';
	exit;
}

if(isset($_POST['reset_email_id']) && $_POST['reset_email_id'] != '')
{
	$where = " email_id = '$email' and active in('y' , 'n') ";
	$results=$connection->get_data("customer_master","concat(fname, ' ', lname) AS name,password,email_id,active",$where,null);
	$exist = false;
	foreach($results as $usrinfo)
	{
		$exist= true;
		$name=$usrinfo['name'];
		$password=$usrinfo['email_password'];
		$email=$usrinfo['email_id'];
	}
	if($exist)
	{
		if($usrinfo['active']=='y' || $usrinfo['active']=='n')
		{
			//$password = random_str(8);
			$ses_id= $connection->createRandomVal(30);
			$rows = array('session_id' => $ses_id);
			$where = " email_id='".$email."'  and  active in('y') and active_date is not null ";
			$update_password = $connection->update_data('customer_master',$rows,$where);
			if($update_password)
			{
				/* Mail*/
				$body="";
				if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') 
					$protocol = 'https://';
				else
					$protocol = 'http://';

				$active_link =$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/index.php?email_id=" . urlencode($email) . "&ses_id=" . urlencode($ses_id)."&password_reset=y" ;

				//$active_link='<a href="'.$active_link.'">'.$active_link.'</a>';

				$active_link='<a href="'.$active_link.'" style="background: #fff none repeat scroll 0 0;font-size: 16px;cursor: pointer;border: medium none;border-radius: 3px;color: #265F84;cursor: pointer; display: block;font-family: inherit;font-size: 12px;font-weight: bold;margin-bottom: 5px;outline: medium none; padding: 12px 20px;text-align: center; text-transform: uppercase;transition: all 0.3s ease 0s;text-decoration:none;border: 1px solid #708AA5;width:25%"><b>Reset&nbsp;Password</b></a>';

				//$img_src=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/img/zaikart_logo.png";
				$site_link=$protocol.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF'])."/";
				
				

				/*$body .= "Hi " . ucfirst($name) . ",<br><br>You recently requested us that you had forgotten your Zaikart user password<br><br>Please click on the below link and change you password<br><br>";
				$body .= $active_link."<br><br>Your user login will be your email address<br><br>If you are unable to click on the link you will need to copy and paste the personalized link in your browser.<br><br>For questions or concerns regarding your Zaikart user account, please visit our Contact us page.<br><br>";*/

				$body.="Dear " . ucfirst($name) . ",<br><br>We got a request to reset your Zaikart password<br><br>";
				$body .= $active_link."<br><br>If you ignore this message, your password won't be changed.<br><br>If you didn't request a password reset, <a href='https://www.zaikart.com/contactus.php'>let us know</a>.<br><br>";


				$body .="Warmest Regards,<br>The Team at Zaikart<br><br>";
				$body .='<a href="'.$site_link.'terms.php">Terms of Use</a> | ';
				$body .='<a href="'.$site_link.'aboutus.php">About Us</a> | ';
				$body .='<a href="'.$site_link.'privacy.php">Privacy Policy</a> ';
				$body .="<br> &#169; Zaikart 2016. All rights reserved";
				$to= $email;
				$from="noreply@zaikart.com";
				$sendermail=$from;
				$subject = "Change your Zaikart password";
				$message =$body;
				$headers = "MIME-Version: 1.0\r\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
				$headers  .= "From: $from\r\n"; 
				mail($to, $subject, $message, $headers); 
				/* Mail Ends Here*/
				$msg="An Email will be sent to you in next few minutes. follow the instructions on the email for changing your password";
			}
		}
		else
		{
			$msg=$email." doesn't match any user";
		}
	}
	else
	{
		$msg= $email." doesn't match any user";
	}
}
echo $msg;
?>
	